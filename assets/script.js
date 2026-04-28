
/* === 1. VERİ AYARLARI === */
let allNewsData = [];
let currentScroll = 0;

const isSubPage = window.location.pathname.includes('/pages/') || window.location.href.includes('/pages/');
const basePathImg = isSubPage ? '../img/' : 'img/';
const basePathPage = isSubPage ? '' : 'pages/';

const markaRenkleri = {
    "Steam": { dark: "#1b2838", darker: "#171a21", light: "#66c0f4" },
    "Epic Games": { dark: "#1a1a1a", darker: "#0a0a0a", light: "#ffffff" },
    "Nvidia": { dark: "#203600", darker: "#000000", light: "#76b900" },
    "AMD": { dark: "#4a0000", darker: "#000000", light: "#ed1c24" },
    "EA Games": { dark: "#3a0000", darker: "#1a0000", light: "#ff4747" },
    "Ubisoft": { dark: "#001a4d", darker: "#000a1a", light: "#0070ff" },
    "Nintendo": { dark: "#4a0000", darker: "#1a0000", light: "#e60012" },
    "Xbox": { dark: "#0a4d0a", darker: "#052d05", light: "#107c10" },
    "PS": { dark: "#001a4d", darker: "#000a1a", light: "#003791" },
    "Intel": { dark: "#003a66", darker: "#001a33", light: "#0071c5" },
    "Riot Games": { dark: "#2a0a0a", darker: "#110000", light: "#eb0029" },
    "Valorant": { dark: "#2a0a10", darker: "#1a0505", light: "#ff4655" },
    "League of Legends": { dark: "#1a1600", darker: "#0a0800", light: "#c89b3c" },
    "CS2": { dark: "#2a1a00", darker: "#1a0a00", light: "#f4a900" },
    "PC": { dark: "#222222", darker: "#111111", light: "#b76bff" }
};

const takimRenkleri = {
    "bbl esports": "#cb9803",    // BBL - Altın
    "fut esports": "#ffffff",    // FUT - Beyaz
    "papara supermassive": "#ff4747", // Örnek SUP - Kırmızı
    "galatasaray esports": "#f3ba2f", // Örnek GS - Sarı
    "besiktas": "#ffffff",       // Örnek BJK - Beyaz
    "dark passage": "#048eff"    // Örnek DP - Kırmızı
    // Yeni takım ekledikçe adını küçük harfle yazıp buraya rengini girebilirsin!
};

// YENİ VE KUSURSUZ ANAHTAR BULUCU
function getFavoriKey() {
    // Artık ekrandaki yazıya değil, direkt tarayıcının sarsılmaz hafızasına bakıyoruz.
    const kullaniciAdi = localStorage.getItem('aktif_kullanici');
    return kullaniciAdi ? 'favoriler_' + kullaniciAdi : null;
}

document.addEventListener("DOMContentLoaded", async () => {
    // 1. Parametreler
    const urlParams = new URLSearchParams(window.location.search);
    const haberId = urlParams.get('id');
    const secilenPlatform = urlParams.get('p');
    const detayIcerik = document.getElementById('haber-detay-icerik');

    // 2. Mega Menü Sistemi
    const sideItems = document.querySelectorAll('.side-item');
    const tabPanels = document.querySelectorAll('.tab-panel');
    sideItems.forEach(item => {
        item.addEventListener('mouseenter', () => {
            sideItems.forEach(i => i.classList.remove('main-active'));
            tabPanels.forEach(p => p.classList.remove('active-panel'));
            item.classList.add('main-active');
            const targetId = item.getAttribute('data-target');
            if (targetId) {
                const targetPanel = document.getElementById(targetId);
                if(targetPanel) targetPanel.classList.add('active-panel');
            }
        });
    });

    // 3. Veritabanı Bağlantısı ve Akıllı Filtreleme
    try {
        let apiYolu = isSubPage ? '../api.php' : 'api.php';
        
        // Önce API'den (herhangi bir filtre olmadan) tüm haberleri çekiyoruz
        const response = await fetch(apiYolu);
        const hamVeri = await response.json();

        if (secilenPlatform) {
            // HANGİ ÜRETİCİ HANGİ OYUNLARA SAHİP? (Buraya istediğin kadar ekleme yapabilirsin)
            const ureticiOyunlari = {
                "Riot Games": ["Riot Games", "Valorant", "League of Legends", "LoL", "TFT"],
                "EA Games": ["EA Games", "FC 24", "FIFA", "Battlefield", "Apex Legends"],
                "Valve": ["Valve", "Steam", "CS2", "Dota 2", "Half-Life"]
            };

            let aranacakKelimeler = [secilenPlatform];
            
            // Eğer URL'deki platform bir Üretici ise (Örn: Riot Games), oyunlarını da listeye kat
            for (const [uretici, oyunlar] of Object.entries(ureticiOyunlari)) {
                if (secilenPlatform.toLowerCase() === uretici.toLowerCase()) {
                    aranacakKelimeler = oyunlar;
                    break;
                }
            }

            // Gelen tüm haberleri filtreleyip sadece ilgili olanları ekranda göster
            allNewsData = hamVeri.filter(h => 
                aranacakKelimeler.some(kelime => h.platform.toLowerCase() === kelime.toLowerCase())
            );
        } else {
            allNewsData = hamVeri;
        }

    } catch (error) {
        console.error("Veritabanından veri çekilemedi:", error);
        allNewsData = [];
    }

    // 4. Haber Detay Sayfası Kontrolü
    if (detayIcerik && haberId) {
        const secilenHaber = allNewsData.find(h => h.id == haberId);
        if (secilenHaber) {
            let logoDosya = "default.png";
            let logoStili = "";
            if (secilenHaber.platform.includes("Steam")) logoDosya = "steam.png";
            else if (secilenHaber.platform.includes("Epic Games")) logoDosya = "epic.png";
            else if (secilenHaber.platform.includes("Nvidia")) logoDosya = "nvidia.png";
            else if (secilenHaber.platform.includes("AMD")) logoDosya = "amd.png";
            else if (secilenHaber.platform.includes("Intel")) logoDosya = "intel.png";
            else if (secilenHaber.platform.includes("PS")) logoDosya = "ps.png";
            else if (secilenHaber.platform.includes("Xbox")) { logoDosya = "xbox.png"; logoStili = "transform: scale(1.6); transform-origin: center;"; }
            else if (secilenHaber.platform.includes("Nintendo")) logoDosya = "nintendo.png";
            else if (secilenHaber.platform.includes("EA Games")) logoDosya = "ea.png";
            else if (secilenHaber.platform.includes("Ubisoft")) logoDosya = "ubisoft.png";

            detayIcerik.innerHTML = `
                <div class="detay-baslik-alani">
                    <div class="detay-logo-container" style="margin-bottom: 20px; display: flex; justify-content: center; align-items: center; height: 50px;">
                        <img src="${basePathImg}logolar/${logoDosya}" alt="${secilenHaber.platform}" class="detay-platform-logo" style="height: 40px; object-fit: contain; filter: drop-shadow(0 2px 10px rgba(0,0,0,0.7)); ${logoStili}" onerror="this.style.display='none'">
                    </div>
                    <h1>${secilenHaber.baslik}</h1>
                </div>
               <img src="${secilenHaber.resim.startsWith('http') ? secilenHaber.resim : (isSubPage ? '../' : '') + secilenHaber.resim}" class="detay-ana-resim" alt="${secilenHaber.baslik}" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
                <div class="detay-metin-alani">
                    
                    <div>${secilenHaber.icerik}</div>
                </div>
            `;
            return;
        } else {
            detayIcerik.innerHTML = "<h1 style='text-align:center;'>Bu haber bulunamadı veya silinmiş.</h1>";
            return;
        }
    }

    // 5. Veri Yükleme ve Ekrana Basma
    if (secilenPlatform) {
        const renkler = markaRenkleri[secilenPlatform] || markaRenkleri["PC"];
        document.documentElement.style.setProperty('--brand-dark', renkler.dark);
        document.documentElement.style.setProperty('--brand-darker', renkler.darker);
        document.documentElement.style.setProperty('--brand-light', renkler.light);

        const baslik = document.getElementById('platform-baslik');
        if(baslik) baslik.innerText = secilenPlatform.toUpperCase() + " HABERLERİ";
    } else {
        initHeroSlider(allNewsData);
    }
    await kontrolEtOturum();


    // 6. Carousel Navigasyon (sadece masaüstünde)
    const container = document.getElementById('haberler');
    const nextBtn = document.getElementById('news-next');
    const prevBtn = document.getElementById('news-prev');

    const isMobile = () => window.innerWidth <= 768;

    if (nextBtn && prevBtn && container) {
        nextBtn.onclick = () => {
            if (isMobile()) return;
            const viewportWidth = container.parentElement.clientWidth;
            const maxScroll = container.scrollWidth - viewportWidth;
            if (currentScroll < maxScroll) {
                currentScroll += 325;
                if (currentScroll > maxScroll) currentScroll = maxScroll;
                container.style.transform = `translateX(-${currentScroll}px)`;
            }
        };
        prevBtn.onclick = () => {
            if (isMobile()) return;
            if (currentScroll > 0) {
                currentScroll -= 295;
                if (currentScroll < 0) currentScroll = 0;
                container.style.transform = `translateX(-${currentScroll}px)`;
            }
        };
    }

    // Ekran boyutu değişince carousel sıfırla
    window.addEventListener('resize', () => {
        if (isMobile() && container) {
            currentScroll = 0;
            container.style.transform = '';
        }
    });
const newsWrapper = document.querySelector('.news-carousel-wrapper');

    if (newsWrapper && container) {
        let isDown = false;
        let startX;
        let scrollLeftAtStart;
        let isDragging = false;

        newsWrapper.addEventListener('mousedown', (e) => {
            isDown = true;
            isDragging = false;
            startX = e.pageX - newsWrapper.offsetLeft;
            scrollLeftAtStart = currentScroll; 
            container.style.transition = 'none'; 
        });

        newsWrapper.addEventListener('mouseleave', () => {
            if (!isDown) return;
            isDown = false;
            container.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
        });

        newsWrapper.addEventListener('mouseup', () => {
            isDown = false;
            container.style.transition = 'transform 0.6s cubic-bezier(0.23, 1, 0.32, 1)';
        });

        newsWrapper.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - newsWrapper.offsetLeft;
            const walk = (x - startX) * 1.5; 
            if (Math.abs(walk) > 5) isDragging = true;

            let newScroll = scrollLeftAtStart - walk;
            const maxScroll = container.scrollWidth - newsWrapper.clientWidth;
            
            if (newScroll < 0) newScroll = 0;
            if (newScroll > maxScroll) newScroll = maxScroll;

            currentScroll = newScroll;
            container.style.transform = `translateX(-${currentScroll}px)`;
        });

        container.querySelectorAll('.news-row').forEach(card => {
            card.addEventListener('click', (e) => {
                if (isDragging) {
                    e.preventDefault();
                    e.stopPropagation();
                }
            }, true);
        });
    }
});

function ekranaBas(liste) {
    const container = document.getElementById('haberler');
    if (!container) return;

    // Renk haritası aynı kalıyor...
    const renkMap = {
        "Steam": "#66c0f4", "Epic Games": "#e0e0e0", "Nvidia": "#76b900",
        "AMD": "#ed1c24", "Intel": "#0071c5", "PS": "#003791",
        "Xbox": "#107c10", "EA Games": "#ff4747", "Ubisoft": "#0070ff",
        "Nintendo": "#e60012", "PC": "#b76bff",
        "Riot Games": "#eb0029", "Valorant": "#ff4655", "League of Legends": "#c89b3c", "CS2": "#f4a900"
    };

    const userKey = getFavoriKey(); 
    let favoriler = [];
    if (localStorage.getItem('oturum') === 'acik' && userKey) {
        favoriler = JSON.parse(localStorage.getItem(userKey)) || [];
    }

    // === ATLAS DOKUNUŞU: FAVORİLER SAYFASI GÜMRÜK KONTROLÜ ===
    if (window.location.pathname.includes('favoriler.php')) {
        
        // 1. Durum: Ziyaretçi linki kopyalayıp girmişse onu uyar ve giriş yapmasını iste
        if (!userKey || localStorage.getItem('oturum') !== 'acik') {
            container.innerHTML = `
                <div style="text-align: center; padding: 100px 20px; width: 100%;">
                    <h2 style="color: #ff4747; margin-bottom: 15px;">Lütfen Giriş Yapın</h2>
                    <p style="color: #888;">Favori haberlerinizi görmek için oturum açmalısınız.</p>
                    <button onclick="openAuthModal('login')" style="margin-top:20px; padding:10px 25px; background:#b76bff; font-weight:bold; color:#fff; border:none; border-radius:6px; cursor:pointer;">GİRİŞ YAP</button>
                </div>
            `;
            return; // Fonksiyonu durdur
        }

        // 2. Durum: Giriş yapılmışsa, tüm haberleri süzgeçten geçir ve sadece favori ID'leri olanları bırak
        liste = liste.filter(h => favoriler.includes(h.id.toString()));

        // 3. Durum: Süzgeçten sonra elde hiç haber kalmazsa senin hazırladığın o boş ekranı göster
        if (liste.length === 0) {
            container.innerHTML = `
                <div style="text-align: center; padding: 100px 20px; width: 100%;">
                    <h2 style="color: #fff; margin-bottom: 15px;">Henüz favorilere eklediğiniz bir haber bulunmuyor.</h2>
                    <p style="color: #888;">Ana sayfadaki kalp butonlarına tıklayarak haberleri buraya ekleyebilirsiniz.</p>
                </div>
            `;
            return; // Fonksiyonu durdur
        }
    }


    container.innerHTML = liste.map(h => {
        let col = "#b76bff";
        let logoDosya = "default.png";
        let logoStili = "";

        // TÜRKÇE KARAKTER SORUNUNU KÖKTEN ÇÖZEN BÜYÜK HARF TAKTİĞİ
        const p = h.platform.toUpperCase();

        // GÜNCELLENMİŞ KESİN EŞLEŞMELER
        if (p.includes("STEAM")) { col = renkMap["Steam"]; logoDosya = "steam.png"; }
        else if (p.includes("EPIC") || p.includes("EPİC")) { col = renkMap["Epic Games"]; logoDosya = "epic.png"; }
        else if (p.includes("EA GAMES") || p.includes("EA")) { col = renkMap["EA Games"]; logoDosya = "ea.png"; }
        else if (p.includes("UBISOFT") || p.includes("UBİSOFT")) { col = renkMap["Ubisoft"]; logoDosya = "ubisoft.png"; }
        else if (p.includes("NVIDIA") || p.includes("NVİDİA")) { col = renkMap["Nvidia"]; logoDosya = "nvidia.png"; }
        else if (p.includes("AMD")) { col = renkMap["AMD"]; logoDosya = "amd.png"; }
        else if (p.includes("INTEL") || p.includes("İNTEL")) { col = renkMap["Intel"]; logoDosya = "intel.png"; }
        else if (p.includes("PS") || p.includes("PLAYSTATION") || p.includes("PLAYSTATİON")) { col = renkMap["PS"]; logoDosya = "ps.png"; }
        else if (p.includes("XBOX")) { col = renkMap["Xbox"]; logoDosya = "xbox.png"; logoStili = "transform: scale(1.6);"; }
        else if (p.includes("NINTENDO") || p.includes("NİNTENDO")) { col = renkMap["Nintendo"]; logoDosya = "nintendo.png"; }
        else if (p.includes("RIOT") || p.includes("RİOT")) { col = renkMap["Riot Games"]; logoDosya = "riot.png"; }
        else if (p.includes("VALORANT")) { col = renkMap["Valorant"]; logoDosya = "valorant.png"; logoStili = "transform: scale(1.3);"; }
        else if (p.includes("LEAGUE") || p === "LOL") { col = renkMap["League of Legends"]; logoDosya = "lol.png"; logoStili = "transform: scale(1.4);"; }
        else if (p.includes("CS2") || p.includes("COUNTER")) { col = renkMap["CS2"]; logoDosya = "cs2.png"; logoStili = "transform: scale(1.3);"; }
        // ÖDEV: Bu spesifik haber favorilerde var mı? Varsa dolu kalp, yoksa boş kalp göster
        const isFav = favoriler.includes(h.id.toString());
        const checkedAttr = isFav ? 'checked="checked"' : '';

        // ATLAS DOKUNUŞU: RENGİ TEKRAR MARKA RENGİNE (${col}) ÇEVİRDİK!
        return `
        <div class="news-row" style="--row-glow: ${col}" onclick="window.location.href='${basePathPage}haber-detay.php?id=${h.id}'">
            
            <label class="ui-like" onclick="event.stopPropagation();">
                <input type="checkbox" ${checkedAttr} onchange="toggleFavori(event, ${h.id})">
                <div class="checkmark">
                    <svg viewBox="0 0 256 256">
                    <rect fill="none" height="256" width="256"></rect>
                    <path d="M224.6,51.9a59.5,59.5,0,0,0-43-19.9,60.5,60.5,0,0,0-44,17.6L128,59.1l-7.5-7.4C97.2,28.3,59.2,26.3,35.9,47.4a59.9,59.9,0,0,0-2.3,87l83.1,83.1a15.9,15.9,0,0,0,22.6,0l81-81C243.7,113.2,245.6,75.2,224.6,51.9Z"></path>
                    </svg>
                </div>
            </label>

            <img src="${h.resim.startsWith('http') ? h.resim : (isSubPage ? '../' : '') + h.resim}" class="row-img" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
            <div class="row-info">
                <h3>${h.baslik}</h3>
                <p class="row-ozet">${h.ozet}</p>
                <div class="row-logo-container">
                  <img src="${basePathImg}logolar/${logoDosya}" alt="${h.platform}" class="platform-logo" style="${logoStili}" onerror="this.src='${basePathImg}logolar/default.png'">
                </div>
            </div>
        </div>`;
    }).join('');
}

function initHeroSlider(liste) {
    const track = document.getElementById('hero-slider-track');
    if (!track || liste.length === 0) return;

    const benzersizHaberler = [];
    const eklenenPlatformlar = new Set();
    const siraliListe = [...liste].sort((a, b) => b.id - a.id);

    for (const haber of siraliListe) {
        const platAd = haber.platform.trim();
        if (!eklenenPlatformlar.has(platAd)) {
            eklenenPlatformlar.add(platAd);
            benzersizHaberler.push(haber);
        }
    }

    track.innerHTML = benzersizHaberler.map((h, i) => {
        let logoDosya = "default.png";
        let logoBoyutu = "30px";
        let logoStili = ""; // Yeni eklendi: Ölçekleme için
        let platRenk = "#b76bff";

        // TÜRKÇE KARAKTER SORUNUNU KÖKTEN ÇÖZEN BÜYÜK HARF TAKTİĞİ
        const p = h.platform.toUpperCase();
        
        if (p.includes("STEAM")) { logoDosya = "steam.png"; platRenk = "#66c0f4"; }
        else if (p.includes("EPIC") || p.includes("EPİC")) { logoDosya = "epic.png"; platRenk = "#e0e0e0"; }
        else if (p.includes("NVIDIA") || p.includes("NVİDİA")) { logoDosya = "nvidia.png"; platRenk = "#76b900"; }
        else if (p.includes("AMD")) { logoDosya = "amd.png"; platRenk = "#ed1c24"; }
        else if (p.includes("INTEL") || p.includes("İNTEL")) { logoDosya = "intel.png"; platRenk = "#0071c5"; }
        else if (p.includes("PS") || p.includes("PLAYSTATION") || p.includes("PLAYSTATİON")) { logoDosya = "ps.png"; platRenk = "#003791"; }
        else if (p.includes("XBOX")) { logoDosya = "xbox.png"; logoBoyutu = "45px"; platRenk = "#107c10"; }
        else if (p.includes("NINTENDO") || p.includes("NİNTENDO")) { logoDosya = "nintendo.png"; platRenk = "#e60012"; }
        else if (p.includes("EA")) { logoDosya = "ea.png"; platRenk = "#ff4747"; }
        else if (p.includes("UBISOFT") || p.includes("UBİSOFT")) { logoDosya = "ubisoft.png"; platRenk = "#0070ff"; }
        else if (p.includes("RIOT") || p.includes("RİOT")) { logoDosya = "riot.png"; platRenk = "#eb0029"; }
        else if (p.includes("VALORANT")) { logoDosya = "valorant.png"; platRenk = "#ff4655"; logoStili = "transform: scale(1.3);"; }
        else if (p.includes("LEAGUE") || p === "LOL") { logoDosya = "lol.png"; platRenk = "#c89b3c"; logoStili = "transform: scale(1.4);"; }
        else if (p.includes("CS2") || p.includes("COUNTER")) { logoDosya = "cs2.png"; platRenk = "#f4a900"; logoStili = "transform: scale(1.3);"; }

        return `
        <div class="slider-item" data-index="${i}" style="--hover-color: ${platRenk}; cursor: pointer;" onclick="window.location.href='${basePathPage}haber-detay.php?id=${h.id}'">
            <div class="spin-glow-border"></div>
            <img src="${h.resim.startsWith('http') ? h.resim : (isSubPage ? '../' : '') + h.resim}" class="slider-bg-img" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
            <div class="slider-content">
                <span class="slider-tag" style="background: transparent; padding: 0; box-shadow: none;">
                <img src="${basePathImg}logolar/${logoDosya}" alt="${h.platform}" style="height: ${logoBoyutu}; object-fit: contain; ${logoStili}">
                </span>
                <h2>${h.baslik}</h2>
                <p class="slider-ozet">${h.ozet}</p>
            </div>
        </div>`;
    }).join('');

    const items = document.querySelectorAll('.slider-item');
    if (items.length > 0) {
        let curr = 0;
        const update = () => {
            items.forEach(it => it.className = 'slider-item');
            let prev = (curr === 0) ? items.length - 1 : curr - 1;
            let next = (curr === items.length - 1) ? 0 : curr + 1;
            items[curr].classList.add('active');
            items[prev].classList.add('prev');
            items[next].classList.add('next');
        };
        update();
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        if(prevBtn) prevBtn.onclick = () => { curr = (curr === 0) ? items.length - 1 : curr - 1; update(); };
        if(nextBtn) nextBtn.onclick = () => { curr = (curr === items.length - 1) ? 0 : curr + 1; update(); };
    }
}

/* --- HAMBURGER MENÜ --- */
document.addEventListener('DOMContentLoaded', () => {
    const hamburger = document.querySelector('.hamburger-menu');
    const hamburgerContent = document.querySelector('.hamburger-content');
    if (!hamburger || !hamburgerContent) return;

    hamburger.querySelector('.hamburger-icon').addEventListener('click', (e) => {
        e.stopPropagation();
        hamburger.classList.toggle('active');
        hamburgerContent.classList.toggle('active');
    });

    document.addEventListener('click', () => {
        hamburger.classList.remove('active');
        hamburgerContent.classList.remove('active');
    });

    hamburgerContent.addEventListener('click', (e) => e.stopPropagation());
});

/* === CANLI SKOR SİSTEMİ (HEM SKOR HEM E-SPOR SAYFASI İÇİN) === */
document.addEventListener("DOMContentLoaded", async () => {
    const scoreBoard = document.getElementById('live-score-board'); // Canlı Skor sayfası için
    const esporBoard = document.getElementById('espor-match-list'); // E-Spor sayfası için

    // Eğer bu iki sayfada da değilsek kodu çalıştırma (Performans tasarrufu)
    if (!scoreBoard && !esporBoard) return;

    // Veritabanından Maçları Tek Seferde Çek
    let butunMaclar = [];
    try {
        const apiYolu = isSubPage ? '../api_skor.php' : 'api_skor.php';
        const response = await fetch(apiYolu + "?v=" + new Date().getTime());
        butunMaclar = await response.json();
    } catch (error) { console.error("Maçlar çekilemedi:", error); }

    // --- 1. SENARYO: EĞER CANLI SKOR SAYFASINDAYSAK ---
    if (scoreBoard) {
        const urlParams = new URLSearchParams(window.location.search);
        let currentOyunFiltresi = urlParams.get('game') || 'all';
        let currentDurumFiltresi = 'all'; // Yeni filtre durumunu tutan değişken

        let firstActive = true;
        document.querySelectorAll('.game-filter-card').forEach(card => {
            if (card.getAttribute('data-game') === currentOyunFiltresi && firstActive) {
                card.classList.add('active');
                firstActive = false;
            }
        });

        // Üst Bar ve Filtre HTML'ini üreten fonksiyon
        function getFilterBarHTML() {
            return `
            <div class="matches-title-bar">
                <h3 class="matches-main-title">- GÜNÜN MAÇLARI -</h3>
                <div class="status-filter-wrapper">
                    <div class="status-main-btn">FİLTRE <span style="font-size:10px; margin-left:6px;">◀</span></div>
                    <div class="status-options">
                        <span class="s-opt ${currentDurumFiltresi === 'all' ? 'active' : ''}" data-val="all">TÜMÜ</span>
                        <span class="s-opt ${currentDurumFiltresi === 'CANLI' ? 'active' : ''}" data-val="CANLI">CANLI</span>
                        <span class="s-opt ${currentDurumFiltresi === 'BAŞLAMADI' ? 'active' : ''}" data-val="BAŞLAMADI">BEKLENİYOR</span>
                        <span class="s-opt ${currentDurumFiltresi === 'MS' ? 'active' : ''}" data-val="MS">MS</span>
                    </div>
                </div>
            </div>`;
        }

        // Seçeneklere tıklandığında filtrelemeyi tetikleyen fonksiyon
        function bindFilterEvents() {
            document.querySelectorAll('.s-opt').forEach(opt => {
                opt.addEventListener('click', function(e) {
                    e.stopPropagation(); // Tıklamanın menüyü kapatmasını engeller
                    currentDurumFiltresi = this.getAttribute('data-val');
                    scoreBoard.innerHTML = `<div style="text-align: center; padding: 50px 0; color: #888;"><span class="red-dot" style="display:inline-block; margin-right:10px;">•</span><h3 style="display:inline-block;">Filtreleniyor...</h3></div>`;
                    setTimeout(() => { maclariEkranaBas(); }, 200);
                });
            });
        }

        function maclariEkranaBas() {
            // 1. Önce oyuna göre filtrele (CS2, LoL vb.)
            let gosterilecekMaclar = currentOyunFiltresi === 'all' ? butunMaclar : butunMaclar.filter(m => m.oyun === currentOyunFiltresi);

            // 2. Sonra kullanıcının seçtiği duruma göre filtrele (CANLI, MS vb.)
            if (currentDurumFiltresi !== 'all') {
                gosterilecekMaclar = gosterilecekMaclar.filter(m => m.durum === currentDurumFiltresi);
            }

            // Eğer filtre sonucunda hiç maç kalmazsa
            if (gosterilecekMaclar.length === 0) {
                scoreBoard.innerHTML = `
                    ${getFilterBarHTML()}
                    <h3 style="text-align: center; color: #ff4747; margin-top: 50px;">Şu an bu filtreye uygun maç bulunmuyor.</h3>
                `;
                bindFilterEvents();
                return;
            }

            const oyunIsimSözlüğü = { "cs2": "COUNTER-STRİKE 2", "lol": "LEAGUE OF LEGENDS", "dota": "DOTA 2", "valorant": "VALORANT" };
            const matchesByGroup = gosterilecekMaclar.reduce((acc, match) => {
                const groupKey = `${match.oyun}_${match.lig}`; 
                if (!acc[groupKey]) acc[groupKey] = [];
                acc[groupKey].push(match);
                return acc;
            }, {});

            let htmlContent = getFilterBarHTML(); // Başlık ve filtreyi en başa ekler

            for (const [groupKey, matches] of Object.entries(matchesByGroup)) {
                const oyunKod = matches[0].oyun ? matches[0].oyun.toLowerCase() : 'default';
                const ligAdi = matches[0].lig; 
                const gosterilecekOyunAdi = oyunIsimSözlüğü[oyunKod] || oyunKod.toUpperCase();
                const logoYolu = `${basePathImg}canliskorlogolar/${oyunKod}logo.png`;

                let ekstraStil = "transform: scale(1);";
                if (oyunKod.includes('valorant')) ekstraStil = "transform: scale(1.4);";
                else if (oyunKod.includes('lol')) ekstraStil = "transform: scale(1.5);";
                else if (oyunKod.includes('dota')) ekstraStil = "transform: scale(1.6);";

                htmlContent += `
                    <div class="league-group">
                        <div class="league-header">
                            <img src="${logoYolu}" style="width: 32px; height: 22px; object-fit: contain; object-position: center; display: block; margin-right: 15px; ${ekstraStil}" onerror="this.style.display='none'"> 
                            ${ligAdi} <span style="margin-left:auto; font-size:10px; opacity:0.6; letter-spacing:1px;">${gosterilecekOyunAdi}</span>
                        </div>
                        <div class="league-matches">
                            ${matches.map(m => {
                                let evRenk = takimRenkleri[m.ev_sahibi.toLowerCase()] || "rgba(255, 255, 255, 0.4)";
                                let depRenk = takimRenkleri[m.deplasman.toLowerCase()] || "rgba(255, 255, 255, 0.4)";

                                return `
                                <div class="match-row">
                                    <div class="match-time-status">
                                        <span class="match-time">${m.durum === 'CANLI' ? '<span class="red-dot">•</span> <span style="color: #ff4747;">CANLI</span>' : (m.durum === 'MS' ? 'MS' : m.saat)}</span>
                                        <span class="match-status ${m.durum === 'CANLI' ? 'live' : ''}">${m.durum === 'CANLI' ? '' : m.periyot}</span>
                                    </div>
                                    <div class="team-home" style="display: flex; align-items: center; justify-content: flex-end; gap: 10px;">
                                        ${m.ev_sahibi}
                                        <img src="${basePathImg}takimlogolar/${m.ev_sahibi.toLowerCase().replace(/\s+/g, '-').replace(/ç/g, 'c').replace(/ğ/g, 'g').replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ş/g, 's').replace(/ü/g, 'u')}.png" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 8px ${evRenk});" onerror="this.style.display='none'">
                                    </div>
                                    <div class="match-score ${m.durum === 'CANLI' ? 'live-score-bg' : ''}">${m.skor}</div>
                                    <div class="team-away" style="display: flex; align-items: center; justify-content: flex-start; gap: 10px;">
                                        <img src="${basePathImg}takimlogolar/${m.deplasman.toLowerCase().replace(/\s+/g, '-').replace(/ç/g, 'c').replace(/ğ/g, 'g').replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ş/g, 's').replace(/ü/g, 'u')}.png" style="width: 40px; height: 40px; object-fit: contain; filter: drop-shadow(0 0 8px ${depRenk});" onerror="this.style.display='none'">
                                        ${m.deplasman}
                                    </div>
                                </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                `;
            }
            scoreBoard.innerHTML = htmlContent;
            bindFilterEvents(); // Sayfa yenilendiğinde eventleri tekrar bağlar
        }

        maclariEkranaBas();

        document.querySelectorAll('.game-filter-card').forEach(kart => {
            kart.addEventListener('click', function(e) {
                e.preventDefault(); 
                document.querySelectorAll('.game-filter-card').forEach(k => k.classList.remove('active'));
                this.classList.add('active');
                
                currentOyunFiltresi = this.getAttribute('data-game');
                currentDurumFiltresi = 'all'; // Oyun değiştiğinde filtrelemeyi sıfırla ki tüm maçlar gelsin

                scoreBoard.innerHTML = `<div style="text-align: center; padding: 50px 0; color: #888;"><span class="red-dot" style="display:inline-block; margin-right:10px;">•</span><h3 style="display:inline-block;">Canlı veriler çekiliyor...</h3></div>`;
                setTimeout(() => { maclariEkranaBas(); }, 300);
            });
        });
    }
    // --- 2. SENARYO: EĞER E-SPOR SAYFASINDAYSAK (WIDGET) ---
    if (esporBoard) {
        if (butunMaclar.length === 0) {
            esporBoard.innerHTML = '<div style="color:#888; text-align:center; padding:15px;">Şu an veritabanında maç bulunmuyor.</div>';
        } else {
            // E-Spor menüsüne sığması için sadece en güncel 4 maçı alıyoruz
            const miniMaclar = butunMaclar.slice(0, 4);
            
            esporBoard.innerHTML = miniMaclar.map(m => {
                const ortadakiDeger = (m.durum === 'CANLI' || m.durum === 'MS') ? m.skor : m.saat;
                const canliClass = m.durum === 'CANLI' ? 'live-score' : '';
                
                const oyunKod = m.oyun ? m.oyun.toLowerCase() : 'default';
                const logoYolu = `${basePathImg}canliskorlogolar/${oyunKod}logo.png`;
                
                // Takım renklerini sözlükten çekiyoruz
                let evRenk = takimRenkleri[m.ev_sahibi.toLowerCase()] || "rgba(255, 255, 255, 0.4)";
                let depRenk = takimRenkleri[m.deplasman.toLowerCase()] || "rgba(255, 255, 255, 0.4)";
                
                // Oyun logosu için ölçekleme
                let ekstraStil = "transform: scale(1);";
                if (oyunKod.includes('valorant')) ekstraStil = "transform: scale(1.4);";
                else if (oyunKod.includes('lol')) ekstraStil = "transform: scale(1.5);";
                else if (oyunKod.includes('dota')) ekstraStil = "transform: scale(1.6);";
                
                // Takım logoları için URL oluşturma fonksiyonu (Kod tekrarını azaltmak için)
                const getLogo = (name) => `${basePathImg}takimlogolar/${name.toLowerCase().replace(/\s+/g, '-').replace(/ç/g, 'c').replace(/ğ/g, 'g').replace(/ı/g, 'i').replace(/ö/g, 'o').replace(/ş/g, 's').replace(/ü/g, 'u')}.png`;

                return `
                <div class="match-item">
                    <div class="match-game-name" style="display: flex; align-items: center; gap: 6px;">
                        <img src="${logoYolu}" style="width: 24px; height: 16px; object-fit: contain; object-position: center; display: block; ${ekstraStil}" onerror="this.style.display='none'"> 
                        <span style="opacity: 0.6;">-</span> ${m.lig}
                    </div>
                    
                    <div class="match-teams" style="display: flex; align-items: center; justify-content: space-between;">
                        <span class="team" style="display: flex; align-items: center; gap: 8px; flex: 1; justify-content: flex-end;">
                            ${m.ev_sahibi}
                            <img src="${getLogo(m.ev_sahibi)}" style="width: 20px; height: 20px; object-fit: contain; filter: drop-shadow(0 0 5px ${evRenk});" onerror="this.style.display='none'">
                        </span>
                        
                        <span class="score ${canliClass}" style="margin: 0 15px; min-width: 45px; text-align: center;">${ortadakiDeger}</span>
                        
                        <span class="team" style="display: flex; align-items: center; gap: 8px; flex: 1; justify-content: flex-start;">
                            <img src="${getLogo(m.deplasman)}" style="width: 20px; height: 20px; object-fit: contain; filter: drop-shadow(0 0 5px ${depRenk});" onerror="this.style.display='none'">
                            ${m.deplasman}
                        </span>
                    </div>
                </div>`;
            }).join('');
        }
    }
});

/* === SÜRÜKLE BIRAK === */
document.addEventListener("DOMContentLoaded", () => {
    const marqueeContainer = document.querySelector('.marquee-container');
    if (marqueeContainer) {
        let isDown = false; let startX; let scrollLeft; let animationId; let isDragging = false;
        function autoScroll() {
            if (!isDown) {
                marqueeContainer.scrollLeft += 0.5;
                if (marqueeContainer.scrollLeft >= marqueeContainer.scrollWidth / 2) marqueeContainer.scrollLeft = 0;
            }
            animationId = requestAnimationFrame(autoScroll);
        }
        autoScroll();

        marqueeContainer.addEventListener('mousedown', (e) => {
            isDown = true; isDragging = false; startX = e.pageX - marqueeContainer.offsetLeft; scrollLeft = marqueeContainer.scrollLeft; cancelAnimationFrame(animationId);
        });
        marqueeContainer.addEventListener('mouseleave', () => { if(isDown) { isDown = false; autoScroll(); } });
        marqueeContainer.addEventListener('mouseup', () => { isDown = false; autoScroll(); });
        marqueeContainer.addEventListener('mousemove', (e) => {
            if (!isDown) return;
            e.preventDefault(); window.getSelection().removeAllRanges();
            const x = e.pageX - marqueeContainer.offsetLeft; const walk = (x - startX) * 2;
            if (Math.abs(walk) > 3) isDragging = true;
            marqueeContainer.scrollLeft = scrollLeft - walk;
        });
        marqueeContainer.querySelectorAll('img, a').forEach(el => {
            el.addEventListener('dragstart', (e) => e.preventDefault()); el.style.webkitUserDrag = 'none';
            if (el.tagName === 'IMG' && el.src.includes('img/') && !el.src.includes('logolar/')) {
                 const parts = el.src.split('/'); const fileName = parts[parts.length - 1];
                 if(fileName !== 'logo.png') el.src = basePathImg + 'canliskorkartlar/' + fileName;
            }
        });
        // Scroll sırasında takılan hover state'leri temizle
        marqueeContainer.addEventListener('scroll', () => {
            marqueeContainer.querySelectorAll('.game-filter-card').forEach(c => {
                c.blur();
            });
        }, { passive: true });
        marqueeContainer.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', (e) => { if (isDragging) e.preventDefault(); });
        });
    }
});

/* === MODAL KONTROLLERİ === */
function openAuthModal(tab) {
    const modal = document.getElementById('authModal');
    if(modal) { modal.classList.add('show'); switchAuthTab(tab); }
}
function closeAuthModal() {
    const modal = document.getElementById('authModal');
    if(modal) { modal.classList.remove('show'); document.getElementById('auth-message-box').style.display = 'none'; }
}
function switchAuthTab(tab) {
    document.querySelectorAll('.auth-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.auth-form-section').forEach(f => f.classList.remove('active'));
    const activeTab = document.getElementById('tab-' + tab);
    const activeForm = document.getElementById('form-' + tab);
    if(activeTab) activeTab.classList.add('active');
    if(activeForm) activeForm.classList.add('active');
    const msgBox = document.getElementById('auth-message-box');
    if(msgBox) msgBox.style.display = 'none';
}
window.addEventListener('click', (e) => { if (e.target === document.getElementById('authModal')) closeAuthModal(); });
function showAuthMessage(type, text) {
    const msgBox = document.getElementById('auth-message-box');
    if(!msgBox) return;
    msgBox.style.display = 'block'; msgBox.innerHTML = text;
    if (type === 'error') { msgBox.style.background = 'rgba(237, 28, 36, 0.1)'; msgBox.style.color = '#ed1c24'; msgBox.style.border = '1px solid #ed1c24'; }
    else { msgBox.style.background = 'rgba(118, 185, 0, 0.1)'; msgBox.style.color = '#76b900'; msgBox.style.border = '1px solid #76b900'; }
}

/* === AJAX FORM İŞLEMLERİ (GÜVENLİ) === */
document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById('ajaxLoginForm');
    const registerForm = document.getElementById('ajaxRegisterForm');
    const prefix = isSubPage ? '../' : '';

    if(loginForm) {
        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch(prefix + 'ajax_login.php', { method: 'POST', body: new FormData(e.target) });
                const result = await response.json();
                
                if (result.status === 'success') { 
                    localStorage.setItem('oturum', 'acik');
                    showAuthMessage('success', 'Giriş Başarılı!'); 
                    setTimeout(() => { window.location.href = prefix + 'index.php'; }, 1000); 
                }
                else { showAuthMessage('error', result.message); }
            } catch (error) { console.error('Giriş hatası:', error); }
        });
    }

    if(registerForm) {
        registerForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            try {
                const response = await fetch(prefix + 'ajax_kayit.php', { method: 'POST', body: new FormData(e.target) });
                const result = await response.json();
                if (result.status === 'success') { showAuthMessage('success', result.message); setTimeout(() => { switchAuthTab('login'); }, 2000); }
                else { showAuthMessage('error', result.message); }
            } catch (error) { console.error('Kayıt hatası:', error); }
        });
    }
    const sifreForm = document.getElementById('ajaxSifreDegistirForm');
    
    if(sifreForm) {
        sifreForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            try {
                const response = await fetch(prefix + 'ajax_sifre_degistir.php', { 
                    method: 'POST', 
                    body: new FormData(e.target) 
                });
                const result = await response.json();
                
                if (result.status === 'success') { 
                    alert('Başarılı: ' + result.message);
                    sifreForm.reset();
                    document.getElementById('profilModal').classList.remove('show');
                } else { 
                    alert('Hata: ' + result.message); 
                }
            } catch (error) { 
                console.error('Şifre değiştirme hatası:', error); 
                alert('Sistemsel bir hata oluştu.');
            }
        });
    }
});

/* === OTURUM KONTROLÜ VE HEADER GÜNCELLEMESİ === */
async function kontrolEtOturum() {
    try {
        const prefix = isSubPage ? '../' : '';
        const response = await fetch(prefix + 'ajax_session.php');
        const data = await response.json();
        const isMobile = () => window.innerWidth <= 768;

        if (data.logged_in) {
            localStorage.setItem('oturum', 'acik');
            // ATLAS DOKUNUŞU 1: Giriş yapanın adını sarsılmaz hafızaya kaydet
            localStorage.setItem('aktif_kullanici', data.kullanici_adi.toLowerCase().trim());

            const authGroup = document.querySelector('.header-auth-group');
            if (authGroup) authGroup.style.display = 'none';

            if (document.getElementById('user-panel-active')) {
                _guncelleMobilOturumLinkleri(data, prefix);
                ekranaBas(allNewsData); 
                return;
            }

            const userBadge = document.createElement('div');
            userBadge.id = 'user-panel-active';
            userBadge.className = 'user-badge-desktop';
            userBadge.style.cssText = 'display: inline-flex; align-items: center; gap: 6px; margin-right: 10px;';

            let adminBtn = data.rol === 'admin'
                ? `<a href="${prefix}admin.php" style="background:#b76bff;color:#fff;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:bold;text-decoration:none;">PANEL</a>`
                : '';

            userBadge.innerHTML = `
                <span style="color:#fff;font-weight:bold;font-size:14px;white-space:nowrap;">👤 ${data.kullanici_adi.toUpperCase()}</span>
                ${adminBtn}
                <button onclick="openProfilModal('${data.kullanici_adi}','${data.eposta || 'Belirtilmemiş'}')" style="background:rgba(183,107,255,0.1);color:#b76bff;border:1px solid #b76bff;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:bold;cursor:pointer;">PROFİL</button>
                <a href="${prefix}cikis.php" style="background:rgba(237,28,36,0.2);color:#ff4747;padding:6px 12px;border-radius:6px;font-size:12px;font-weight:bold;border:1px solid #ff4747;text-decoration:none;">ÇIKIŞ</a>
            `;

            const liveScoreBtn = document.querySelector('.live-score-btn');
            if (liveScoreBtn) liveScoreBtn.parentNode.insertBefore(userBadge, liveScoreBtn);

            _guncelleMobilOturumLinkleri(data, prefix);

            // Her şey hazır, kalpleri boyayarak haberleri bas
            ekranaBas(allNewsData); 

        } else {
            localStorage.removeItem('oturum');
            // ATLAS DOKUNUŞU 2: Çıkış yapıldığında hafızadaki ismi de sil
            localStorage.removeItem('aktif_kullanici');
            
            document.documentElement.classList.remove('oturum-bekleniyor');
            const authGroup = document.querySelector('.header-auth-group');
            if (authGroup) authGroup.style.display = 'flex';

            document.getElementById('hamburger-oturum-blok')?.remove();
            const mobileAuth = document.getElementById('hamburger-auth-blok');
            if (mobileAuth) mobileAuth.style.display = 'block';

            // Ziyaretçi için haberleri bas (kalpler boş)
            ekranaBas(allNewsData); 
        }
    } catch(e) {
        console.error('Oturum bilgisi çekilemedi:', e);
        ekranaBas(allNewsData); 
    }
}

function _guncelleMobilOturumLinkleri(data, prefix) {
    document.getElementById('hamburger-oturum-blok')?.remove();
    const mobileAuth = document.getElementById('hamburger-auth-blok');
    if (mobileAuth) {
        mobileAuth.style.display = 'none';
        let adminLink = data.rol === 'admin' ? `<a href="${prefix}admin.php" id="hm-admin">PANEL</a>` : '';
        mobileAuth.innerHTML = `
            ${adminLink}
            <a href="${prefix}pages/favoriler.php" id="hm-favoriler">FAVORİLER</a>
            <a href="#" onclick="openProfilModal('${data.kullanici_adi}','${data.eposta || 'Belirtilmemiş'}');return false;" id="hm-profil">PROFİL 👤</a>
            <a href="${prefix}cikis.php" id="hm-cikis" style="color:#ff4d4d;">ÇIKIŞ YAP</a>
        `;
        mobileAuth.style.display = 'block';
    }
}


/* === YORUM SİSTEMİ === */
async function yorumlariGetir(haber_id) {
    const prefix = window.location.pathname.includes('/pages/') ? '../' : '';
    const liste = document.getElementById('yorum-listesi');
    if(!liste) return;
    liste.innerHTML = '<p style="color:#888;">Yorumlar yükleniyor...</p>';
    try {
        const response = await fetch(`${prefix}ajax_yorum.php?haber_id=${haber_id}`);
        const yorumlar = await response.json();
        liste.innerHTML = '';
        if(yorumlar.length === 0) { liste.innerHTML = '<p style="color:#888;">Henüz yorum yapılmamış. İlk yorumu sen yap!</p>'; return; }
        yorumlar.forEach(y => {
            let adminRozet = y.rol === 'admin' ? '<span style="background:#ed1c24; color:#fff; padding:2px 6px; border-radius:4px; font-size:10px; margin-left:5px;">ADMIN</span>' : '';
            liste.innerHTML += `<div style="background:#151515; border:1px solid #333; border-radius:8px; padding:15px; margin-bottom:10px;"><div style="display:flex; justify-content:space-between; margin-bottom:10px;"><strong style="color:#b76bff;">${y.yazan_kisi} ${adminRozet}</strong><span style="font-size:11px; color:#666;">${y.tarih}</span></div><p style="margin:0; font-size:14px; color:#ddd; line-height:1.5;">${y.yorum}</p></div>`;
        });
    } catch(e) { console.error("Yorum hatası:", e); }
}

async function yorumGonder(event, haber_id) {
    event.preventDefault();
    const prefix = window.location.pathname.includes('/pages/') ? '../' : '';
    const yorumKutusu = document.getElementById('yorum-kutusu');
    if(!yorumKutusu) return;
    const formData = new FormData(); formData.append('haber_id', haber_id); formData.append('yorum', yorumKutusu.value);
    try {
        const response = await fetch(`${prefix}ajax_yorum.php`, { method: 'POST', body: formData });
        const result = await response.json();
        if(result.status === 'success') { yorumKutusu.value = ''; yorumlariGetir(haber_id); }
        else { alert(result.message); }
    } catch(e) { console.error("Gönderme hatası:", e); }
}

async function haberDetayiniGetir() {
    const urlParams = new URLSearchParams(window.location.search);
    const haberId = urlParams.get('id');
    if (!haberId) return;
    
    const prefix = window.location.pathname.includes('/pages/') ? '../' : '';
    
    try {
        const response = await fetch(`${prefix}ajax_haber_detay.php?id=${haberId}`);
        const result = await response.json();
        
        if (result.status === "success") {
            const haber = result.data;
            document.title = "GAMEPORTAL - " + haber.baslik;
            
            const dBaslik = document.getElementById('detay-baslik'); 
            if (dBaslik) {
                const plat = haber.platform.trim();
                const renkler = markaRenkleri[plat] || markaRenkleri["PC"];
                
                let logoDosya = "default.png";
                let logoStili = "";
                const p = plat.toLowerCase();
                if (p.includes("steam")) logoDosya = "steam.png";
                else if (p.includes("epic")) logoDosya = "epic.png";
                else if (p.includes("nvidia")) logoDosya = "nvidia.png";
                else if (p.includes("amd")) logoDosya = "amd.png";
                else if (p.includes("intel")) logoDosya = "intel.png";
                else if (p.includes("ps")) logoDosya = "ps.png";
                else if (p.includes("xbox")) { logoDosya = "xbox.png"; logoStili = "transform: scale(1.6);"; }
                else if (p.includes("nintendo")) logoDosya = "nintendo.png";
                else if (p.includes("ea")) logoDosya = "ea.png";
                else if (p.includes("ubisoft")) logoDosya = "ubisoft.png";

                dBaslik.innerHTML = `
                    <span style="flex: 1; margin-right: 20px;">${haber.baslik}</span>
                    <div style="display: flex; align-items: center; justify-content: center; width: 60px;">
                        <img src="${basePathImg}logolar/${logoDosya}" alt="${plat}" 
                             style="height: 35px; object-fit: contain; 
                             filter: drop-shadow(0 2px 5px rgba(0,0,0,0.6)); /* Beyaz ışık yerine hafif siyah gölge */
                             ${logoStili}" 
                             onerror="this.style.display='none'">
                    </div>
                `;

                dBaslik.style.display = 'flex';
                dBaslik.style.alignItems = 'center';
                dBaslik.style.justifyContent = 'space-between';
                
                dBaslik.style.background = `linear-gradient(90deg, ${renkler.darker}, ${renkler.light}, ${renkler.darker})`;
                dBaslik.style.borderLeft = `4px solid ${renkler.light}`;
                dBaslik.style.padding = '10px 25px';
                dBaslik.style.borderRadius = '0 8px 8px 0';
                dBaslik.style.color = '#fff';
                dBaslik.style.textShadow = '0 2px 4px rgba(0,0,0,0.5)';
            }

            const dIcerik = document.getElementById('detay-icerik'); 
            
            
            if (dIcerik) { 
                let icerikHTML = haber.icerik.replace(/\n/g, '<br>');
                
                // Varsa Kaynak Butonunu Ekliyoruz
                if (haber.kaynak_url) {
                    icerikHTML += `<br><br><a href="${haber.kaynak_url}" target="_blank" class="kaynak-btn">HABER KAYNAĞINA GİT 🔗</a>`;
                }
                dIcerik.innerHTML = icerikHTML;
            }
            
            const resimElement = document.getElementById('detay-resim'); 
            if(resimElement) { 
                resimElement.src = haber.resim.startsWith('http') ? haber.resim : prefix + haber.resim; 
                resimElement.style.display = 'block'; 
            }
            
            yorumlariGetir(haberId);
            
            const yorumForm = document.getElementById('yorumFormu');
            if(yorumForm) yorumForm.onsubmit = (event) => yorumGonder(event, haberId);
            
        } else {
            const dBaslik = document.getElementById('detay-baslik'); if(dBaslik) dBaslik.innerText = "Hata!";
            const dIcerik = document.getElementById('detay-icerik'); if(dIcerik) dIcerik.innerText = result.message;
        }
    } catch (error) { 
        console.error("Haber çekilirken hata oluştu:", error); 
    }
}
document.addEventListener('DOMContentLoaded', () => { if (window.location.pathname.includes('haber-detay.php')) haberDetayiniGetir(); });

/* === PROFİL MODAL KONTROLÜ === */
function openProfilModal(kullaniciAdi, eposta) {
    const modal = document.getElementById('profilModal');
    if(modal) {
        document.getElementById('profil-kullanici-adi').innerText = kullaniciAdi.toUpperCase();
        document.getElementById('profil-eposta').innerText = eposta;
        modal.classList.add('show');
    }
}

// Profil modalını dışarı tıklayarak (karanlık alana) kapatma özelliği
window.addEventListener('click', (e) => { 
    const profilModal = document.getElementById('profilModal');
    if (e.target === profilModal) {
        profilModal.classList.remove('show');
    }
});
/* === LOGO HOVER: STATIC ↔ GIF === */
document.addEventListener('DOMContentLoaded', () => {
    const logo = document.getElementById('site-logo');
    if (!logo) return;

    const staticSrc = logo.dataset.static;
    const hoverSrc  = logo.dataset.hover;

    // GIF'i önceden yükle — ilk hover'da gecikme olmasın
    const preload = new Image();
    preload.src = hoverSrc;

    logo.addEventListener('mouseenter', () => {
        // src sıfırlanmazsa GIF cache'den gelir ve animasyon başlamaz
        logo.src = '';
        logo.src = hoverSrc;
    });

    logo.addEventListener('mouseleave', () => {
        logo.src = staticSrc;
    });
});

/* === AKTİF SAYFA MENÜ RENKLENDİRMESİ === */
document.addEventListener('DOMContentLoaded', () => {
    // Eğer şu anki sayfanın adresinde 'canli-skor.php' geçiyorsa
    if (window.location.pathname.includes('canli-skor.php')) {
        const liveBtn = document.querySelector('.live-score-btn');
        if (liveBtn) {
            // Butondaki beyaz (!important) kuralını ezip mor yapıyoruz
            liveBtn.style.setProperty('color', '#b76bff', 'important');
        }
    }
});

/* === YUKARI ÇIK BUTONU ÖZELLİĞİ === */
document.addEventListener('DOMContentLoaded', () => {
    // 1. Buton Elementini Oluşturma
    const scrollBtn = document.createElement('button');
    scrollBtn.id = 'scrollTopBtn';
    scrollBtn.innerHTML = '▲';
    scrollBtn.title = 'Yukarı Çık';
    document.body.appendChild(scrollBtn);

    // 2. Kaydırma Takibi (Scroll Event)
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) { // 300px aşağı inilince göster
            scrollBtn.classList.add('show');
        } else {
            scrollBtn.classList.remove('show');
        }
    });

    // 3. Tıklama Olayı (Click Event)
    scrollBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Pürüzsüz kaydırma efekti
        });
    });
});

/* === FAVORİLERE EKLEME SİSTEMİ (ÜYE KONTROLLÜ & KULLANICIYA ÖZEL) === */
window.toggleFavori = function(event, id) {
    // 1. KULLANICIYI TANI: Kimin hafıza kutusuna yazacağımızı belirliyoruz
    const userKey = getFavoriKey(); 

    // 2. GÜVENLİK KONTROLÜ: Oturum kapalıysa veya kullanıcı adı yüklenmemişse engelle
    if (!userKey || localStorage.getItem('oturum') !== 'acik') {
        event.preventDefault(); // Kalbin dolmasını engelle
        openAuthModal('login'); // Giriş panelini aç
        showAuthMessage('error', 'Favorilere eklemek için giriş yapın!');
        return;
    }

    // 3. HAFIZADAN OKU: Sadece bu kullanıcıya özel olan çekmeceyi açıyoruz
    let favoriler = JSON.parse(localStorage.getItem(userKey)) || [];
    const stringId = id.toString();
    const isChecked = event.target.checked; // Kalbe basıldı mı (true) yoksa çekildi mi (false)

    if (isChecked) {
        // İşaretlendiyse ve listede yoksa kullanıcı kutusuna ekle
        if (!favoriler.includes(stringId)) favoriler.push(stringId);
    } else {
        // İşareti kaldırıldıysa listeden sil
        favoriler = favoriler.filter(fId => fId !== stringId);
        
        // Eğer favoriler sayfasındaysak kartın anında kaybolmasını sağlayan kod
        const kart = event.target.closest('.news-row');
        if (window.location.pathname.includes('favoriler.php') && kart) {
            kart.style.transition = "0.3s";
            kart.style.opacity = "0";
            setTimeout(() => kart.style.display = "none", 300);
        }
    }
    
    // 4. HAFIZAYA KAYDET: Güncel listeyi kullanıcıya özel anahtarla tarayıcıya kilitle
    localStorage.setItem(userKey, JSON.stringify(favoriler));
};

/* === TAKİP ET SİSTEMİ === */
window.toggleTakip = function(event, platformAdi) {
    event.preventDefault(); // Linke tıklamayı engelle
    event.stopPropagation(); // Kartın içine girilmesini engelle

    const aktifKullanici = localStorage.getItem('aktif_kullanici');
    
    // Giriş yapılmadıysa engelle
    if (!aktifKullanici || localStorage.getItem('oturum') !== 'acik') {
        openAuthModal('login');
        showAuthMessage('error', 'Takip etmek için giriş yapın!');
        return;
    }

    const storageKey = 'takip_' + aktifKullanici;
    let takipListesi = JSON.parse(localStorage.getItem(storageKey)) || [];
    const btn = event.currentTarget;
    const textEl = btn.querySelector('.text');

    if (takipListesi.includes(platformAdi)) {
        // Takipten Çık
        takipListesi = takipListesi.filter(p => p !== platformAdi);
        btn.classList.remove('active');
        textEl.innerText = "Takip Et";
    } else {
        // Takip Et
        takipListesi.push(platformAdi);
        btn.classList.add('active');
        textEl.innerText = "Takipte";
    }

    // Güncel durumu kullanıcının hafızasına kaydet
    localStorage.setItem(storageKey, JSON.stringify(takipListesi));
};

// Sayfa yüklendiğinde hafızaya bakıp takip edilen butonları yeşil (aktif) yapar
document.addEventListener("DOMContentLoaded", () => {
    const aktifKullanici = localStorage.getItem('aktif_kullanici');
    if (aktifKullanici && localStorage.getItem('oturum') === 'acik') {
        const storageKey = 'takip_' + aktifKullanici;
        const takipListesi = JSON.parse(localStorage.getItem(storageKey)) || [];

        document.querySelectorAll('.bookmarkBtn').forEach(btn => {
            const platformAdi = btn.getAttribute('data-platform');
            if (takipListesi.includes(platformAdi)) {
                btn.classList.add('active');
                btn.querySelector('.text').innerText = "Takipte";
            }
        });
    }
});