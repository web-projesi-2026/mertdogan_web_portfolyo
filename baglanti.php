<?php
$host = 'localhost';
$dbname = 'gameportal_db'; // Oluşturduğumuz veritabanı adı
$username = 'root';        // XAMPP için varsayılan kullanıcı adı root'tur
$password = '';            // XAMPP için varsayılan şifre boştur

try {
    // Veritabanı bağlantısını başlatıyoruz
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Hata modunu aktifleştiriyoruz ki bir sorun olursa görebilelim
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // Bağlantı başarısız olursa ekrana hata yazdır
    echo "Veritabanı bağlantı hatası: " . $e->getMessage();
    exit;
}
?>