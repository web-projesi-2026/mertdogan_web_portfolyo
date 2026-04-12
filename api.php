<?php
require_once 'baglan.php'; 

header('Content-Type: application/json; charset=utf-8');

// 1. JS'den gelen 'platform' bilgisini yakalıyoruz
$platform = isset($_GET['platform']) ? $_GET['platform'] : null;

// 2. Sorguyu hazırlıyoruz
if ($platform) {
    // Eğer platform seçilmişse: Sadece o platformu içerenleri getir
    // (LIKE kullanıyoruz çünkü bir haber birden fazla platformda olabilir)
    $sql = "SELECT * FROM haberler WHERE platform LIKE :plt ORDER BY id DESC";
    $sorgu = $db->prepare($sql);
    $sorgu->execute(['plt' => "%$platform%"]);
} else {
    // Eğer platform yoksa: Tüm haberleri getir (Ana sayfa)
    $sql = "SELECT * FROM haberler ORDER BY id DESC";
    $sorgu = $db->query($sql);
}

// 3. Verileri JSON olarak döndürüyoruz
if ($sorgu->rowCount() > 0) {
    $haber_listesi = $sorgu->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($haber_listesi);
} else {
    echo json_encode([]); 
}
?>