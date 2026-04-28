<?php
// 1. VERİTABANI BAĞLANTISI VE AYARLAR
require_once 'baglan.php';
require_once 'gizli_ayarlar.php'; // API Key buradan çekilecek

// Pandascore kotasını kontrol etmek ve profesyonel bağlantı kurmak için ayarlar
$api_token = PANDASCORE_API_KEY; 
$api_url = "https://api.pandascore.co/matches?filter[status]=running,not_started,finished&sort=-modified_at&per_page=50";

// 2. PROFESYONEL CURL BAĞLANTISI
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_USERAGENT, 'GamePortalBot/1.0 (XAMPP; Development)'); // Bot kimliği
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Accept: application/json',
    'Authorization: Bearer ' . $api_token // Token artık burada, Header'da gidiyor
]);

$response = curl_exec($ch);
$curl_hata = curl_error($ch);
curl_close($ch);

// 3. HATA KONTROLLERİ (GERÇEK HATAYI YÜZÜMÜZE VURUR)
if ($response === false) {
    die("🔥 BAĞLANTI HATASI: " . $curl_hata);
}

$maclar = json_decode($response, true);

if ($maclar === null) {
    die("🔥 JSON HATASI (API hatalı yanıt döndürdü): <br>" . htmlspecialchars($response));
}

if (isset($maclar['error'])) {
    die("🔥 PANDASCORE REDDETTİ: " . ($maclar['message'] ?? 'Bilinmeyen Hata'));
}

// 4. VERİLERİ DÖNGÜYE AL VE VERİTABANINA YAZ
$sayac = 0;
foreach ($maclar as $mac) {
    if (count($mac['opponents']) < 2) continue;

    // Oyun ismini sisteme uyarla
    $api_oyun = strtolower($mac['videogame']['slug']);
    $oyun = $api_oyun;
    if ($api_oyun == 'cs-go') $oyun = 'cs2';
    if ($api_oyun == 'league-of-legends') $oyun = 'lol';
    if ($api_oyun == 'dota-2') $oyun = 'dota';

    if (!in_array($oyun, ['cs2', 'valorant', 'lol', 'dota'])) continue;

    // Maç detayları
    $lig = mb_strtoupper($mac['league']['name'], 'UTF-8');
    $ev_sahibi = $mac['opponents'][0]['opponent']['name'];
    $ev_sahibi_logo = $mac['opponents'][0]['opponent']['image_url'] ?? '../img/varsayilan_logo.png'; 
    $deplasman = $mac['opponents'][1]['opponent']['name'];
    $deplasman_logo = $mac['opponents'][1]['opponent']['image_url'] ?? '../img/varsayilan_logo.png'; 
    
    $saat_formatli = date("H:i", strtotime($mac['begin_at'] . " +3 hours"));

    // Durum analizi
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

    // Veritabanı işlemleri
    $kontrolSorgu = $db->prepare("SELECT id FROM canli_skor WHERE ev_sahibi = ? AND deplasman = ? AND oyun = ?");
    $kontrolSorgu->execute([$ev_sahibi, $deplasman, $oyun]);
    $mevcutMac = $kontrolSorgu->fetch(PDO::FETCH_ASSOC);

    if ($mevcutMac) {
        $guncelle = $db->prepare("UPDATE canli_skor SET durum = ?, skor = ?, periyot = ?, saat = ?, ev_sahibi_logo = ?, deplasman_logo = ? WHERE id = ?");
        $guncelle->execute([$durum, $skor, $periyot, $saat_formatli, $ev_sahibi_logo, $deplasman_logo, $mevcutMac['id']]);
    } else {
        $ekle = $db->prepare("INSERT INTO canli_skor (oyun, lig, saat, durum, ev_sahibi, skor, deplasman, periyot, ev_sahibi_logo, deplasman_logo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $ekle->execute([$oyun, $lig, $saat_formatli, $durum, $ev_sahibi, $skor, $deplasman, $periyot, $ev_sahibi_logo, $deplasman_logo]);
    }
    $sayac++;
}

echo "GAMEPORTAL: $sayac adet maç ve logo başarıyla senkronize edildi!";
?>