<?php
require_once 'baglanti.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sorgu = $db->prepare("SELECT * FROM haberler WHERE id = ?");
$sorgu->execute([$id]);
$haber = $sorgu->fetch(PDO::FETCH_ASSOC);

if (!$haber) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($haber['baslik']) ?> - GamePortal</title>
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
        <section class="detay-alani">
            <span class="etiket"><?= htmlspecialchars($haber['tur']) ?></span>
            <br><br>
            
            <h1 class="detay-baslik"><?= htmlspecialchars($haber['baslik']) ?></h1>
            <span class="tarih">Yayınlanma Tarihi: <?= htmlspecialchars($haber['tarih']) ?></span>
            <hr style="border:1px solid #333; margin: 20px 0;">

            <img src="<?= htmlspecialchars($haber['resim']) ?>" alt="Haber Görseli" class="detay-resim">

            <div class="detay-icerik">
                <p><?= nl2br(htmlspecialchars($haber['icerik'])) ?></p>
            </div>
            
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>