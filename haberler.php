<?php
require_once 'baglanti.php';

// Tüm haberleri çekiyoruz (JS hangisini göstereceğine karar verecek)
$sorgu = $db->query("SELECT * FROM haberler ORDER BY id DESC", PDO::FETCH_ASSOC);

if ($sorgu->rowCount() > 0) {
    foreach ($sorgu as $haber) {
        // Kartın temel yapısını oluşturuyoruz
        // data-platform özelliğini ekledik ki JS filtreleme yapabilsin
        echo '<a href="haber_detay.php?id=' . $haber["id"] . '" 
                 class="haber-karti" 
                 data-kategori="' . htmlspecialchars($haber["kategori"]) . '" 
                 data-platform="' . htmlspecialchars($haber["platform"]) . '">';
        
        echo '  <div class="kart-resim" style="background-image: url(\'' . htmlspecialchars($haber["resim"]) . '\');"></div>';
        echo '  <div class="kart-icerik">';
        
        // Etiket renk mantığı
        $etiket_renk = "";
        if ($haber["tur"] == "İndirim") $etiket_renk = "background-color: #ffaa00; color: #000;";
        else if ($haber["tur"] == "Ücretsiz Oyun") $etiket_renk = "background-color: #00ff88; color: #000;";
        
        echo '      <span class="etiket" style="' . $etiket_renk . '">' . htmlspecialchars($haber["tur"]) . '</span>';
        echo '      <h3>' . htmlspecialchars($haber["baslik"]) . '</h3>';
        echo '      <p class="kart-ozet">' . htmlspecialchars($haber["ozet"]) . '</p>';
        echo '      <div class="kart-alt"><span class="tarih">' . htmlspecialchars($haber["tarih"]) . '</span></div>';
        echo '  </div>';
        echo '</a>';
    }
} else {
    echo "<p>Henüz haber eklenmemiş.</p>";
}
?>