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
    "PC": { dark: "#222222", darker: "#111111", light: "#b76bff" }
};

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

    // 3. Veritabanı Bağlantısı
    try {
        let apiYolu = isSubPage ? '../api.php' : 'api.php';
        if (secilenPlatform) {
            apiYolu += `?platform=${secilenPlatform}`;
        }
        const response = await fetch(apiYolu);
        allNewsData = await response.json();
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
                <img src="${isSubPage ? '../' : ''}${secilenHaber.resim}" class="detay-ana-resim" alt="${secilenHaber.baslik}" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
                <div class="detay-metin-alani">
                    <p class="detay-ozet">${secilenHaber.ozet}</p>
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

    ekranaBas(allNewsData);

    // 6. Carousel Navigasyon
    const container = document.getElementById('haberler');
    const nextBtn = document.getElementById('news-next');
    const prevBtn = document.getElementById('news-prev');

    if (nextBtn && prevBtn && container) {
        nextBtn.onclick = () => {
            const viewportWidth = container.parentElement.clientWidth;
            const maxScroll = container.scrollWidth - viewportWidth;
            if (currentScroll < maxScroll) {
                currentScroll += 325;
                if (currentScroll > maxScroll) currentScroll = maxScroll;
                container.style.transform = `translateX(-${currentScroll}px)`;
            }
        };
        prevBtn.onclick = () => {
            if (currentScroll > 0) {
                currentScroll -= 295;
                if (currentScroll < 0) currentScroll = 0;
                container.style.transform = `translateX(-${currentScroll}px)`;
            }
        };
    }
const newsWrapper = document.querySelector('.news-carousel-wrapper');
    // Senin 108. satırda tanımladığın 'container' değişkenini kullanıyoruz

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

    const renkMap = {
        "Steam": "#66c0f4", "Epic Games": "#e0e0e0", "Nvidia": "#76b900",
        "AMD": "#ed1c24", "Intel": "#0071c5", "PS": "#003791",
        "Xbox": "#107c10", "EA Games": "#ff4747", "Ubisoft": "#0070ff",
        "Nintendo": "#e60012", "PC": "#b76bff"
    };

    container.innerHTML = liste.map(h => {
        let col = "#b76bff";
        let logoDosya = "default.png";
        let logoStili = "";

        if (h.platform.includes("Steam")) { col = renkMap["Steam"]; logoDosya = "steam.png"; }
        else if (h.platform.includes("Epic Games")) { col = renkMap["Epic Games"]; logoDosya = "epic.png"; }
        else if (h.platform.includes("EA Games")) { col = renkMap["EA Games"]; logoDosya = "ea.png"; }
        else if (h.platform.includes("Ubisoft")) { col = renkMap["Ubisoft"]; logoDosya = "ubisoft.png"; }
        else if (h.platform.includes("Nvidia")) { col = renkMap["Nvidia"]; logoDosya = "nvidia.png"; }
        else if (h.platform.includes("AMD")) { col = renkMap["AMD"]; logoDosya = "amd.png"; }
        else if (h.platform.includes("Intel")) { col = renkMap["Intel"]; logoDosya = "intel.png"; }
        else if (h.platform.includes("PS")) { col = renkMap["PS"]; logoDosya = "ps.png"; }
        else if (h.platform.includes("Xbox")) { col = renkMap["Xbox"]; logoDosya = "xbox.png"; logoStili = "transform: scale(1.6);"; }
        else if (h.platform.includes("Nintendo")) { col = renkMap["Nintendo"]; logoDosya = "nintendo.png"; }

        return `
        <div class="news-row" style="--row-glow: ${col}" onclick="window.location.href='${basePathPage}haber-detay.html?id=${h.id}'">
            <img src="${isSubPage ? '../' : ''}${h.resim}" class="row-img" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
            <div class="row-info">
                <h3>${h.baslik}</h3>
                <div class="row-logo-container">
                  <img src="${basePathImg}logolar/${logoDosya}" alt="${h.platform}" class="platform-logo" style="${logoStili}">
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
        let platRenk = "#b76bff";

        const p = h.platform.toLowerCase();
        if (p.includes("steam")) { logoDosya = "steam.png"; platRenk = "#66c0f4"; }
        else if (p.includes("epic")) { logoDosya = "epic.png"; platRenk = "#e0e0e0"; }
        else if (p.includes("nvidia")) { logoDosya = "nvidia.png"; platRenk = "#76b900"; }
        else if (p.includes("amd")) { logoDosya = "amd.png"; platRenk = "#ed1c24"; }
        else if (p.includes("intel")) { logoDosya = "intel.png"; platRenk = "#0071c5"; }
        else if (p.includes("ps")) { logoDosya = "ps.png"; platRenk = "#003791"; }
        else if (p.includes("xbox")) { logoDosya = "xbox.png"; logoBoyutu = "45px"; platRenk = "#107c10"; }
        else if (p.includes("nintendo")) { logoDosya = "nintendo.png"; platRenk = "#e60012"; }
        else if (p.includes("ea")) { logoDosya = "ea.png"; platRenk = "#ff4747"; }
        else if (p.includes("ubisoft")) { logoDosya = "ubisoft.png"; platRenk = "#0070ff"; }

        return `
        <div class="slider-item" data-index="${i}" style="--hover-color: ${platRenk}; cursor: pointer;" onclick="window.location.href='${basePathPage}haber-detay.html?id=${h.id}'">
            <div class="spin-glow-border"></div>
            <img src="${isSubPage ? '../' : ''}${h.resim}" class="slider-bg-img" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
            <div class="slider-content">
                <span class="slider-tag" style="background: transparent; padding: 0; box-shadow: none;">
                  <img src="${basePathImg}logolar/${logoDosya}" alt="${h.platform}" style="height: ${logoBoyutu}; object-fit: contain;">
                </span>
                <h2>${h.baslik}</h2>
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

/* --- MOBİL HAMBURGER --- */
const hamburger = document.querySelector('.hamburger-menu');
const hamburgerContent = document.querySelector('.hamburger-content');
if (hamburger && hamburgerContent) {
    hamburger.onclick = (e) => { e.stopPropagation(); hamburgerContent.classList.toggle('active'); };
    document.addEventListener('click', () => { hamburgerContent.classList.remove('active'); });
}

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
        const selectedGame = urlParams.get('game') || 'all';

        document.querySelectorAll('.game-filter-card').forEach(card => {
            if (card.getAttribute('data-game') === selectedGame) card.classList.add('active');
        });

        function maclariEkranaBas(oyunFiltresi) {
            const gosterilecekMaclar = oyunFiltresi === 'all' ? butunMaclar : butunMaclar.filter(m => m.oyun === oyunFiltresi);
            if (gosterilecekMaclar.length === 0) {
                scoreBoard.innerHTML = '<h3 style="text-align: center; color: #ff4747;">Şu an için aktif maç bulunmuyor.</h3>';
                return;
            }
            const oyunIsimSözlüğü = { "cs2": "COUNTER-STRİKE 2", "lol": "LEAGUE OF LEGENDS", "dota": "DOTA 2", "valorant": "VALORANT" };
            const matchesByGroup = gosterilecekMaclar.reduce((acc, match) => {
                const groupKey = `${match.oyun}_${match.lig}`; 
                if (!acc[groupKey]) acc[groupKey] = [];
                acc[groupKey].push(match);
                return acc;
            }, {});

            let htmlContent = oyunFiltresi === 'all' ? `<h3 style="text-align: center; color: #b76bff; margin-bottom: 30px;">TÜM GÜNCEL MAÇLAR</h3>` : ``;

            for (const [groupKey, matches] of Object.entries(matchesByGroup)) {
                const oyunKod = matches[0].oyun ? matches[0].oyun.toLowerCase() : 'default';
                const ligAdi = matches[0].lig; 
                const gosterilecekOyunAdi = oyunIsimSözlüğü[oyunKod] || oyunKod.toUpperCase();
                const logoYolu = `${basePathImg}canliskorlogolar/${oyunKod}logo.png`;

                // YENİ: Tıpkı e-spor panelindeki gibi logoları hizalayıp boyutlarını eşitliyoruz
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
                            ${matches.map(m => `
                                <div class="match-row">
                                    <div class="match-time-status">
                                        <span class="match-time">${m.durum === 'CANLI' ? '<span class="red-dot">•</span> CANLI' : m.saat}</span>
                                        <span class="match-status ${m.durum === 'CANLI' ? 'live' : ''}">${m.periyot}</span>
                                    </div>
                                    <div class="team-home">${m.ev_sahibi}</div>
                                    <div class="match-score ${m.durum === 'CANLI' ? 'live-score-bg' : ''}">${m.skor}</div>
                                    <div class="team-away">${m.deplasman}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }
            scoreBoard.innerHTML = htmlContent;
        }

        maclariEkranaBas(selectedGame);

        document.querySelectorAll('.game-filter-card').forEach(kart => {
            kart.addEventListener('click', function(e) {
                e.preventDefault(); 
                document.querySelectorAll('.game-filter-card').forEach(k => k.classList.remove('active'));
                this.classList.add('active');
                const secilenOyun = this.getAttribute('data-game');
                scoreBoard.innerHTML = `<div style="text-align: center; padding: 50px 0; color: #888;"><span class="red-dot" style="display:inline-block; margin-right:10px;">•</span><h3 style="display:inline-block;">Canlı veriler çekiliyor...</h3></div>`;
                setTimeout(() => { maclariEkranaBas(secilenOyun); }, 300);
            });
        });
    }

    // --- 2. SENARYO: EĞER E-SPOR SAYFASINDAYSAK ---
    // --- 2. SENARYO: EĞER E-SPOR SAYFASINDAYSAK ---
    if (esporBoard) {
        if (butunMaclar.length === 0) {
            esporBoard.innerHTML = '<div style="color:#888; text-align:center; padding:15px;">Şu an veritabanında maç bulunmuyor.</div>';
        } else {
            // E-Spor menüsüne sığması için sadece en güncel 4 maçı alıyoruz
            const miniMaclar = butunMaclar.slice(0, 4);
            
            esporBoard.innerHTML = miniMaclar.map(m => {
                const ortadakiDeger = m.durum === 'CANLI' ? m.skor : m.saat;
                const canliClass = m.durum === 'CANLI' ? 'live-score' : '';
                
                const oyunKod = m.oyun ? m.oyun.toLowerCase() : 'default';
                const logoYolu = `${basePathImg}canliskorlogolar/${oyunKod}logo.png`;
                
                // Ekstra kutu yok, sadece CSS transform ile resmin "görünüm" boyutunu büyütüyoruz
                let ekstraStil = "transform: scale(1);";
                if (oyunKod.includes('valorant')) ekstraStil = "transform: scale(1.4);";
                else if (oyunKod.includes('lol')) ekstraStil = "transform: scale(1.5);";
                else if (oyunKod.includes('dota')) ekstraStil = "transform: scale(1.6);";
                
                return `
                <div class="match-item">
                    <div class="match-game-name" style="display: flex; align-items: center; gap: 6px;">
                        <img src="${logoYolu}" style="width: 24px; height: 16px; object-fit: contain; object-position: center; display: block; ${ekstraStil}" onerror="this.style.display='none'"> 
                        <span style="opacity: 0.6;">-</span> ${m.lig}
                    </div>
                    
                    <div class="match-teams">
                        <span class="team">${m.ev_sahibi}</span>
                        <span class="score ${canliClass}">${ortadakiDeger}</span>
                        <span class="team">${m.deplasman}</span>
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
                
                // DEĞİŞEN KISIM BURASI: Başarılı giriş anında tarayıcı hafızasına yazıyoruz
                if (result.status === 'success') { 
                    localStorage.setItem('oturum', 'acik'); // <-- İşte eklediğimiz sihirli satır
                    showAuthMessage('success', 'Giriş Başarılı!'); 
                    setTimeout(() => { window.location.href = prefix + 'index.html'; }, 1000); 
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
});

/* === OTURUM KONTROLÜ === */
/* === OTURUM KONTROLÜ VE HEADER GÜNCELLEMESİ === */
async function kontrolEtOturum() {
    try {
        const prefix = isSubPage ? '../' : ''; 
        const response = await fetch(prefix + 'ajax_session.php');
        const data = await response.json();

        if (data.logged_in) {
            localStorage.setItem('oturum', 'acik'); // Tarayıcı hafızasına kaydet
            
            const authGroup = document.querySelector('.header-auth-group');
            if (authGroup) authGroup.style.display = 'none'; 

            if (document.getElementById('user-panel-active')) return;

            const userBadge = document.createElement('div');
            userBadge.id = "user-panel-active";
            userBadge.style.cssText = "display: inline-flex; align-items: center; gap: 10px; margin-right: 15px;";
            
            let adminBtn = data.rol === 'admin' ? `<a href="${prefix}admin.php" style="background:#b76bff; color:#fff; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:bold; text-decoration:none;">PANEL</a>` : '';

            userBadge.innerHTML = `
                <span style="color: #fff; font-weight: bold; font-size: 14px; white-space: nowrap;">👤 ${data.kullanici_adi.toUpperCase()}</span> 
                ${adminBtn} 
                <a href="${prefix}cikis.php" style="background:rgba(237, 28, 36, 0.2); color:#ff4747; padding:6px 12px; border-radius:6px; font-size:12px; font-weight:bold; border: 1px solid #ff4747; text-decoration:none;">ÇIKIŞ</a>
            `;

            const liveScoreBtn = document.querySelector('.live-score-btn');
            if(liveScoreBtn) liveScoreBtn.parentNode.insertBefore(userBadge, liveScoreBtn);
        } else {
            // Çıkış yapılmışsa hafızayı temizle ve butonları geri getir
            localStorage.removeItem('oturum');
            document.documentElement.classList.remove('oturum-bekleniyor');
            const authGroup = document.querySelector('.header-auth-group');
            if (authGroup) authGroup.style.display = 'flex'; 
        }
    } catch(e) { 
        console.error('Oturum bilgisi çekilemedi:', e); 
    }
}

document.addEventListener('DOMContentLoaded', kontrolEtOturum);

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
            const dBaslik = document.getElementById('detay-baslik'); if(dBaslik) dBaslik.innerText = haber.baslik;
            const dIcerik = document.getElementById('detay-icerik'); if(dIcerik) dIcerik.innerHTML = haber.icerik.replace(/\n/g, '<br>');
            const resimElement = document.getElementById('detay-resim'); if(resimElement) { resimElement.src = prefix + haber.resim; resimElement.style.display = 'block'; }
            yorumlariGetir(haberId);
            const yorumForm = document.getElementById('yorumFormu');
            if(yorumForm) yorumForm.onsubmit = (event) => yorumGonder(event, haberId);
        } else {
            const dBaslik = document.getElementById('detay-baslik'); if(dBaslik) dBaslik.innerText = "Hata!";
            const dIcerik = document.getElementById('detay-icerik'); if(dIcerik) dIcerik.innerText = result.message;
        }
    } catch (error) { console.error("Haber çekilirken hata oluştu:", error); }
}
document.addEventListener('DOMContentLoaded', () => { if (window.location.pathname.includes('haber-detay.html')) haberDetayiniGetir(); });
