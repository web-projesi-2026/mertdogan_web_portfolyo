<?php 
    $yol = "../"; // Bir üst klasöre çık ki img ve assets klasörlerini bulabilsin
    $sayfa = "platformlar"; // Hangi sayfadaysan onun adını yaz (espor, skor vb.)
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - Platform Seçimi</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
<?php include '../header.php'; ?>
    <main style="min-height: 80vh; padding: 40px 20px;">
    
    <div class="vertical-split-layout">
        
        <div class="split-side">
            <div class="title-card-wrapper" style="margin-bottom: 30px !important;">
                <h2 class="title-card-text">PLATFORMLAR</h2>
            </div>
            
            <div class="mobile-platforms-grid grid-2-col">
                <?php if(isset($dbPlatformlar) && count($dbPlatformlar) > 0): ?>
                    <?php foreach($dbPlatformlar as $plat): ?>
                        <a href="platform.php?p=<?php echo urlencode($plat['isim']); ?>" class="mobile-plat-card" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="../img/logolar/<?php echo $plat['logo']; ?>" alt="<?php echo $plat['isim']; ?>" class="mobile-plat-logo" style="width: 40px; object-fit: contain;">
        <span style="color: #fff; font-weight: bold; font-size: 14px;"><?php echo mb_strtoupper($plat['isim'], 'UTF-8'); ?></span>
    </div>

    <button class="bookmarkBtn" data-platform="<?php echo mb_strtoupper($plat['isim'], 'UTF-8'); ?>" onclick="toggleTakip(event, '<?php echo mb_strtoupper($plat['isim'], 'UTF-8'); ?>')">
      <span class="IconContainer">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="1.5em" class="icon" viewBox="0 0 24 24">
          <g>
            <path d="M13 17.62a5.29 5.29 0 0 0 .38 2l.06.14H3.5a2.25 2.25 0 0 1-2.25-2.26V17A6.71 6.71 0 0 1 4 11.55a6.7 6.7 0 0 0 8.92 0 6.7 6.7 0 0 1 1.87 2.06A5.24 5.24 0 0 0 13 17.62z" fill="#000000"></path>
            <circle cx="8.5" cy="6.5" r="5.25" fill="#000000"></circle>
            <path d="M18.38 13.25A4.37 4.37 0 0 0 14 17.62a4.53 4.53 0 0 0 .3 1.62 4.38 4.38 0 1 0 4.08-6zm1.84 5.07h-1.15v1.15a.7.7 0 0 1-1.39 0v-1.15h-1.15a.7.7 0 0 1 0-1.39h1.15v-1.15a.7.7 0 0 1 1.39 0v1.15h1.15a.7.7 0 0 1 0 1.39z" fill="#000000"></path>
          </g>
        </svg>
      </span>
      <p class="text">Takip Et</p>
    </button>
</a>
<?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #666; text-align: center; width: 100%;">Platform verisi yüklenemedi.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="vertical-divider"></div>

        <div class="split-side">
            <div class="title-card-wrapper" style="margin-bottom: 30px !important;">
                <h2 class="title-card-text">ÜRETİCİLER</h2>
            </div>
            
            <div class="mobile-platforms-grid grid-2-col">
                <?php if(isset($dbUreticiler) && count($dbUreticiler) > 0): ?>
                    <?php foreach($dbUreticiler as $uret): ?>
                        <a href="platform.php?p=<?php echo urlencode($uret['isim']); ?>" class="mobile-plat-card" style="display: flex; align-items: center; justify-content: space-between; text-decoration: none;">
    <div style="display: flex; align-items: center; gap: 15px;">
        <img src="../img/logolar/<?php echo $uret['logo']; ?>" alt="<?php echo $uret['isim']; ?>" class="mobile-plat-logo" style="width: 40px; object-fit: contain;">
        <span style="color: #fff; font-weight: bold; font-size: 14px;"><?php echo mb_strtoupper($uret['isim'], 'UTF-8'); ?></span>
    </div>

    <button class="bookmarkBtn" data-platform="<?php echo mb_strtoupper($uret['isim'], 'UTF-8'); ?>" onclick="toggleTakip(event, '<?php echo mb_strtoupper($uret['isim'], 'UTF-8'); ?>')">
      <span class="IconContainer">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" height="1.5em" class="icon" viewBox="0 0 24 24">
          <g>
            <path d="M13 17.62a5.29 5.29 0 0 0 .38 2l.06.14H3.5a2.25 2.25 0 0 1-2.25-2.26V17A6.71 6.71 0 0 1 4 11.55a6.7 6.7 0 0 0 8.92 0 6.7 6.7 0 0 1 1.87 2.06A5.24 5.24 0 0 0 13 17.62z" fill="#000000"></path>
            <circle cx="8.5" cy="6.5" r="5.25" fill="#000000"></circle>
            <path d="M18.38 13.25A4.37 4.37 0 0 0 14 17.62a4.53 4.53 0 0 0 .3 1.62 4.38 4.38 0 1 0 4.08-6zm1.84 5.07h-1.15v1.15a.7.7 0 0 1-1.39 0v-1.15h-1.15a.7.7 0 0 1 0-1.39h1.15v-1.15a.7.7 0 0 1 1.39 0v1.15h1.15a.7.7 0 0 1 0 1.39z" fill="#000000"></path>
          </g>
        </svg>
      </span>
      <p class="text">Takip Et</p>
    </button>
</a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: #666; text-align: center; width: 100%;">Üretici verisi yüklenemedi.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>
    
</main>

<div id="authModal" class="auth-modal-overlay">
    <div class="auth-modal-content">
        <span class="auth-close-btn" onclick="closeAuthModal()">&times;</span>
        <div class="auth-tabs">
            <button id="tab-login" class="auth-tab active" onclick="switchAuthTab('login')">GİRİŞ YAP</button>
            <button id="tab-register" class="auth-tab" onclick="switchAuthTab('register')">KAYIT OL</button>
        </div>
        <div id="auth-message-box" style="margin: 15px; padding: 10px; border-radius: 6px; display: none; font-size: 13px;"></div>
        
        <div id="form-login" class="auth-form-section active">
            <h3>Hoş Geldiniz</h3>
            <form id="ajaxLoginForm">
                <input type="text" name="kullanici_adi" class="auth-input" placeholder="Kullanıcı Adı" required>
                <input type="password" name="sifre" class="auth-input" placeholder="Şifre" required>
                <button type="submit" class="auth-submit-btn">GİRİŞ YAP</button>
                <a href="#" style="display: block; text-align: center; color: #888; font-size: 12px; margin-top: 15px; text-decoration: none; transition: 0.3s;" onmouseover="this.style.color='#b76bff'" onmouseout="this.style.color='#888'">Şifremi Unuttum</a>
            </form>
        </div>

        <div id="form-register" class="auth-form-section">
            <h3>Yeni Hesap Oluştur</h3>
            <form id="ajaxRegisterForm">
                <input type="text" name="kullanici_adi" class="auth-input" placeholder="Kullanıcı Adı Seç" required>
                <input type="email" name="eposta" class="auth-input" placeholder="E-Posta Adresi" required>
                <input type="password" name="sifre" class="auth-input" placeholder="Şifre Oluştur" required>
                <button type="submit" class="auth-submit-btn">KAYIT OL</button>
            </form>
        </div>
    </div>
</div>
<div id="profilModal" class="auth-modal-overlay">
    <div class="auth-modal-content">
        <span class="auth-close-btn" onclick="document.getElementById('profilModal').classList.remove('show')">&times;</span>
        <div class="auth-tabs" style="justify-content: center; padding: 20px; background: rgba(0,0,0,0.6);">
            <h3 style="color: #b76bff; margin:0; font-size: 18px;">KULLANICI PROFİLİ</h3>
        </div>
        
        <div class="auth-form-section active" style="text-align: left;">
            <div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px; margin-bottom: 25px; border: 1px solid rgba(255,255,255,0.1);">
                <p style="color: #aaa; font-size: 13px; margin-bottom: 8px;">Kullanıcı Adı: <br><strong id="profil-kullanici-adi" style="color: #fff; font-size: 16px;">Yükleniyor...</strong></p>
                <p style="color: #aaa; font-size: 13px; margin: 0;">E-Posta: <br><strong id="profil-eposta" style="color: #fff; font-size: 16px;">Yükleniyor...</strong></p>
            </div>

            <h4 style="color: #fff; margin-bottom: 15px; text-align: center;">Şifre Değiştir</h4>
            <form id="ajaxSifreDegistirForm">
                <input type="password" name="eski_sifre" class="auth-input" placeholder="Mevcut Şifre" required>
                <input type="password" name="yeni_sifre" class="auth-input" placeholder="Yeni Şifre" required>
                <button type="submit" class="auth-submit-btn" style="background: transparent; border: 1px solid #b76bff; color: #b76bff;">ŞİFREYİ GÜNCELLE</button>
            </form>
        </div>
    </div>
</div>
<script src="../assets/script.js"></script>
</body>
</html>