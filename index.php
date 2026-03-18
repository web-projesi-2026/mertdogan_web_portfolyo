<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GamePortal - Oyun Haberleri ve Güncellemeler</title>
    <link rel="stylesheet" href="style.css?v=5">
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
                <li><a href="#" class="filtre-butonu" data-kategori="hepsi">Ana Sayfa</a></li>
                
                <li class="dropdown">
                    <a href="#">Kategoriler ▼</a>
                    <ul class="dropdown-menu">
                        
                        <li class="dropdown-submenu">
                            <a href="#" class="filtre-butonu" data-kategori="pc">PC ▸</a>
                            <ul class="submenu">
                                <li><a href="#" class="filtre-butonu" data-kategori="pc">Tüm Haberler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="pc" data-tur="Güncelleme">Güncellemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="pc" data-tur="Sektör Haberi">Sektör Haberleri</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="pc" data-tur="İnceleme">İncelemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="pc" data-tur="Rehber">Rehberler</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a href="#" class="filtre-butonu" data-kategori="konsol">Konsol ▸</a>
                            <ul class="submenu">
                                <li><a href="#" class="filtre-butonu" data-kategori="konsol">Tüm Haberler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="konsol" data-tur="Güncelleme">Güncellemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="konsol" data-tur="Sektör Haberi">Sektör Haberleri</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="konsol" data-tur="İnceleme">İncelemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="konsol" data-tur="Rehber">Rehberler</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a href="#" class="filtre-butonu" data-kategori="nintendo">Nintendo ▸</a>
                            <ul class="submenu">
                                <li><a href="#" class="filtre-butonu" data-kategori="nintendo">Tüm Haberler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="nintendo" data-tur="Güncelleme">Güncellemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="nintendo" data-tur="Sektör Haberi">Sektör Haberleri</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="nintendo" data-tur="İnceleme">İncelemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="nintendo" data-tur="Rehber">Rehberler</a></li>
                            </ul>
                        </li>

                        <li class="dropdown-submenu">
                            <a href="#" class="filtre-butonu" data-kategori="mobil">Mobil ▸</a>
                            <ul class="submenu">
                                <li><a href="#" class="filtre-butonu" data-kategori="mobil">Tüm Haberler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="mobil" data-tur="Güncelleme">Güncellemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="mobil" data-tur="Sektör Haberi">Sektör Haberleri</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="mobil" data-tur="İnceleme">İncelemeler</a></li>
                                <li><a href="#" class="filtre-butonu" data-kategori="mobil" data-tur="Rehber">Rehberler</a></li>
                            </ul>
                        </li>

                    </ul>
                </li>
                
                <li><a href="#" class="filtre-butonu" data-kategori="espor">E-Spor</a></li>
                <li><a href="firsatlar.php" style="color: #ffaa00; font-weight: bold; text-shadow: 0 0 5px rgba(255,170,0,0.5);">🔥 Fırsatlar</a></li>
            </ul>
        </nav>
    </header> <div id="yan-menu" class="yan-menu">
        <button id="menu-kapat" class="menu-kapat">&times;</button>
        <h2>Menü</h2>
        <ul>
            <li><a href="#" class="filtre-butonu" data-kategori="hepsi">Ana Sayfa</a></li>
            <li><a href="#" class="filtre-butonu" data-kategori="pc">PC Oyunları</a></li>
            <li><a href="#" class="filtre-butonu" data-kategori="konsol">Konsol Haberleri</a></li>
            <li><a href="#" class="filtre-butonu" data-kategori="espor">E-Spor</a></li>
            <hr>
            <li><a href="#" class="filtre-butonu" data-tur="Haber">Haberler</a></li>
            <li><a href="#" class="filtre-butonu" data-tur="Güncelleme">Yama ve Güncellemeler</a></li>
            <li><a href="#" class="filtre-butonu" data-tur="Sektör Haberi">Sektör Haberleri</a></li>
            <li><a href="#" class="filtre-butonu" data-tur="İnceleme">İncelemeler</a></li>
            <li><a href="#" class="filtre-butonu" data-tur="Rehber">Rehberler</a></li>
        </ul>
    </div>

    <main>
        <section class="haber-alani">
            <h2>Güncel Gelişmeler ve Yama Notları</h2>
            
            <div class="haber-listesi" id="haber-listesi">
                <?php include 'haberler.php'; ?>
            </div>

            <div id="sayfalama-alani" class="sayfalama-alani"></div>
            
        </section>
    </main>

    <script src="script.js"></script>
</body>
</html>