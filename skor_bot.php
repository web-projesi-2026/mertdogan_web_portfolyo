<?php
// Veritabanı bağlantısı
require_once 'baglan.php';

// PANDASCORE API ANAHTARIN (Buraya kendi anahtarını yapıştır)
$api_token = "mHsOK5kpJAokNTrC9LmJmpwiy-tWF7TygGFzIiopadFpymZz7Og";

// Son güncellenen, canlı oynanan veya henüz başlamayan en yeni 50 maçı çeker
$api_url = "https://api.pandascore.co/matches?filter[status]=running,not_started,finished&sort=-modified_at&per_page=50&token=" . $api_token;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($ch);
curl_close($ch);

$maclar = json_decode($response, true);

if (!$maclar || isset($maclar['error'])) {
    die("API'den veri çekilemedi veya kota doldu.");
}

// Gelen maçları tek tek döngüye al ve veritabanına uyarla
foreach ($maclar as $mac) {
    // Sadece 2 takımın belli olduğu maçları al (Belirsiz TBD maçlarını atla)
    if (count($mac['opponents']) < 2) continue;

    // 1. OYUN İSMİNİ SENİN SİSTEMİNE UYARLA
    $api_oyun = strtolower($mac['videogame']['slug']);
    $oyun = $api_oyun;
    if ($api_oyun == 'cs-go') $oyun = 'cs2';
    if ($api_oyun == 'league-of-legends') $oyun = 'lol';
    if ($api_oyun == 'dota-2') $oyun = 'dota';

    // Sadece senin sisteminde olan oyunları kabul et
    if (!in_array($oyun, ['cs2', 'valorant', 'lol', 'dota'])) continue;

    // 2. MAÇ DETAYLARI
    $lig = mb_strtoupper($mac['league']['name'], 'UTF-8');
    $ev_sahibi = $mac['opponents'][0]['opponent']['name'];
    $deplasman = $mac['opponents'][1]['opponent']['name'];
    
    // Saati Türkiye saatine (UTC+3) uyarlamak için
    $saat_formatli = date("H:i", strtotime($mac['begin_at'] . " +3 hours"));

    // 3. DURUM VE SKOR ANALİZİ
    if ($mac['status'] == 'running') {
        $durum = 'CANLI';
        $skor1 = $mac['results'][0]['score'] ?? 0;
        $skor2 = $mac['results'][1]['score'] ?? 0;
        $skor = $skor1 . " - " . $skor2;
        $periyot = "Canlı Oynanıyor";
    } elseif ($mac['status'] == 'finished') {
        $durum = 'MS';
        $skor1 = $mac['results'][0]['score'] ?? 0;
        $skor2 = $mac['results'][1]['score'] ?? 0;
        $skor = $skor1 . " - " . $skor2;
        $periyot = "Maç Sonu";
    } else {
        $durum = 'BAŞLAMADI';
        $skor = 'v';
        $periyot = "Bekleniyor";
    }

    // 4. VERİTABANI İŞLEMLERİ (Maç varsa güncelle, yoksa ekle)
    $kontrolSorgu = $db->prepare("SELECT id FROM canli_skor WHERE ev_sahibi = ? AND deplasman = ? AND oyun = ?");
    $kontrolSorgu->execute([$ev_sahibi, $deplasman, $oyun]);
    $mevcutMac = $kontrolSorgu->fetch(PDO::FETCH_ASSOC);

    if ($mevcutMac) {
        // Maç zaten varsa sadece güncel skorunu ve durumunu yenile
        $guncelle = $db->prepare("UPDATE canli_skor SET durum = ?, skor = ?, periyot = ?, saat = ? WHERE id = ?");
        $guncelle->execute([$durum, $skor, $periyot, $saat_formatli, $mevcutMac['id']]);
    } else {
        // Maç yoksa yepyeni bir maç olarak sisteme ekle
        $ekle = $db->prepare("INSERT INTO canli_skor (oyun, lig, saat, durum, ev_sahibi, skor, deplasman, periyot) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $ekle->execute([$oyun, $lig, $saat_formatli, $durum, $ev_sahibi, $skor, $deplasman, $periyot]);
    }
}

echo "GAMEPORTAL: Maçlar başarıyla senkronize edildi!";
?>