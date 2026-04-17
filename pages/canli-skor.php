<?php 
    $yol = "../";
    $sayfa = "canli_skor";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - Canlı Skor</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../header.php'; ?>

    <main style="min-height: 80vh; padding: 40px 20px; max-width: 1200px; margin: 0 auto; width: 100%; box-sizing: border-box;">
        
        <div class="title-card-wrapper" style="margin-bottom: 20px;">
            <h2 class="title-card-text">- CANLI SKOR -</h2>
        </div>

        <div class="marquee-container">
            <div class="marquee-track">
                
                <a href="canli-skor.php" class="game-filter-card" data-game="all">
                    <img src="../img/canliskorkartlar/logo.png" alt="Tüm Maçlar" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=valorant" class="game-filter-card" data-game="valorant">
                    <img src="../img/canliskorkartlar/valorant.png" alt="Valorant" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=cs2" class="game-filter-card" data-game="cs2">
                    <img src="../img/canliskorkartlar/cs2.png" alt="CS2" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=lol" class="game-filter-card" data-game="lol">
                    <img src="../img/canliskorkartlar/lol.png" alt="LoL" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=dota" class="game-filter-card" data-game="dota">
                    <img src="../img/canliskorkartlar/dota.png" alt="Dota 2" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>

                <a href="canli-skor.php" class="game-filter-card" data-game="all">
                    <img src="../img/canliskorkartlar/logo.png" alt="Tüm Maçlar" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=valorant" class="game-filter-card" data-game="valorant">
                    <img src="../img/canliskorkartlar/valorant.png" alt="Valorant" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=cs2" class="game-filter-card" data-game="cs2">
                    <img src="../img/canliskorkartlar/cs2.png" alt="CS2" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=lol" class="game-filter-card" data-game="lol">
                    <img src="../img/canliskorkartlar/lol.png" alt="LoL" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>
                <a href="canli-skor.php?game=dota" class="game-filter-card" data-game="dota">
                    <img src="../img/canliskorkartlar/dota.png" alt="Dota 2" onerror="this.src='https://cdn-icons-png.flaticon.com/512/5260/5260498.png'">
                </a>

            </div>
        </div>

        <div id="live-score-board" style="margin-top: 40px;">
            <h3 style="text-align: center; color: #888;">Maçlar Yükleniyor...</h3>
        </div>

    </main>

    
<?php include $yol . 'modal.php'; ?>
</body>
</html>