<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (isset($_SESSION['oturum_acildi']) && $_SESSION['oturum_acildi'] === true) {
    echo json_encode([
        "logged_in" => true,
        "kullanici_adi" => isset($_SESSION['kullanici_adi']) ? $_SESSION['kullanici_adi'] : 'Bilinmiyor',
        "eposta" => isset($_SESSION['eposta']) ? $_SESSION['eposta'] : 'Belirtilmemiş',
        "rol" => isset($_SESSION['rol']) ? $_SESSION['rol'] : 'kullanici'
    ]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>