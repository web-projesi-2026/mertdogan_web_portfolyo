<?php 
    $yol = "../"; 
    $sayfa = "hmoyunlar"; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - Oyunlar</title>
    <link rel="stylesheet" href="../assets/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
    
    <style>
        .hm-sayfa-container {
            padding: 40px 20px;
            max-width: 1000px;
            margin: 0 auto;
            min-height: 70vh;
        }
        /* Resimdeki o şık, etrafı çerçeveli başlık tasarımı */
        .hm-baslik {
            color: #fff;
            font-family: 'Oswald', sans-serif;
            text-align: center;
            letter-spacing: 2px;
            margin-bottom: 40px;
            font-size: 14px;
            border: 1px solid #333;
            padding: 10px 35px;
            border-radius: 8px;
            display: inline-block;
            background: #111;
        }
        .kategori-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }
        /* Resimdeki kutuların birebir aynısı */
        .kategori-kart {
            background: #141414; 
            border: 1px solid #222; 
            border-radius: 10px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            gap: 20px;
            width: 100%;
            max-width: 250px; 
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            font-size: 13px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }
        .kategori-kart:hover {
            border-color: #b76bff;
            background: rgba(183,107,255,0.05);
            transform: translateY(-3px); /* Üzerine gelince hafifçe yukarı kalkar */
        }
        .kategori-logo {
            width: 35px;
            height: 35px;
            object-fit: contain;
            filter: drop-shadow(0 2px 5px rgba(0,0,0,0.5));
        }
        /* Telefonda kutuların ekrana tam yayılması için */
        @media (max-width: 600px) {
            .kategori-kart { max-width: 100%; } 
        }
    </style>
</head>
<body>
    
<?php include '../header.php'; ?>

<?php 
    // Veritabanındaki "oyunlar" tablosundan tüm oyunları alfabetik çekiyoruz
    $oyunSorgu = $db->prepare("SELECT * FROM oyunlar ORDER BY isim ASC");
    $oyunSorgu->execute();
    $dbOyunlar = $oyunSorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<main class="hm-sayfa-container">
    
    <div style="text-align: center;">
        <h2 class="hm-baslik">OYUNLAR</h2>
    </div>
    
    <div class="kategori-grid">
        <?php if(count($dbOyunlar) > 0): ?>
            <?php foreach($dbOyunlar as $oyun): ?>
                <a href="platform.php?p=<?php echo urlencode($oyun['isim']); ?>" class="kategori-kart">
                    <img src="../img/logolar/<?php echo $oyun['logo']; ?>" alt="<?php echo $oyun['isim']; ?>" class="kategori-logo" onerror="this.src='../img/logolar/default.png'">
                    <span><?php echo mb_strtoupper($oyun['isim'], 'UTF-8'); ?></span>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: #555; text-align: center; width: 100%; font-size: 14px;">Sistemde henüz kayıtlı oyun bulunmuyor.</p>
        <?php endif; ?>
    </div>
    
</main>

<?php include $yol . 'modal.php'; ?>
<script src="../assets/script.js"></script>
</body>
</html>