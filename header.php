<?php
$yol = isset($yol) ? $yol : "";
$sayfa = isset($sayfa) ? $sayfa : "";

// 1. VERİTABANI BAĞLANTISI (Her dizinden sorunsuz çalışır)
require_once __DIR__ . '/baglan.php';

// 2. VERİTABANINDAN VERİLERİ ÇEKME
// Platformları Çek
$platformSorgu = $db->prepare("SELECT * FROM platformlar WHERE kategori = 'Platform' ORDER BY id ASC");
$platformSorgu->execute();
$dbPlatformlar = $platformSorgu->fetchAll(PDO::FETCH_ASSOC);

// MEGA MENÜ SOL SİDEBAR İÇİN ÖZEL AYRIŞTIRMA (Türkçe Karakter Korumalı)
$sidebarData = ['Xbox' => null, 'PS' => null, 'Nintendo' => null];
foreach($dbPlatformlar as $p) {
    // mb_strtoupper ile Türkçe karakter (i/İ) sorununu aşıyoruz
    $isim = mb_strtoupper(trim($p['isim']), 'UTF-8');
    if($isim == 'XBOX') $sidebarData['Xbox'] = $p;
    if($isim == 'PS' || $isim == 'PLAYSTATION') $sidebarData['PS'] = $p;
    if($isim == 'NINTENDO' || $isim == 'NİNTENDO') $sidebarData['Nintendo'] = $p;
}

// Üreticileri Çek
$ureticiSorgu = $db->prepare("SELECT * FROM platformlar WHERE kategori = 'Üretici' ORDER BY id ASC");
$ureticiSorgu->execute();
$dbUreticiler = $ureticiSorgu->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    header { overflow: visible !important; }
    .mega-panel { top: 80px !important; visibility: visible; }
    .mega-details {
        display: flex !important;
        gap: 60px !important;
        padding: 40px !important;
        justify-content: flex-start !important;
        align-items: flex-start !important;
    }
    .mega-col { min-width: 200px !important; }
</style>

<header>
    <a href="<?php echo $yol; ?>index.php" class="logo-wrapper">
        <img
            src="<?php echo $yol; ?>img/logolar/logo.png"
            data-static="<?php echo $yol; ?>img/logolar/logo.png"
            data-hover="<?php echo $yol; ?>img/logolar/logogif.gif"
            alt="GAMEPORTAL Logo"
            class="header-logo"
            id="site-logo"
        >
    </a>

    <nav id="ana-menu">
        <ul>
            <li><a href="<?php echo $yol; ?>index.php" style="color:<?php echo $sayfa=='ana_sayfa'?'#b76bff':'#fff'; ?>">ANA SAYFA</a></li>

            <li class="dropdown mega-menu">
                <a href="#" class="dropbtn" style="color:<?php echo $sayfa=='platformlar'?'#b76bff':'#fff'; ?>">PLATFORMLAR<span class="nav-arrow"></span></a>
                <div class="mega-panel tab-style">
                    <div class="mega-layout">
                        
                       <div class="mega-sidebar">
                            <a href="<?php echo $yol; ?>pages/hmkategoriler.php" class="side-item main-active" data-target="tab-pc">
                                <img src="<?php echo $yol; ?>img/logolar/platform.png" class="menu-logo logo-kategori-side"> PLATFORMLAR
                            </a>
                            
                            <a href="<?php echo $yol; ?>pages/kategori.php?k=İncelemeler" class="side-item" style="padding-left: 82px;">
                                İNCELEMELER
                            </a>
                            
                            <a href="<?php echo $yol; ?>pages/kategori.php?k=Donanım" class="side-item" style="padding-left: 82px;">
                                DONANIM & TEKNOLOJİ
                            </a>
                            
                            <a href="<?php echo $yol; ?>pages/kategori.php?k=Rehberler" class="side-item" style="padding-left: 82px;">
                                OYUN REHBERLERİ
                            </a>

                            <a href="<?php echo $yol; ?>pages/espor.php" class="side-item" style="padding-left: 82px;">
                                E-SPOR DÜNYASI
                            </a>
                        </div>
                        
                        <div class="mega-content">
                            <div id="tab-pc" class="mega-tab-content active">
                                <div class="mega-details">
                                    
                                    <div class="mega-col">
                                        <h4 class="mega-title" style="color:#888;font-size:11px;font-weight:bold;text-transform:uppercase;margin-bottom:20px;border-bottom:1px solid #333;padding-bottom:6px;">PLATFORMLAR</h4>
                                        <?php if(isset($dbPlatformlar) && count($dbPlatformlar) > 0): ?>
                                            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0 40px;">
                                                <?php foreach($dbPlatformlar as $plat): ?>
                                                    <?php 
                                                    $kontrolIsim = mb_strtoupper(trim($plat['isim']), 'UTF-8');
                                                    $gosterilecekLogo = ($kontrolIsim == 'PS' || $kontrolIsim == 'PLAYSTATION') ? 'ps.png' : $plat['logo'];
                                                    $cssSinifi = "logo-" . strtolower(explode(' ', $plat['isim'])[0]); 
                                                    
                                                    // SADECE STORE YAZISINI SİLMEK İÇİN:
                                                    $temizIsim = str_ireplace(' STORE', '', $plat['isim']);
                                                    ?>
                                                    <a href="<?php echo $yol; ?>pages/platform.php?p=<?php echo urlencode($plat['isim']); ?>" class="item-sub">
                                                        <img src="<?php echo $yol; ?>img/logolar/<?php echo $gosterilecekLogo; ?>" class="menu-logo <?php echo $cssSinifi; ?>" onerror="this.style.display='none'"> 
                                                        <span style="white-space: nowrap;"><?php echo mb_strtoupper($temizIsim, 'UTF-8'); ?></span>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <a href="#" class="item-sub">Veri Bulunamadı</a>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="mega-col">
                                        <h4 class="mega-title" style="color:#888;font-size:11px;font-weight:bold;text-transform:uppercase;margin-bottom:20px;border-bottom:1px solid #333;padding-bottom:6px;">ÜRETİCİLER</h4>
                                        <?php if(isset($dbUreticiler) && count($dbUreticiler) > 0): ?>
                                            <?php foreach($dbUreticiler as $uret): ?>
                                                <?php 
                                                $cssSinifi = "logo-" . strtolower(explode(' ', $uret['isim'])[0]); 
                                                $temizIsimUretici = str_ireplace(' STORE', '', $uret['isim']);
                                                ?>
                                                <a href="<?php echo $yol; ?>pages/platform.php?p=<?php echo urlencode($uret['isim']); ?>" class="item-sub">
                                                    <img src="<?php echo $yol; ?>img/logolar/<?php echo $uret['logo']; ?>" class="menu-logo <?php echo $cssSinifi; ?>"> 
                                                    <span style="white-space: nowrap;"><?php echo mb_strtoupper($temizIsimUretici, 'UTF-8'); ?></span>
                                                </a>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <a href="#" class="item-sub">Veri Bulunamadı</a>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </li>

            <li><a href="<?php echo $yol; ?>pages/espor.php" style="color:<?php echo $sayfa=='espor'?'#b76bff':'#fff'; ?>">E-SPOR</a></li>
        </ul>
    </nav>

    <div class="header-right">
        <div class="header-auth-group">
            <button class="auth-btn btn-login" onclick="openAuthModal('login')">GİRİŞ YAP</button>
            <span class="auth-sep">/</span>
            <button class="auth-btn btn-register" onclick="openAuthModal('register')">KAYIT OL</button>
        </div>
        <a href="<?php echo $yol; ?>pages/canli-skor.php" class="live-score-btn"><span class="red-dot">•</span> CANLI SKOR</a>

        <div class="hamburger-menu">
            <div class="hamburger-icon"><span></span><span></span><span></span></div>
            <div class="hamburger-content">
                <a href="<?php echo $yol; ?>index.php">ANA SAYFA</a>
                <a href="<?php echo $yol; ?>pages/hmkategoriler.php">KATEGORİLER</a>
                <a href="<?php echo $yol; ?>pages/espor.php">E-SPOR</a>
                <a href="<?php echo $yol; ?>pages/canli-skor.php">CANLI SKOR</a>
                <div style="margin: 10px 16px; border-top: 2px solid rgba(183,107,255,0.5);"></div>
                <div id="hamburger-auth-blok">
                    <a href="#" onclick="openAuthModal('login');return false;">GİRİŞ YAP</a>
                    <a href="#" onclick="openAuthModal('register');return false;">KAYIT OL</a>
                </div>
            </div>
        </div>
    </div>
</header>