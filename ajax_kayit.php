<?php
require_once 'baglan.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici = trim($_POST['kullanici_adi']);
    $sifre = $_POST['sifre'];

    $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ?");
    $kontrol->execute([$kullanici]);
    
    if ($kontrol->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Bu kullanıcı adı zaten alınmış!"]);
    } else {
        $hashed_sifre = password_hash($sifre, PASSWORD_DEFAULT);
        $ekle = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, sifre, rol) VALUES (?, ?, 'kullanici')");
        if ($ekle->execute([$kullanici, $hashed_sifre])) {
            echo json_encode(["status" => "success", "message" => "Kayıt başarılı! Şimdi giriş yapabilirsiniz."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Kayıt sırasında hata oluştu."]);
        }
    }
}
?>