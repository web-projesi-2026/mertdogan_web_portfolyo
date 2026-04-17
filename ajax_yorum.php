<?php
session_start();
require_once 'baglan.php';
header('Content-Type: application/json; charset=utf-8');

// YORUM EKLEME (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['oturum_acildi'])) {
        echo json_encode(["status" => "error", "message" => "Yorum yapmak için giriş yapmalısınız!"]);
        exit;
    }
    $haber_id = $_POST['haber_id'];
    $yorum = trim($_POST['yorum']);
    $yazan_kisi = $_SESSION['kullanici_adi'];

    if(!empty($yorum)){
        $db->prepare("INSERT INTO yorumlar (haber_id, yazan_kisi, yorum) VALUES (?, ?, ?)")->execute([$haber_id, $yazan_kisi, $yorum]);
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Yorum boş olamaz!"]);
    }
} 
// YORUMLARI ÇEKME (GET)
else if (isset($_GET['haber_id'])) {
    $haber_id = $_GET['haber_id'];
    // Yorumu yazan kişinin rolünü de getirmek için tabloları birleştiriyoruz (JOIN)
    $sorgu = $db->prepare("SELECT y.*, k.rol FROM yorumlar y LEFT JOIN kullanicilar k ON y.yazan_kisi = k.kullanici_adi WHERE y.haber_id = ? ORDER BY y.id DESC");
    $sorgu->execute([$haber_id]);
    echo json_encode($sorgu->fetchAll(PDO::FETCH_ASSOC));
}
?>