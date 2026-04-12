<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

if (isset($_SESSION['oturum_acildi']) && $_SESSION['oturum_acildi'] === true) {
    echo json_encode([
        "logged_in" => true,
        "kullanici_adi" => $_SESSION['kullanici_adi'],
        "rol" => $_SESSION['rol']
    ]);
} else {
    echo json_encode(["logged_in" => false]);
}
?>