<?php
// Veritabanı bilgileri
$host = 'localhost';
$dbname = 'gameportal_db'; // Kendi veritabanı adınla değiştir
$kullanici = 'root'; 
$sifre = ''; // XAMPP kullanıyorsan genelde boştur. 

try {
    // PDO ile bağlantı kurma
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $kullanici, $sifre);
    
    // Hata modunu aktifleştirme
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    // Geçmişte "Access denied" gibi bağlantı veya yetki hataları yaşanabiliyor, 
    // bu blok o hataların sebebini ekrana yazdırır.
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>