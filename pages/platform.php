<?php 
    $yol = "../";
    $sayfa = "platform";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - Platform</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <main>
        <section class="hero-gradient">
            <h1 id="platform-baslik">Yükleniyor...</h1>
            <p id="platform-alt-metin">En güncel haberler ve incelemeler burada.</p>
        </section>

        <section class="featured-news-container" id="vitrin-alani" style="display: none;"></section>

        <div class="section-title-wrapper" id="diger-haberler-baslik" style="display: none;">
            <h2 class="section-title">Diğer Haberler</h2>
            <div class="title-line"></div>
        </div>

        <section id="haberler" class="news-container"></section>

        <div class="pagination-container">
            <button id="prev-page" class="page-btn">Önceki</button>
            <span id="page-info" class="page-info">Sayfa 1</span>
            <button id="next-page" class="page-btn">Sonraki</button>
        </div>
    </main>
    
<?php include $yol . 'modal.php'; ?>
</body>
</html>