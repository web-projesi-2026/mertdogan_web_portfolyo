<?php
require_once 'baglan.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici = trim($_POST['kullanici_adi']);
    $eposta = trim($_POST['eposta']); 
    $sifre = $_POST['sifre'];

    // ATLAS DOKUNUŞU: Sıkı (Regex) E-Posta Kontrolü
    // Sadece @ işareti ve nokta değil, sonundaki uzantının 2 ila 6 harf arasında olmasını zorunlu kılar.
    if (!preg_match('/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/', $eposta)) {
        echo json_encode(["status" => "error", "message" => "Lütfen geçerli bir e-posta adresi girin! (Örn: isim@gmail.com)"]);
        exit; // Format yanlışsa işlemi anında durdurur
    }

    // Kullanıcı adı daha önce alınmış mı kontrolü
    $kontrol = $db->prepare("SELECT id FROM kullanicilar WHERE kullanici_adi = ?");
    $kontrol->execute([$kullanici]);

    if ($kontrol->rowCount() > 0) {
        echo json_encode(["status" => "error", "message" => "Bu kullanıcı adı zaten alınmış!"]);
    } else {
        $hashed_sifre = password_hash($sifre, PASSWORD_DEFAULT);
        
        $ekle = $db->prepare("INSERT INTO kullanicilar (kullanici_adi, eposta, sifre, rol) VALUES (?, ?, ?, 'kullanici')");
        
        if ($ekle->execute([$kullanici, $eposta, $hashed_sifre])) {
            echo json_encode(["status" => "success", "message" => "Kayıt başarılı! Şimdi giriş yapabilirsiniz."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Kayıt sırasında hata oluştu."]);
        }
    }
}
?>