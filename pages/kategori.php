<?php 
    $yol = "../"; 
    $sayfa = "kategoriler"; 
    require_once $yol . 'baglan.php';

    // URL'den gelen kategori adını al (Boşsa İncelemeler say)
    $kategori = isset($_GET['k']) ? trim($_GET['k']) : 'İncelemeler';

    // Sadece bu kategoriye ait olan içerikleri çek
    $sorgu = $db->prepare("SELECT * FROM haberler WHERE kategori = ? ORDER BY id DESC");
    $sorgu->execute([$kategori]);
    $icerikler = $sorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - <?php echo htmlspecialchars($kategori); ?></title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
<?php include '../header.php'; ?>

<main style="min-height: 80vh; padding: 40px 20px; max-width: 1300px; margin: 0 auto; width: 100%; box-sizing: border-box;">
    
    <div class="title-card-wrapper" style="margin-bottom: 40px;">
        <h2 class="title-card-text">- <?php echo mb_strtoupper($kategori, 'UTF-8'); ?> -</h2>
    </div>

    <section id="kategori-listesi" class="news-container" style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center;">
        <?php if(count($icerikler) > 0): ?>
            <?php foreach($icerikler as $icerik): ?>
                <div class="news-row" style="--row-glow: #b76bff" onclick="window.location.href='haber-detay.php?id=<?php echo $icerik['id']; ?>'">
                    <img src="<?php echo (strpos($icerik['resim'], 'http') === 0) ? $icerik['resim'] : '../' . $icerik['resim']; ?>" class="row-img" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
                    <div class="row-info">
                        <h3><?php echo htmlspecialchars($icerik['baslik']); ?></h3>
                        <p class="row-ozet"><?php echo htmlspecialchars($icerik['ozet']); ?></p>
                        <div class="row-logo-container" style="color: #b76bff; font-size: 11px; font-weight: bold; border: 1px solid #b76bff; border-radius: 4px; padding: 4px 10px;">
                            OKU ➔
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="text-align: center; width: 100%; padding: 50px 0; color: #888;">
                <span class="red-dot" style="display:inline-block; margin-right:10px;">•</span>
                <h3 style="display:inline-block; color: #fff;">Bu kategoride henüz içerik bulunmuyor.</h3>
            </div>
        <?php endif; ?>
    </section>

</main>

<?php include $yol . 'modal.php'; ?>
<script src="../assets/script.js"></script>
</body>
</html>