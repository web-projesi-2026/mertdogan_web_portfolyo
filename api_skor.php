<?php
require_once 'baglan.php'; 
header('Content-Type: application/json; charset=utf-8');

// Canlı skorları çek (Önce Canlı olanları, sonra saatine göre sırala)
$sql = "SELECT * FROM canli_skor ORDER BY durum DESC, saat ASC";
$sorgu = $db->query($sql);

if ($sorgu->rowCount() > 0) {
    $skorlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($skorlar);
} else {
    echo json_encode([]); 
}
?>