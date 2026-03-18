<?php
require_once 'baglanti.php';
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İndirimler ve Ücretsiz Oyunlar - GamePortal</title>
    <link rel="stylesheet" href="style.css?v=9">
</head>
<body>

    <header>
        <div class="header-sol">
            <button id="menu-btn" class="menu-btn">☰</button>
            <div class="logo">
                <h1>Game<span>Portal</span></h1>
            </div>
        </div>
        
        <nav>
            <ul class="ust-menu">
                <li><a href="index.php">Ana Sayfa</a></li>
                
                <li class="dropdown">
                    <a href="index.php">Kategoriler ▼</a>
                    <ul class="dropdown-menu">
                        
                        <li class="dropdown-submenu">
                            <a href="index.php">PC ▸</a>
                            <ul class="submenu">
                                <li><a href="index.php">Tüm Haberler</a></li>
                                <li><a href="index.php">Güncellemeler</a></li>
                                <li><a href="index.php">Sektör Haberleri</a></li>
                                <li><a href="index.php">İncelemeler</a></li>
                                <li><a href="index.php">Rehberler</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a href="index.php">Konsol ▸</a>
                            <ul class="submenu">
                                <li><a href="index.php">Tüm Haberler</a></li>
                                <li><a href="index.php">Güncellemeler</a></li>
                                <li><a href="index.php">Sektör Haberleri</a></li>
                                <li><a href="index.php">İncelemeler</a></li>
                                <li><a href="index.php">Rehberler</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a href="index.php">Nintendo ▸</a>
                            <ul class="submenu">
                                <li><a href="index.php">Tüm Haberler</a></li>
                                <li><a href="index.php">Güncellemeler</a></li>
                                <li><a href="index.php">Sektör Haberleri</a></li>
                                <li><a href="index.php">İncelemeler</a></li>
                                <li><a href="index.php">Rehberler</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a href="index.php">Mobil ▸</a>
                            <ul class="submenu">
                                <li><a href="index.php">Tüm Haberler</a></li>
                                <li><a href="index.php">Güncellemeler</a></li>
                                <li><a href="index.php">Sektör Haberleri</a></li>
                                <li><a href="index.php">İncelemeler</a></li>
                                <li><a href="index.php">Rehberler</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                
                <li><a href="index.php">E-Spor</a></li>
                <li><a href="firsatlar.php" style="color: #ffaa00; font-weight: bold; text-shadow: 0 0 5px rgba(255,170,0,0.5);">🔥 Fırsatlar</a></li>
            </ul>
        </nav>
    </header>

    <div id="yan-menu" class="yan-menu">
        <button id="menu-kapat" class="menu-kapat">&times;</button>
        <h2>Menü</h2>
        <ul>
            <li><a href="index.php">Ana Sayfa</a></li>
            <li><a href="index.php">PC Oyunları</a></li>
            <li><a href="index.php">Konsol Haberleri</a></li>
            <li><a href="index.php">E-Spor</a></li>
            <hr>
            <li><a href="index.php">Haberler</a></li>
            <li><a href="index.php">Yama ve Güncellemeler</a></li>
            <li><a href="index.php">Sektör Haberleri</a></li>
            <li><a href="index.php">İncelemeler</a></li>
            <li><a href="index.php">Rehberler</a></li>
        </ul>
    </div>

    <main>
        <section class="haber-alani">
            <h2 style="color: #ffaa00; margin-bottom: 30px;">Haftanın Dev İndirimleri ve Bedava Oyunları</h2>
            
            <div class="haber-listesi">
                <?php
                $sorgu = $db->query("SELECT * FROM haberler WHERE kategori = 'firsat' ORDER BY id DESC", PDO::FETCH_ASSOC);

                if ($sorgu->rowCount() > 0) {
                    $ilk_haber = true; 
                    
                    foreach ($sorgu as $haber) {
                        $kart_sinifi = $ilk_haber ? "haber-karti manset-karti" : "haber-karti standart-karti";
                        
                        echo '<a href="haber_detay.php?id=' . $haber["id"] . '" class="' . $kart_sinifi . '">';
                        echo '  <div class="kart-resim" style="background-image: url(\'' . htmlspecialchars($haber["resim"]) . '\');"></div>';
                        echo '  <div class="kart-icerik">';
                        
                        $etiket_renk = ($haber["tur"] == "İndirim") ? "background-color: #ffaa00; color: #000;" : "background-color: #00ff88; color: #000;";
                        echo '      <span class="etiket" style="' . $etiket_renk . '">' . htmlspecialchars($haber["tur"]) . '</span>';
                        echo '      <h3>' . htmlspecialchars($haber["baslik"]) . '</h3>';
                        
                        if (!$ilk_haber) {
                            echo '  <p>' . htmlspecialchars($haber["ozet"]) . '</p>';
                        }
                        
                        echo '      <div class="kart-alt">';
                        echo '          <span class="tarih">' . htmlspecialchars($haber["tarih"]) . '</span>';
                        echo '      </div>';
                        echo '  </div>';
                        echo '</a>';
                        
                        $ilk_haber = false; 
                    }
                } else {
                    echo "<p>Şu an için aktif bir kampanya veya ücretsiz oyun bulunmuyor.</p>";
                }
                ?>
            </div>
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>