<?php 
    $yol = "../";
    $sayfa = "espor";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - E-Spor Dünyası</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
   <?php include '../header.php'; ?>
    <main>
        <section class="hero-gradient" style="--brand-darker: #0d001a; --brand-dark: #2a005c; --brand-light: #b76bff;">
            <h1 style="text-shadow: 0 0 20px rgba(183,107,255,0.8);">E-SPOR ARENASI</h1>
            <p>Turnuvalar, transferler ve profesyonel arenadan son gelişmeler.</p>
        </section>

        <div class="esports-layout">
            
            <div class="esports-news-section">
                <div class="section-title-wrapper" style="margin-top: 0;">
                    <h2 class="section-title">Son Gelişmeler</h2>
                    <div class="title-line"></div>
                </div>
                
                <div class="esports-grid">
                    <div class="news-row" style="--row-glow: #ff4655; width: 100%; height: 320px;">
                        <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80" class="row-img">
                        <div class="row-info">
                            <h3>Valorant Champions Tour 2026 Elemeleri Başlıyor</h3>
                            <p>Dünyanın en iyi takımları büyük ödül için sahneye çıkıyor.</p>
                            <div style="margin-top: auto; display: flex; align-items: center;">
                                <img src="../img/canliskorlogolar/valorantlogo.png" style="height: 24px; width: auto; object-fit: contain;" alt="VALORANT" onerror="this.style.display='none'">
                            </div>
                        </div>
                    </div>
                    
                    <div class="news-row" style="--row-glow: #0bc6e3; width: 100%; height: 320px;">
                        <img src="https://images.unsplash.com/photo-1511512578047-dfb367046420?auto=format&fit=crop&w=800&q=80" class="row-img">
                        <div class="row-info">
                            <h3>League of Legends MSI Şampiyonu Belli Oldu</h3>
                            <p>Beş maçlık nefes kesen serinin ardından kupa Asya'ya gitti.</p>
                            <div style="margin-top: auto; display: flex; align-items: center;">
                                <img src="../img/canliskorlogolar/lollogo.png" style="height: 24px; width: auto; object-fit: contain;" alt="LOL" onerror="this.style.display='none'">
                            </div>
                        </div>
                    </div>

                    <div class="news-row" style="--row-glow: #ffa500; width: 100%; height: 320px;">
                        <img src="https://images.unsplash.com/photo-1552820728-8b83bb6b773f?auto=format&fit=crop&w=800&q=80" class="row-img">
                        <div class="row-info">
                            <h3>CS2 Major Turnuvasında Sürpriz Sonuçlar</h3>
                            <p>Favori takımların erken vedası izleyicileri şok etti.</p>
                            <div style="margin-top: auto; display: flex; align-items: center;">
                                <img src="../img/canliskorlogolar/cs2logo.png" style="height: 24px; width: auto; object-fit: contain;" alt="CS2" onerror="this.style.display='none'">
                            </div>
                        </div>
                    </div>
                </div>
            </div> <div class="esports-sidebar">
                <div class="match-board">
                    <div class="board-header">
                        <h3>GÜNÜN MAÇLARI</h3>
                        <span class="live-badge"><span class="red-dot" style="font-size: 14px;">•</span> CANLI</span>
                    </div>
                    
                    <div class="match-list" id="espor-match-list">
                        </div>
                    
                    <a href="canli-skor.php" class="all-matches-btn">TÜM MAÇLAR</a>
                </div>
            </div> </div> </main>

    
<?php include $yol . 'modal.php'; ?>
</body>
</html>