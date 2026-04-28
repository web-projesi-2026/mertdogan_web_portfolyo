<?php 
    $yol = "../"; 
    $sayfa = "favoriler"; 
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - Favorilerim</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>
        // Sayfa yüklenmeden önce ziyaretçi kontrolü: Giriş yapmayan giremesin!
        if(localStorage.getItem('oturum') !== 'acik') {
            window.location.href = '../index.php'; 
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
<?php include '../header.php'; ?>

<main style="min-height: 80vh; padding: 40px 20px; max-width: 1300px; margin: 0 auto; width: 100%; box-sizing: border-box;">
    
    <div class="title-card-wrapper" style="margin-bottom: 40px;">
        <h2 class="title-card-text">- FAVORİ HABERLERİM -</h2>
    </div>

    <section id="haberler" class="news-container" style="display: flex; flex-wrap: wrap; gap: 25px; justify-content: center;"></section>

</main>

<?php include $yol . 'modal.php'; ?>
<script src="../assets/script.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", async () => {
        const favoriKutusu = document.getElementById('favori-liste');
        let favoriler = JSON.parse(localStorage.getItem('favoriHaberler')) || [];

        if (favoriler.length === 0) {
            favoriKutusu.innerHTML = '<div style="text-align: center; width: 100%; padding: 50px 0; color: #888;"><h3 style="color: #fff;">Henüz favorilere eklediğiniz bir haber bulunmuyor.</h3><p style="margin-top:10px;">Kalp butonlarına tıklayarak haberleri buraya ekleyebilirsiniz.</p></div>';
            return;
        }

        try {
            // Veritabanından (API) tüm haberleri çekiyoruz
            const response = await fetch('../api.php');
            const butunHaberler = await response.json();

            // Sadece ID'si LocalStorage (favoriler) içinde olanları filtreliyoruz
            const gosterilecekler = butunHaberler.filter(h => favoriler.includes(h.id.toString()));

            const renkMap = {
                "Steam": "#66c0f4", "Epic Games": "#e0e0e0", "Nvidia": "#76b900",
                "AMD": "#ed1c24", "Intel": "#0071c5", "PS": "#003791",
                "Xbox": "#107c10", "EA Games": "#ff4747", "Ubisoft": "#0070ff",
                "Nintendo": "#e60012", "PC": "#b76bff"
            };

            favoriKutusu.innerHTML = gosterilecekler.map(h => {
                let col = "#b76bff"; let logoDosya = "default.png"; let logoStili = "";
                
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
                <div class="news-row" style="--row-glow: ${col}" onclick="window.location.href='haber-detay.php?id=${h.id}'">
                    
                    <label class="ui-like" onclick="event.stopPropagation();">
                        <input type="checkbox" checked="checked" onchange="toggleFavori(event, ${h.id})">
                        <div class="checkmark">
                            <svg viewBox="0 0 256 256">
                            <rect fill="none" height="256" width="256"></rect>
                            <path d="M224.6,51.9a59.5,59.5,0,0,0-43-19.9,60.5,60.5,0,0,0-44,17.6L128,59.1l-7.5-7.4C97.2,28.3,59.2,26.3,35.9,47.4a59.9,59.9,0,0,0-2.3,87l83.1,83.1a15.9,15.9,0,0,0,22.6,0l81-81C243.7,113.2,245.6,75.2,224.6,51.9Z"></path>
                            </svg>
                        </div>
                    </label>

                    <img src="${h.resim.startsWith('http') ? h.resim : '../' + h.resim}" class="row-img" style="border-radius: 15px 15px 0 0;" onerror="this.src='https://images.unsplash.com/photo-1542751371-adc38448a05e?auto=format&fit=crop&w=800&q=80'">
                    <div class="row-info">
                        <h3>${h.baslik}</h3>
                        <p class="row-ozet">${h.ozet}</p>
                        <div class="row-logo-container">
                          <img src="../img/logolar/${logoDosya}" alt="${h.platform}" class="platform-logo" style="${logoStili}">
                        </div>
                    </div>
                </div>`;
            }).join('');

        } catch (error) {
            console.error("Favoriler yüklenemedi:", error);
        }
    });
</script>
</body>
</html>