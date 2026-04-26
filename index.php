<?php 
    $yol = ""; 
    $sayfa = "ana_sayfa"; 
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL</title>
    <link rel="stylesheet" href="assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    

    <main>
        <section class="hero-slider-container">
            <button class="slider-btn prev-btn">&#10094;</button>
            <div class="slider-track" id="hero-slider-track"></div>
            <button class="slider-btn next-btn">&#10095;</button>
        </section>

        <div class="section-title-wrapper">
            <h2 class="section-title">Tüm Haberler</h2>
            <div class="title-line"></div>
        </div>
        
        <section class="news-carousel-wrapper">
            <button class="nav-btn prev-news" id="news-prev">&#10094;</button>
        <div class="news-viewport">
        <div id="haberler" class="news-container"></div>
        </div>
            <button class="nav-btn next-news" id="news-next">&#10095;</button>
        </section>
    </main>
    <?php include $yol . 'modal.php'; ?>
</body>
</html>
