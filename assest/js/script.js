document.addEventListener('DOMContentLoaded', function() {
    // --- MENÜ ELEMANLARI ---
    const menuBtn = document.getElementById('menu-btn');
    const yanMenu = document.getElementById('yan-menu');
    const menuKapat = document.getElementById('menu-kapat');

    // Menüyü Aç
    if(menuBtn) {
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            yanMenu.classList.add('acik');
        });
    }

    // Menüyü Kapat
    if(menuKapat) {
        menuKapat.addEventListener('click', () => {
            yanMenu.classList.remove('acik');
        });
    }

    // Dışarı tıklandığında menüyü kapat
    document.addEventListener('click', (e) => {
        if (yanMenu && yanMenu.classList.contains('acik')) {
            if (!yanMenu.contains(e.target) && e.target !== menuBtn) {
                yanMenu.classList.remove('acik');
            }
        }
    });

    // --- FİLTRELEME VE SAYFALAMA MANTIĞI ---
    const sayfaBasinaHaber = 21;
    let mevcutSayfa = 1;
    let aktifKategori = 'hepsi';
    let aktifTur = null;

    const filtreButonlari = document.querySelectorAll('.filtre-butonu');
    const haberKartlari = Array.from(document.querySelectorAll('.haber-karti'));
    const sayfalamaAlani = document.getElementById('sayfalama-alani');

    function ekranGuncelle() {
        let firsatGosterildi = false;

        const filtrelenenler = haberKartlari.filter(kart => {
            const kartKategori = kart.getAttribute('data-kategori');
            const kartPlatform = kart.getAttribute('data-platform');
            const etiketElement = kart.querySelector('.etiket');
            const kartTuru = etiketElement ? etiketElement.textContent : "";

            const kategoriUyar = (!aktifKategori || aktifKategori === 'hepsi' || aktifKategori === kartKategori || aktifKategori === kartPlatform);
            const turUyar = (!aktifTur || aktifTur === kartTuru);

            let uygun = kategoriUyar && turUyar;

            if (uygun && aktifKategori === 'hepsi' && kartKategori === 'firsat') {
                if (firsatGosterildi) return false;
                firsatGosterildi = true;
            }
            return uygun;
        });

        const toplamSayfa = Math.ceil(filtrelenenler.length / sayfaBasinaHaber);
        const baslangic = (mevcutSayfa - 1) * sayfaBasinaHaber;
        const bitis = baslangic + sayfaBasinaHaber;

        haberKartlari.forEach(k => {
            k.style.display = 'none';
            k.classList.remove('manset-karti', 'standart-karti');
        });

        filtrelenenler.slice(baslangic, bitis).forEach((kart, index) => {
            kart.style.display = '';
            if (index === 0) {
                kart.classList.add('manset-karti');
            } else {
                kart.classList.add('standart-karti');
            }
        });

        sayfalamaButonlariniOlustur(toplamSayfa);
    }

    function sayfalamaButonlariniOlustur(toplamSayfa) {
        if(!sayfalamaAlani) return;
        sayfalamaAlani.innerHTML = '';
        if (toplamSayfa <= 1) return;

        for (let i = 1; i <= toplamSayfa; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            btn.classList.add('sayfa-btn');
            if (i === mevcutSayfa) btn.classList.add('aktif');
            btn.addEventListener('click', () => {
                mevcutSayfa = i;
                ekranGuncelle();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            sayfalamaAlani.appendChild(btn);
        }
    }

    filtreButonlari.forEach(buton => {
        buton.addEventListener('click', function(e) {
            e.preventDefault();
            aktifKategori = this.getAttribute('data-kategori');
            aktifTur = this.getAttribute('data-tur');
            mevcutSayfa = 1;
            ekranGuncelle();
            if (yanMenu) yanMenu.classList.remove('acik');
        });
    });

    ekranGuncelle();
});
/* test */