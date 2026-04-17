<?php
require_once 'baglan.php'; 
header('Content-Type: application/json; charset=utf-8');

// Canlı skorları çek (Önce Canlı olanları, sonra saatine göre sırala)
$sql = "SELECT * FROM canli_skor ORDER BY CASE durum WHEN 'CANLI' THEN 1 WHEN 'BAŞLAMADI' THEN 2 WHEN 'MS' THEN 3 END ASC, saat ASC";
$sorgu = $db->query($sql);

if ($sorgu->rowCount() > 0) {
    $skorlar = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($skorlar);
} else {
    echo json_encode([]); 
}
?>