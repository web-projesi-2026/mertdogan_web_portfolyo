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
                <a href="#" class="sifre-unut-link">Şifremi Unuttum</a>
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

<script src="<?php echo $yol; ?>assets/script.js"></script>
