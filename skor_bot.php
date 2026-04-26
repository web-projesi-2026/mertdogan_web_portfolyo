<?php
// Veritabanı bağlantısı
require_once 'baglan.php';

// PANDASCORE API ANAHTARIN
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

    if (!in_array($oyun, ['cs2', 'valorant', 'lol', 'dota'])) continue;

    // 2. MAÇ DETAYLARI VE OTOMATİK LOGO LİNKLERİ
    $lig = mb_strtoupper($mac['league']['name'], 'UTF-8');
    
    $ev_sahibi = $mac['opponents'][0]['opponent']['name'];
    // API'den logoyu çekiyoruz, yoksa varsayılan bir görsel atıyoruz
    $ev_sahibi_logo = $mac['opponents'][0]['opponent']['image_url'] ?? '../img/varsayilan_logo.png'; 
    
    $deplasman = $mac['opponents'][1]['opponent']['name'];
    // API'den logoyu çekiyoruz, yoksa varsayılan bir görsel atıyoruz
    $deplasman_logo = $mac['opponents'][1]['opponent']['image_url'] ?? '../img/varsayilan_logo.png'; 
    
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

    // 4. VERİTABANI İŞLEMLERİ (Maç varsa güncelleyip logoları ekle, yoksa tamamen yeni ekle)
    $kontrolSorgu = $db->prepare("SELECT id FROM canli_skor WHERE ev_sahibi = ? AND deplasman = ? AND oyun = ?");
    $kontrolSorgu->execute([$ev_sahibi, $deplasman, $oyun]);
    $mevcutMac = $kontrolSorgu->fetch(PDO::FETCH_ASSOC);

    if ($mevcutMac) {
        // Logoları da UPDATE sorgusuna dahil ettik
        $guncelle = $db->prepare("UPDATE canli_skor SET durum = ?, skor = ?, periyot = ?, saat = ?, ev_sahibi_logo = ?, deplasman_logo = ? WHERE id = ?");
        $guncelle->execute([$durum, $skor, $periyot, $saat_formatli, $ev_sahibi_logo, $deplasman_logo, $mevcutMac['id']]);
    } else {
        // Yeni sütunları INSERT sorgusuna dahil ettik
        $ekle = $db->prepare("INSERT INTO canli_skor (oyun, lig, saat, durum, ev_sahibi, skor, deplasman, periyot, ev_sahibi_logo, deplasman_logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $ekle->execute([$oyun, $lig, $saat_formatli, $durum, $ev_sahibi, $skor, $deplasman, $periyot, $ev_sahibi_logo, $deplasman_logo]);
    }
}

echo "GAMEPORTAL: Maçlar ve Logolar başarıyla senkronize edildi!";
?>