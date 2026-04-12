<?php
session_start();
// Oturum açılmamışsa veya giriş yapan kişi ADMIN değilse erişimi engelle
if (!isset($_SESSION['oturum_acildi']) || $_SESSION['oturum_acildi'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: index.html");
    exit;
}

require_once 'baglan.php'; 
$mesaj = "";

// Hangi sekmedeyiz? (Varsayılan: haber)
$aktif_sekme = isset($_GET['sekme']) ? $_GET['sekme'] : "haber";

// Hataları önlemek için değişkenleri sıfırlıyoruz
$edit_haber = null; $edit_skor = null; $edit_user = null; $edit_yorum = null;

// === LOG KAYIT FONKSİYONU ===
function islemKaydet($db, $admin_id, $tip, $detay) {
    $sql = "INSERT INTO islem_loglari (admin_id, islem_tipi, islem_detay) VALUES (?, ?, ?)";
    $db->prepare($sql)->execute([$admin_id, $tip, $detay]);
}

// ==========================================
// 1. SİLME İŞLEMLERİ (GET)
// ==========================================
if (isset($_GET['sil_haber'])) {
    $db->prepare("DELETE FROM haberler WHERE id = ?")->execute([$_GET['sil_haber']]);
    islemKaydet($db, $_SESSION['kullanici_id'], 'Haber Silme', "Haber ID: {$_GET['sil_haber']} sistemden silindi.");
    $mesaj = "<div class='basarili'>🗑️ Haber silindi.</div>";
    $aktif_sekme = "haber";
}
if (isset($_GET['sil_skor'])) {
    $db->prepare("DELETE FROM canli_skor WHERE id = ?")->execute([$_GET['sil_skor']]);
    islemKaydet($db, $_SESSION['kullanici_id'], 'Skor Silme', "Skor ID: {$_GET['sil_skor']} fikstürden silindi.");
    $mesaj = "<div class='basarili'>🗑️ Maç silindi.</div>";
    $aktif_sekme = "skor";
}
if (isset($_GET['sil_user'])) {
    if($_GET['sil_user'] != $_SESSION['kullanici_id']) {
        $db->prepare("DELETE FROM kullanicilar WHERE id = ?")->execute([$_GET['sil_user']]);
        islemKaydet($db, $_SESSION['kullanici_id'], 'Kullanıcı Silme', "Kullanıcı ID: {$_GET['sil_user']} sistemden silindi.");
        $mesaj = "<div class='basarili'>👤 Kullanıcı silindi.</div>";
    }
    $aktif_sekme = "user";
}
if (isset($_GET['sil_yorum'])) {
    $db->prepare("DELETE FROM yorumlar WHERE id = ?")->execute([$_GET['sil_yorum']]);
    islemKaydet($db, $_SESSION['kullanici_id'], 'Yorum Silme', "Yorum ID: {$_GET['sil_yorum']} haberden silindi.");
    $mesaj = "<div class='basarili'>💬 Yorum silindi.</div>";
    $aktif_sekme = "yorum";
}

// ==========================================
// 2. DÜZENLEME MODU (VERİ ÇEKME)
// ==========================================
if (isset($_GET['edit_haber'])) { 
    $sorgu = $db->prepare("SELECT * FROM haberler WHERE id=?"); $sorgu->execute([$_GET['edit_haber']]);
    $edit_haber = $sorgu->fetch(); $aktif_sekme = "haber"; 
}
if (isset($_GET['edit_skor'])) { 
    $sorgu = $db->prepare("SELECT * FROM canli_skor WHERE id=?"); $sorgu->execute([$_GET['edit_skor']]);
    $edit_skor = $sorgu->fetch(); $aktif_sekme = "skor"; 
}
if (isset($_GET['edit_user'])) { 
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE id=?"); $sorgu->execute([$_GET['edit_user']]);
    $edit_user = $sorgu->fetch(); $aktif_sekme = "user"; 
}
if (isset($_GET['edit_yorum'])) { 
    $sorgu = $db->prepare("SELECT * FROM yorumlar WHERE id=?"); $sorgu->execute([$_GET['edit_yorum']]);
    $edit_yorum = $sorgu->fetch(); $aktif_sekme = "yorum"; 
}

// ==========================================
// 3. FORM GÖNDERİMLERİ (POST)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tip = $_POST['form_tipi'];

    // --- HABER İŞLEMLERİ ---
    if ($tip == "haber" || $tip == "haber_guncelle") {
        $resim = $_POST['eski_resim'] ?? "img/logolar/logo.png";
        if (isset($_FILES['resim_dosya']) && $_FILES['resim_dosya']['error'] == 0) {
            $path = "img/haberresim/" . time() . "_" . $_FILES['resim_dosya']['name'];
            if (move_uploaded_file($_FILES['resim_dosya']['tmp_name'], $path)) $resim = $path;
        }
        if ($tip == "haber") {
            $db->prepare("INSERT INTO haberler (baslik, ozet, icerik, platform, resim) VALUES (?,?,?,?,?)")->execute([$_POST['baslik'], $_POST['ozet'], $_POST['icerik'], $_POST['platform'], $resim]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Haber Ekleme', "Yeni Haber: {$_POST['baslik']}");
        } else {
            $db->prepare("UPDATE haberler SET baslik=?, ozet=?, icerik=?, platform=?, resim=? WHERE id=?")->execute([$_POST['baslik'], $_POST['ozet'], $_POST['icerik'], $_POST['platform'], $resim, $_POST['haber_id']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Haber Düzenleme', "Haber ID: {$_POST['haber_id']} güncellendi.");
        }
        $aktif_sekme = "haber";
    }

    // --- SKOR İŞLEMLERİ ---
    else if ($tip == "skor" || $tip == "skor_guncelle") {
        $skor = !empty($_POST['skor']) ? $_POST['skor'] : 'v';
        if ($tip == "skor") {
            $db->prepare("INSERT INTO canli_skor (oyun, lig, saat, durum, ev_sahibi, skor, deplasman, periyot) VALUES (?,?,?,?,?,?,?,?)")->execute([$_POST['oyun'], $_POST['lig'], $_POST['saat'], $_POST['durum'], $_POST['ev_sahibi'], $skor, $_POST['deplasman'], $_POST['periyot']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Skor Ekleme', "Yeni Maç: {$_POST['ev_sahibi']} vs {$_POST['deplasman']}");
        } else {
            $db->prepare("UPDATE canli_skor SET oyun=?, lig=?, saat=?, durum=?, ev_sahibi=?, skor=?, deplasman=?, periyot=? WHERE id=?")->execute([$_POST['oyun'], $_POST['lig'], $_POST['saat'], $_POST['durum'], $_POST['ev_sahibi'], $skor, $_POST['deplasman'], $_POST['periyot'], $_POST['skor_id']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Skor Düzenleme', "Maç ID: {$_POST['skor_id']} güncellendi.");
        }
        $aktif_sekme = "skor";
    }

    // --- KULLANICI İŞLEMLERİ ---
    else if ($tip == "user" || $tip == "user_guncelle") {
        $user_kadi = $_POST['kullanici_adi'];
        $user_rol = $_POST['rol'];
        
        if ($tip == "user") {
            $hashed = password_hash($_POST['sifre'], PASSWORD_DEFAULT);
            $db->prepare("INSERT INTO kullanicilar (kullanici_adi, sifre, rol) VALUES (?,?,?)")->execute([$user_kadi, $hashed, $user_rol]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Kullanıcı Ekleme', "Yeni $user_rol: $user_kadi");
        } else {
            if (!empty($_POST['sifre'])) {
                $hashed = password_hash($_POST['sifre'], PASSWORD_DEFAULT);
                $db->prepare("UPDATE kullanicilar SET kullanici_adi=?, sifre=?, rol=? WHERE id=?")->execute([$user_kadi, $hashed, $user_rol, $_POST['user_id']]);
            } else {
                $db->prepare("UPDATE kullanicilar SET kullanici_adi=?, rol=? WHERE id=?")->execute([$user_kadi, $user_rol, $_POST['user_id']]);
            }
            islemKaydet($db, $_SESSION['kullanici_id'], 'Kullanıcı Düzenleme', "Kullanıcı Güncellendi: $user_kadi");
        }
        $aktif_sekme = "user";
    }

    // --- YORUM İŞLEMLERİ ---
    else if ($tip == "yorum_guncelle") {
        $db->prepare("UPDATE yorumlar SET yazan_kisi=?, yorum=? WHERE id=?")->execute([$_POST['yazan_kisi'], $_POST['yorum'], $_POST['yorum_id']]);
        islemKaydet($db, $_SESSION['kullanici_id'], 'Yorum Düzenleme', "Yorum ID: {$_POST['yorum_id']} içeriği güncellendi.");
        $aktif_sekme = "yorum";
    }
    $mesaj = "<div class='basarili'>✅ İşlem başarıyla gerçekleştirildi.</div>";
}

// === VERİLERİ ÇEK ===
$haberler = $db->query("SELECT * FROM haberler ORDER BY id DESC")->fetchAll(); 
$skorlar = $db->query("SELECT * FROM canli_skor ORDER BY id DESC")->fetchAll();
$users = $db->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll();
$yorumlar = $db->query("SELECT y.*, h.baslik as haber_baslik FROM yorumlar y JOIN haberler h ON y.haber_id = h.id ORDER BY y.id DESC")->fetchAll();
$mevcut_ligler = $db->query("SELECT DISTINCT lig FROM canli_skor ORDER BY lig ASC")->fetchAll();

// === LOG FİLTRELEME VE ÇEKME İŞLEMLERİ ===
$log_admin_filter = $_GET['admin_filter'] ?? '';
$log_tip_filter = $_GET['tip_filter'] ?? '';

$log_sorgu_str = "SELECT l.*, k.kullanici_adi FROM islem_loglari l LEFT JOIN kullanicilar k ON l.admin_id = k.id WHERE 1=1";
$log_params = [];

if ($log_admin_filter) { $log_sorgu_str .= " AND l.admin_id = ?"; $log_params[] = $log_admin_filter; }
if ($log_tip_filter) { $log_sorgu_str .= " AND l.islem_tipi = ?"; $log_params[] = $log_tip_filter; }
$log_sorgu_str .= " ORDER BY l.id DESC";
$log_sorgu = $db->prepare($log_sorgu_str);
$log_sorgu->execute($log_params);
$loglar = $log_sorgu->fetchAll();

$log_adminler = $db->query("SELECT id, kullanici_adi FROM kullanicilar WHERE rol = 'admin'")->fetchAll();
$log_tipler = $db->query("SELECT DISTINCT islem_tipi FROM islem_loglari")->fetchAll();
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Süper Admin Paneli</title>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { background: #121212; color: #fff; font-family: 'Segoe UI', sans-serif; padding: 40px 20px; }
        .admin-container { background: #1a1a1a; padding: 30px; border-radius: 16px; width: 100%; max-width: 1100px; margin: auto; border: 1px solid #333; box-shadow: 0 15px 35px rgba(0,0,0,0.5); }
        
        /* === YENİ ÜST BAR TASARIMI === */
        .top-navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #333; padding-bottom: 15px; }
        .top-btn { text-decoration: none; font-weight: bold; font-size: 13px; padding: 10px 22px; border-radius: 8px; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-home { background: rgba(183, 107, 255, 0.1); color: #b76bff; border: 1px solid #b76bff; }
        .btn-home:hover { background: #b76bff; color: #fff; box-shadow: 0 0 15px rgba(183,107,255,0.4); }
        .btn-logout { background: rgba(255, 71, 71, 0.1); color: #ff4747; border: 1px solid #ff4747; }
        .btn-logout:hover { background: #ff4747; color: #fff; box-shadow: 0 0 15px rgba(255,71,71,0.4); }

        h2 { font-family: 'Oswald'; text-align: center; color: #b76bff; font-size: 30px; letter-spacing: 2px; margin-bottom: 30px; }
        .main-tabs { display: flex; background: #0a0a0a; padding: 8px; border-radius: 12px; border: 1px solid #222; margin-bottom: 30px; gap: 8px; }
        .m-tab { flex: 1; padding: 15px 10px; background: transparent; color: #888; border: none; border-radius: 8px; font-weight: bold; font-size: 14px; cursor: pointer; transition: 0.3s; white-space: nowrap;}
        .m-tab:hover { background: rgba(255,255,255,0.05); color: #fff; }
        .m-tab.active { background: #b76bff; color: #fff; box-shadow: 0 5px 15px rgba(183,107,255,0.3); }
        .form-section { display: none; animation: fadeIn 0.4s ease; } 
        .form-section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .admin-card { background: #151515; border: 1px solid #2a2a2a; border-radius: 12px; padding: 25px; margin-bottom: 25px; }
        .admin-card h3 { margin-top: 0; color: #fff; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px; font-size: 18px; }
        input, select, textarea { width: 100%; padding: 12px; margin-bottom: 15px; background: #0a0a0a; border: 1px solid #333; color: #fff; border-radius: 8px; box-sizing: border-box; }
        input:focus, select:focus, textarea:focus { border-color: #b76bff; outline: none; }
        .btn-submit { width: 100%; padding: 15px; border: none; border-radius: 8px; background: #b76bff; color: #fff; font-weight: bold; cursor: pointer; transition: 0.3s;}
        .btn-submit:hover { background: #9b51e0; }
        .admin-table { width: 100%; border-collapse: collapse; font-size: 14px; }
        .admin-table th, .admin-table td { padding: 15px 12px; text-align: left; border-bottom: 1px solid #222; }
        .admin-table th { color: #888; font-size: 12px; text-transform: uppercase; }
        .basarili { background: rgba(118,185,0,0.1); color: #76b900; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center; border: 1px solid #76b900; font-weight: bold;}
        .act-btn { padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 12px; margin-right: 5px; border: 1px solid; font-weight: bold; transition: 0.3s;}
        .edit { color: #b76bff; border-color: #b76bff; background: rgba(183,107,255,0.1); } .edit:hover { background: #b76bff; color: #fff; }
        .del { color: #ff4747; border-color: #ff4747; background: rgba(255,71,71,0.1); } .del:hover { background: #ff4747; color: #fff; }
        .arama-kutusu { width: 280px !important; margin-bottom: 0 !important; padding: 8px 12px !important; border-radius: 6px !important; border: 1px solid #444 !important; }
        .card-header-flex { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #333; margin-bottom: 20px; padding-bottom: 10px; }
        .form-row { display: flex; gap: 15px; } .form-row > * { flex: 1; }
    </style>
</head>
<body>

<div class="admin-container">
    <div class="top-navbar">
        <a href="index.html" class="top-btn btn-home">ANA SAYFA</a>
        <a href="cikis.php" class="top-btn btn-logout">ÇIKIŞ YAP</a>
    </div>

    <h2>[GAMEPORTAL] SÜPER KONTROL MERKEZİ</h2>
    <?= $mesaj ?>

    <div class="main-tabs">
        <button class="m-tab <?= $aktif_sekme=='haber'?'active':'' ?>" onclick="git('haber')">📰 Haber İşlemleri</button>
        <button class="m-tab <?= $aktif_sekme=='skor'?'active':'' ?>" onclick="git('skor')">🏆 Skor İşlemleri</button>
        <button class="m-tab <?= $aktif_sekme=='user'?'active':'' ?>" onclick="git('user')">👥 Kullanıcı İşlemleri</button>
        <button class="m-tab <?= $aktif_sekme=='yorum'?'active':'' ?>" onclick="git('yorum')">💬 Yorum İşlemleri</button>
        <button class="m-tab <?= $aktif_sekme=='log'?'active':'' ?>" onclick="git('log')">🕒 Son İşlemler</button>
    </div>

    <div id="haber-sekme" class="form-section <?= $aktif_sekme=='haber'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_haber ? 'Haberi Düzenle' : 'Yeni Haber Ekle' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="form_tipi" value="<?= $edit_haber?'haber_guncelle':'haber' ?>">
                <input type="hidden" name="haber_id" value="<?= $edit_haber['id']??'' ?>">
                <input type="hidden" name="eski_resim" value="<?= $edit_haber['resim']??'' ?>">
                <input type="text" name="baslik" placeholder="Haber Başlığı" value="<?= $edit_haber['baslik']??'' ?>" required>
                <div class="form-row">
                    <select name="platform">
                        <?php $plats = ['Steam','Epic Games','Xbox','PS','Nintendo','EA Games','Ubisoft','Nvidia','AMD','Intel']; 
                        foreach($plats as $p) echo "<option value='$p' ".($edit_haber && $edit_haber['platform']==$p?'selected':'').">$p</option>"; ?>
                    </select>
                    <input type="file" name="resim_dosya">
                </div>
                <input type="text" name="ozet" placeholder="Kısa Özet" value="<?= $edit_haber['ozet']??'' ?>" required>
                <textarea name="icerik" placeholder="Haber Detayı" style="height:120px;" required><?= $edit_haber['icerik']??'' ?></textarea>
                <button class="btn-submit"><?= $edit_haber?'HABERİ GÜNCELLE':'HABERİ YAYINLA' ?></button>
                <?php if($edit_haber): ?><a href="?sekme=haber" style="display:block; text-align:center; margin-top:10px; color:#ff4747; text-decoration:none;">İptal Et</a><?php endif; ?>
            </form>
        </div>

        <div class="admin-card">
            <div class="card-header-flex">
                <h3>Kayıtlı Haberler</h3>
                <input type="text" id="aramaHaber" class="arama-kutusu" placeholder="🔍 Başlık, ID veya Platform Ara..." onkeyup="tabloFiltrele('aramaHaber', 'tabloHaber')">
            </div>
            <table class="admin-table" id="tabloHaber">
                <tr><th>ID</th><th>Başlık</th><th>Platform</th><th style="text-align:right;">İşlem</th></tr>
                <?php foreach($haberler as $h): ?>
                <tr><td>#<?= $h['id'] ?></td><td><strong><?= mb_substr($h['baslik'],0,40) ?>...</strong></td><td><?= $h['platform'] ?></td>
                    <td style="text-align:right;">
                        <a href="?edit_haber=<?= $h['id'] ?>" class="act-btn edit">Düzenle</a>
                        <a href="?sil_haber=<?= $h['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a>
                    </td>
                </tr><?php endforeach; ?>
            </table>
        </div>
    </div>

    <div id="skor-sekme" class="form-section <?= $aktif_sekme=='skor'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_skor ? 'Maçı Düzenle' : 'Yeni Maç Ekle' ?></h3>
            <form method="POST">
                <input type="hidden" name="form_tipi" value="<?= $edit_skor?'skor_guncelle':'skor' ?>">
                <input type="hidden" name="skor_id" value="<?= $edit_skor['id']??'' ?>">
                <div class="form-row">
                    <select name="oyun" required>
                        <option value="cs2" <?= ($edit_skor && $edit_skor['oyun']=='cs2')?'selected':'' ?>>CS2</option>
                        <option value="valorant" <?= ($edit_skor && $edit_skor['oyun']=='valorant')?'selected':'' ?>>Valorant</option>
                        <option value="lol" <?= ($edit_skor && $edit_skor['oyun']=='lol')?'selected':'' ?>>League of Legends</option>
                        <option value="dota" <?= ($edit_skor && $edit_skor['oyun']=='dota')?'selected':'' ?>>Dota 2</option>
                    </select>
                    <select name="durum" id="durumSecici" required>
                        <option value="BAŞLAMADI" <?= ($edit_skor && $edit_skor['durum']=='BAŞLAMADI')?'selected':'' ?>>Başlamadı</option>
                        <option value="CANLI" <?= ($edit_skor && $edit_skor['durum']=='CANLI')?'selected':'' ?>>Canlı</option>
                        <option value="MS" <?= ($edit_skor && $edit_skor['durum']=='MS')?'selected':'' ?>>Maç Sonu (MS)</option>
                    </select>
                </div>
                <input type="text" name="lig" id="ligInput" placeholder="Turnuva / Lig" list="ligListesi" value="<?= $edit_skor['lig']??'' ?>" required>
                <datalist id="ligListesi">
                    <?php foreach($mevcut_ligler as $l): ?><option value="<?= htmlspecialchars($l['lig']) ?>"><?php endforeach; ?>
                </datalist>
                <div class="form-row">
                    <input type="text" name="ev_sahibi" placeholder="Ev Sahibi" value="<?= $edit_skor['ev_sahibi']??'' ?>" required>
                    <input type="text" name="deplasman" placeholder="Deplasman" value="<?= $edit_skor['deplasman']??'' ?>" required>
                </div>
                <div class="form-row">
                    <input type="text" name="skor" id="skorKutusu" placeholder="Skor (Örn: 2 - 1)" value="<?= $edit_skor['skor']??'' ?>">
                    <input type="time" name="saat" value="<?= $edit_skor['saat']??'' ?>" required>
                </div>
                <input type="text" name="periyot" placeholder="Periyot / Detay (Örn: 2. Yarı)" value="<?= $edit_skor['periyot']??'' ?>">
                <button class="btn-submit"><?= $edit_skor?'MAÇI GÜNCELLE':'MAÇI SİSTEME EKLE' ?></button>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Sistemdeki Maçlar</h3><input type="text" id="aramaSkor" class="arama-kutusu" placeholder="🔍 Oyun, Takım veya Durum Ara..." onkeyup="tabloFiltrele('aramaSkor', 'tabloSkor')"></div>
            <table class="admin-table" id="tabloSkor">
                <tr><th>Oyun</th><th>Karşılaşma</th><th>Durum</th><th style="text-align:right;">İşlem</th></tr>
                <?php foreach($skorlar as $s): ?>
                <tr><td style="text-transform:uppercase;"><strong><?= $s['oyun'] ?></strong></td><td><?= $s['ev_sahibi'] ?> vs <?= $s['deplasman'] ?></td>
                    <td><?php if($s['durum'] == 'CANLI') echo '<span style="color:#ff4747; font-weight:bold;">CANLI</span>'; else echo $s['saat']; ?></td>
                    <td style="text-align:right;">
                        <a href="?edit_skor=<?= $s['id'] ?>" class="act-btn edit">Düzenle</a>
                        <a href="?sil_skor=<?= $s['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a>
                    </td>
                </tr><?php endforeach; ?>
            </table>
        </div>
    </div>

    <div id="user-sekme" class="form-section <?= $aktif_sekme=='user'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_user ? 'Kullanıcıyı Düzenle' : 'Sisteme Kullanıcı Ekle' ?></h3>
            <form method="POST">
                <input type="hidden" name="form_tipi" value="<?= $edit_user?'user_guncelle':'user' ?>">
                <input type="hidden" name="user_id" value="<?= $edit_user['id']??'' ?>">
                <div class="form-row"><input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" value="<?= $edit_user['kullanici_adi']??'' ?>" required>
                    <select name="rol"><option value="kullanici" <?= ($edit_user && $edit_user['rol']=='kullanici')?'selected':'' ?>>Kullanıcı (Üye)</option>
                        <option value="admin" <?= ($edit_user && $edit_user['rol']=='admin')?'selected':'' ?>>Admin (Yönetici)</option></select>
                </div>
                <input type="text" name="sifre" placeholder="<?= $edit_user?'Yeni Şifre (Değişmeyecekse boş bırak)':'Kullanıcı Şifresi' ?>" <?= $edit_user?'':'required' ?>>
                <button class="btn-submit"><?= $edit_user?'KULLANICIYI GÜNCELLE':'KULLANICIYI KAYDET' ?></button>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Üye Tablosu</h3><input type="text" id="aramaUser" class="arama-kutusu" placeholder="🔍 ID, Kullanıcı Adı veya Rol Ara..." onkeyup="tabloFiltrele('aramaUser', 'tabloUser')"></div>
            <table class="admin-table" id="tabloUser">
                <tr><th>ID</th><th>Kullanıcı Adı</th><th>Rol</th><th style="text-align:right;">İşlem</th></tr>
                <?php foreach($users as $u): ?>
                <tr><td>#<?= $u['id'] ?></td><td><strong><?= $u['kullanici_adi'] ?></strong></td><td><?= strtoupper($u['rol']) ?></td>
                    <td style="text-align:right;"><a href="?edit_user=<?= $u['id'] ?>" class="act-btn edit">Düzenle</a>
                    <?php if($u['id'] != $_SESSION['kullanici_id']): ?><a href="?sil_user=<?= $u['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a><?php endif; ?></td>
                </tr><?php endforeach; ?>
            </table>
        </div>
    </div>

    <div id="yorum-sekme" class="form-section <?= $aktif_sekme=='yorum'?'active':'' ?>">
        <?php if($edit_yorum): ?><div class="admin-card"><h3>Yorumu Düzenle</h3><form method="POST"><input type="hidden" name="form_tipi" value="yorum_guncelle"><input type="hidden" name="yorum_id" value="<?= $edit_yorum['id'] ?>"><input type="text" name="yazan_kisi" value="<?= $edit_yorum['yazan_kisi'] ?>" required><textarea name="yorum" style="height:100px;" required><?= $edit_yorum['yorum'] ?></textarea><button class="btn-submit">YORUMU GÜNCELLE</button></form></div><?php endif; ?>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Tüm Yorumlar</h3><input type="text" id="aramaYorum" class="arama-kutusu" placeholder="🔍 Haber, Yazan veya Yorum Ara..." onkeyup="tabloFiltrele('aramaYorum', 'tabloYorum')"></div>
            <table class="admin-table" id="tabloYorum">
                <tr><th>Haber</th><th>Yazan</th><th>Yorum</th><th style="text-align:right;">İşlem</th></tr>
                <?php foreach($yorumlar as $y): ?>
                <tr><td><?= mb_substr($y['haber_baslik'],0,20) ?>...</td><td><strong><?= $y['yazan_kisi'] ?></strong></td><td><?= mb_substr($y['yorum'],0,30) ?>...</td>
                    <td style="text-align:right;"><a href="?edit_yorum=<?= $y['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_yorum=<?= $y['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                </tr><?php endforeach; ?>
            </table>
        </div>
    </div>

    <div id="log-sekme" class="form-section <?= $aktif_sekme=='log'?'active':'' ?>">
        <div class="admin-card">
            <h3>Filtrele</h3>
            <form method="GET" class="form-row">
                <input type="hidden" name="sekme" value="log">
                <select name="admin_filter" style="margin-bottom:0;"><option value="">Tüm Adminler</option><?php foreach($log_adminler as $a): ?><option value="<?= $a['id'] ?>" <?= $log_admin_filter==$a['id']?'selected':'' ?>><?= $a['kullanici_adi'] ?></option><?php endforeach; ?></select>
                <select name="tip_filter" style="margin-bottom:0;"><option value="">Tüm İşlemler</option><?php foreach($log_tipler as $t): ?><option value="<?= $t['islem_tipi'] ?>" <?= $log_tip_filter==$t['islem_tipi']?'selected':'' ?>><?= $t['islem_tipi'] ?></option><?php endforeach; ?></select>
                <button type="submit" class="btn-submit" style="padding: 12px; margin-bottom:0; width:auto;">FİLTRELE</button>
                <a href="admin.php?sekme=log" class="btn-submit" style="background:#333; text-align:center; padding: 12px; width:auto; text-decoration:none;">TEMİZLE</a>
            </form>
        </div>
        <div class="admin-card">
            <h3>Son Sistem İşlemleri (Log)</h3>
            <table class="admin-table">
                <tr><th>Tarih / Saat</th><th>Admin</th><th>İşlem Tipi</th><th>Detay</th></tr>
                <?php foreach($loglar as $l): ?>
                <tr><td><?= date('d.m.Y H:i', strtotime($l['tarih'])) ?></td><td><strong><?= $l['kullanici_adi'] ?? '<span style="color:#ff4747;">Silinmiş</span>' ?></strong></td><td><span style="color:#b76bff; font-weight:bold;"><?= $l['islem_tipi'] ?></span></td><td style="color:#aaa;"><?= $l['islem_detay'] ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
    function git(sekme) { window.location.href = "?sekme=" + sekme; }
    function tabloFiltrele(inputId, tabloId) {
        var input = document.getElementById(inputId);
        var filter = input.value.toUpperCase();
        var table = document.getElementById(tabloId);
        var tr = table.getElementsByTagName("tr");
        for (var i = 1; i < tr.length; i++) { 
            var rowContainsFilter = false;
            var td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length - 1; j++) {
                if (td[j]) {
                    var txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) { rowContainsFilter = true; break; }
                }
            }
            tr[i].style.display = rowContainsFilter ? "" : "none";
        }
    }
    const durumSecici = document.getElementById('durumSecici');
    const skorKutusu = document.getElementById('skorKutusu');
    function durumKontrolu() {
        if (!durumSecici || !skorKutusu) return;
        if (durumSecici.value === 'BAŞLAMADI') {
            skorKutusu.removeAttribute('required');
            if (skorKutusu.value === '') skorKutusu.value = 'v';
            skorKutusu.style.opacity = '0.5';
        } else {
            skorKutusu.setAttribute('required', 'required');
            skorKutusu.style.opacity = '1';
            if (skorKutusu.value === 'v') skorKutusu.value = '';
        }
    }
    if(durumSecici) { durumSecici.addEventListener('change', durumKontrolu); document.addEventListener('DOMContentLoaded', durumKontrolu); }
</script>
</body>
</html>