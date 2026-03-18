document.addEventListener('DOMContentLoaded', function() {
    const menuBtn = document.getElementById('menu-btn');
    const yanMenu = document.getElementById('yan-menu');
    const menuKapat = document.getElementById('menu-kapat');
    if(menuBtn) menuBtn.addEventListener('click', () => yanMenu.classList.add('acik'));
    if(menuKapat) menuKapat.addEventListener('click', () => yanMenu.classList.remove('acik'));

    const sayfaBasinaHaber = 21;
    let mevcutSayfa = 1;
    let aktifKategori = 'hepsi';
    let aktifTur = null;

    const filtreButonlari = document.querySelectorAll('.filtre-butonu');
    const haberKartlari = Array.from(document.querySelectorAll('.haber-karti'));
    const sayfalamaAlani = document.getElementById('sayfalama-alani');

    function ekranGuncelle() {
        let firsatGosterildi = false; // Ana sayfada sadece 1 fırsat göstermek için

        // 1. Filtreleme
        const filtrelenenler = haberKartlari.filter(kart => {
            const kartKategori = kart.getAttribute('data-kategori');
            const kartPlatform = kart.getAttribute('data-platform');
            const kartTuru = kart.querySelector('.etiket').textContent;

            // Kategori veya Platform eşleşmesi (PC tıklandıysa hem PC hem platformu PC olan fırsatlar)
            const kategoriUyar = (!aktifKategori || aktifKategori === 'hepsi' || aktifKategori === kartKategori || aktifKategori === kartPlatform);
            const turUyar = (!aktifTur || aktifTur === kartTuru);

            let uygun = kategoriUyar && turUyar;

            // ÖZEL KURAL: Ana sayfadayken (hepsi) fırsat haberlerinden sadece ilkini göster
            if (uygun && aktifKategori === 'hepsi' && kartKategori === 'firsat') {
                if (firsatGosterildi) return false;
                firsatGosterildi = true;
            }

            return uygun;
        });

        // 2. Sayfalama Hesaplama
        const toplamSayfa = Math.ceil(filtrelenenler.length / sayfaBasinaHaber);
        const baslangic = (mevcutSayfa - 1) * sayfaBasinaHaber;
        const bitis = baslangic + sayfaBasinaHaber;

        // 3. Görünüm ve Manşet Ayarı
        haberKartlari.forEach(k => {
            k.style.display = 'none';
            k.classList.remove('manset-karti', 'standart-karti');
        });

        filtrelenenler.slice(baslangic, bitis).forEach((kart, index) => {
            kart.style.display = '';
            // Her sayfanın ilk haberi Manşet (büyük), diğerleri standart olsun
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