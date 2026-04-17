<?php
session_start();
require_once 'baglan.php';
header('Content-Type: application/json');

if (!isset($_SESSION['kullanici_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Oturum bulunamadı.']);
    exit;
}

$eski_sifre = $_POST['eski_sifre'] ?? '';
$yeni_sifre = $_POST['yeni_sifre'] ?? '';

try {
    $sorgu = $db->prepare("SELECT sifre FROM kullanicilar WHERE id = ?");
    $sorgu->execute([$_SESSION['kullanici_id']]);
    $kullanici = $sorgu->fetch(PDO::FETCH_ASSOC);

    // Hash'li şifreyi doğrulamak için password_verify şarttır
    if (!password_verify($eski_sifre, $kullanici['sifre'])) {
        echo json_encode(['status' => 'error', 'message' => 'Eski şifreniz yanlış.']);
        exit;
    }

    // Yeni şifreyi tekrar güvenli şekilde hashliyoruz
    $yeni_hash = password_hash($yeni_sifre, PASSWORD_DEFAULT);
    $guncelle = $db->prepare("UPDATE kullanicilar SET sifre = ? WHERE id = ?");
    $guncelle->execute([$yeni_hash, $_SESSION['kullanici_id']]);

    echo json_encode(['status' => 'success', 'message' => 'Şifre güncellendi!']);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => 'Hata: ' . $e->getMessage()]);
}
?>