<?php
session_start();
require_once 'baglan.php';
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $kullanici = trim($_POST['kullanici_adi']);
    $sifre = $_POST['sifre'];

    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE kullanici_adi = ?");
    $sorgu->execute([$kullanici]);
    $user = $sorgu->fetch();

    if ($user && password_verify($sifre, $user['sifre'])) {
        session_regenerate_id(true);
        $_SESSION['oturum_acildi'] = true;
        $_SESSION['kullanici_id'] = $user['id'];
        $_SESSION['kullanici_adi'] = $user['kullanici_adi'];
        $_SESSION['eposta'] = $user['eposta'];
        $_SESSION['rol'] = $user['rol'];
        
        echo json_encode(["status" => "success", "role" => $user['rol']]);
    } else {
        echo json_encode(["status" => "error", "message" => "Kullanıcı adı veya şifre hatalı!"]);
    }
}
?>