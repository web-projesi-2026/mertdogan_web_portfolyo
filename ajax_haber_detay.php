<?php
require_once 'baglan.php';
header('Content-Type: application/json; charset=utf-8');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sorgu = $db->prepare("SELECT * FROM haberler WHERE id = ?");
    $sorgu->execute([$id]);
    $haber = $sorgu->fetch(PDO::FETCH_ASSOC);

    if ($haber) {
        echo json_encode(["status" => "success", "data" => $haber]);
    } else {
        echo json_encode(["status" => "error", "message" => "Haber bulunamadı."]);
    }
}
?>