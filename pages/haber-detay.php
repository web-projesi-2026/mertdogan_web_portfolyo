<?php 
    $yol = "../";
    $sayfa = "haber-detay";

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GAMEPORTAL - Haber Detayı</title>
    <link rel="stylesheet" href="../assets/style.css">
    <script>if(localStorage.getItem('oturum')==='acik') document.documentElement.classList.add('oturum-bekleniyor');</script>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    
<?php include '../header.php'; ?>
    <main>
        <article style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
            <img id="detay-resim" src="" alt="" style="width: 100%; border-radius: 16px; margin-bottom: 30px; display: none; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <h1 id="detay-baslik" style="font-family: 'Oswald', sans-serif; font-size: 36px; color: #fff; margin-bottom: 20px;">Haber Yükleniyor...</h1>
            <div id="detay-icerik" style="line-height: 1.8; color: #ccc; font-size: 17px; margin-bottom: 50px;">
                Lütfen bekleyin, içerik getiriliyor...
            </div>
        </article>

        <div class="yorum-seksiyonu" style="max-width: 800px; margin: 40px auto; padding: 25px; background: #151515; border-radius: 16px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <h3 style="color: #fff; margin-bottom: 25px; border-bottom: 1px solid #333; padding-bottom: 15px; font-family: 'Oswald', sans-serif; letter-spacing: 1px;">💬 Yorumlar</h3>
            
            <form id="yorumFormu" style="margin-bottom: 40px;"> 
                <textarea id="yorum-kutusu" placeholder="Düşüncelerini paylaş..." required 
                    style="width: 100%; height: 100px; padding: 15px; border-radius: 10px; background: #0a0a0a; color: #fff; border: 1px solid #444; resize: vertical; box-sizing: border-box; font-family: inherit; transition: 0.3s; margin-bottom: 15px;"></textarea>
                
                <button type="submit" 
                    style="background: #b76bff; color: white; border: none; padding: 12px 25px; border-radius: 8px; font-weight: bold; cursor: pointer; transition: 0.3s; box-shadow: 0 4px 15px rgba(183, 107, 255, 0.2);">
                    Yorumu Gönder
                </button>
            </form>

            <div id="yorum-listesi" style="display: flex; flex-direction: column; gap: 15px;"></div>
        </div>
    </main>

    
<?php include $yol . 'modal.php'; ?>
</body>
</html>