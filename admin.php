<?php
session_start();
// Oturum açılmamışsa veya giriş yapan kişi ADMIN değilse erişimi engelle
if (!isset($_SESSION['oturum_acildi']) || $_SESSION['oturum_acildi'] !== true || $_SESSION['rol'] !== 'admin') {
    header("Location: index.php");
    exit;
}

require_once 'baglan.php'; 
$mesaj = "";

// Hangi sekmedeyiz? (Varsayılan: haber)
$aktif_sekme = isset($_GET['sekme']) ? $_GET['sekme'] : "haber";

// Hataları önlemek için değişkenleri sıfırlıyoruz
$edit_haber = null; $edit_skor = null; $edit_user = null; $edit_yorum = null; $edit_platform = null; $edit_oyun = null; $edit_takim = null;

// === LOG KAYIT FONKSİYONU ===
function islemKaydet($db, $admin_id, $tip, $detay) {
    $sql = "INSERT INTO islem_loglari (admin_id, islem_tipi, islem_detay) VALUES (?, ?, ?)";
    $db->prepare($sql)->execute([$admin_id, $tip, $detay]);
}

// ==========================================
// 1. SİLME İŞLEMLERİ
// ==========================================

// === TOPLU SİLME İŞLEMİ (POST) ===
if (isset($_POST['toplu_sil_btn']) && isset($_POST['silme_idleri'])) {
    $silinecek_id_listesi = $_POST['silme_idleri'];
    $tablo = $_POST['tablo_adi'];
    
    // İzin verilen tablolara 'takimlar' eklendi
    $izin_verilen_tablolar = ['haberler', 'canli_skor', 'kullanicilar', 'yorumlar', 'platformlar', 'takimlar', 'oyunlar'];
    
    if (in_array($tablo, $izin_verilen_tablolar)) {
        $placeholderlar = str_repeat('?,', count($silinecek_id_listesi) - 1) . '?';
        $sql = "DELETE FROM $tablo WHERE id IN ($placeholderlar)";
        $sorgu = $db->prepare($sql);
        $sorgu->execute($silinecek_id_listesi);
        
        $mesaj = "<div class='basarili'>✅ " . count($silinecek_id_listesi) . " adet kayıt başarıyla silindi.</div>";
        islemKaydet($db, $_SESSION['kullanici_id'], "TOPLU SİLME", "$tablo tablosundan toplu silme yapıldı.");
    }
}

// === TEKLİ SİLME İŞLEMLERİ (GET) ===
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
if (isset($_GET['sil_takim'])) {
    $db->prepare("DELETE FROM takimlar WHERE id = ?")->execute([$_GET['sil_takim']]);
    islemKaydet($db, $_SESSION['kullanici_id'], 'Takım Silme', "Takım ID: {$_GET['sil_takim']} silindi.");
    $mesaj = "<div class='basarili'>🗑️ Takım silindi.</div>";
    $aktif_sekme = "takim";
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
if (isset($_GET['sil_platform'])) {
    $db->prepare("DELETE FROM platformlar WHERE id = ?")->execute([$_GET['sil_platform']]);
    islemKaydet($db, $_SESSION['kullanici_id'], 'Platform Silme', "Platform ID: {$_GET['sil_platform']} sistemden silindi.");
    $mesaj = "<div class='basarili'>🎮 Kategori (Platform/Üretici) silindi.</div>";
    $aktif_sekme = "platform";
}
if (isset($_GET['sil_oyun'])) {
    $db->prepare("DELETE FROM oyunlar WHERE id = ?")->execute([$_GET['sil_oyun']]);
    islemKaydet($db, $_SESSION['kullanici_id'], 'Oyun Silme', "Oyun ID: {$_GET['sil_oyun']} sistemden silindi.");
    $mesaj = "<div class='basarili'>🕹️ Oyun silindi.</div>";
    $aktif_sekme = "oyun";
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
if (isset($_GET['edit_takim'])) { 
    $sorgu = $db->prepare("SELECT * FROM takimlar WHERE id=?"); $sorgu->execute([$_GET['edit_takim']]);
    $edit_takim = $sorgu->fetch(); $aktif_sekme = "takim"; 
}
if (isset($_GET['edit_user'])) { 
    $sorgu = $db->prepare("SELECT * FROM kullanicilar WHERE id=?"); $sorgu->execute([$_GET['edit_user']]);
    $edit_user = $sorgu->fetch(); $aktif_sekme = "user"; 
}
if (isset($_GET['edit_yorum'])) { 
    $sorgu = $db->prepare("SELECT * FROM yorumlar WHERE id=?"); $sorgu->execute([$_GET['edit_yorum']]);
    $edit_yorum = $sorgu->fetch(); $aktif_sekme = "yorum"; 
}
if (isset($_GET['edit_platform'])) { 
    $sorgu = $db->prepare("SELECT * FROM platformlar WHERE id=?"); $sorgu->execute([$_GET['edit_platform']]);
    $edit_platform = $sorgu->fetch(); $aktif_sekme = "platform"; 
}
if (isset($_GET['edit_oyun'])) { 
    $sorgu = $db->prepare("SELECT * FROM oyunlar WHERE id=?"); $sorgu->execute([$_GET['edit_oyun']]);
    $edit_oyun = $sorgu->fetch(); $aktif_sekme = "oyun"; 
}

// ==========================================
// 3. FORM GÖNDERİMLERİ (POST)
// ==========================================
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['toplu_sil_btn'])) {
    $tip = $_POST['form_tipi'];

    // --- TAKIM İŞLEMLERİ ---
    if ($tip == "takim" || $tip == "takim_guncelle") {
        if ($tip == "takim") {
            $db->prepare("INSERT INTO takimlar (takim_adi) VALUES (?)")->execute([trim($_POST['takim_adi'])]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Takım Ekleme', "Yeni Takım: {$_POST['takim_adi']}");
        } else {
            $db->prepare("UPDATE takimlar SET takim_adi=? WHERE id=?")->execute([trim($_POST['takim_adi']), $_POST['takim_id']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Takım Düzenleme', "Takım ID: {$_POST['takim_id']} güncellendi.");
        }
        $aktif_sekme = "takim";
    }

    // --- HABER İŞLEMLERİ ---
    else if ($tip == "haber" || $tip == "haber_guncelle") {
        $resim = $_POST['eski_resim'] ?? "img/logolar/logo.png";
        if (!empty($_POST['resim_url'])) { $resim = trim($_POST['resim_url']); }
        if (isset($_FILES['resim_dosya']) && $_FILES['resim_dosya']['error'] == 0) {
            $path = "img/haberresim/" . time() . "_" . $_FILES['resim_dosya']['name'];
            if (move_uploaded_file($_FILES['resim_dosya']['tmp_name'], $path)) { $resim = $path; }
        }
        $kaynak_url = !empty($_POST['kaynak_url']) ? trim($_POST['kaynak_url']) : null;
        
        // Yeni eklenen kategori verisini al (Varsayılan 'Haber' olsun)
        $kategori = !empty($_POST['kategori']) ? $_POST['kategori'] : 'Haber';

        if ($tip == "haber") {
            // INSERT sorgusuna kategori eklendi
            $db->prepare("INSERT INTO haberler (baslik, ozet, icerik, platform, resim, kaynak_url, kategori) VALUES (?,?,?,?,?,?,?)")
               ->execute([$_POST['baslik'], $_POST['ozet'], $_POST['icerik'], $_POST['platform'], $resim, $kaynak_url, $kategori]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'İçerik Ekleme', "Yeni $kategori: {$_POST['baslik']}");
        } else {
            // UPDATE sorgusuna kategori eklendi
            $db->prepare("UPDATE haberler SET baslik=?, ozet=?, icerik=?, platform=?, resim=?, kaynak_url=?, kategori=? WHERE id=?")
               ->execute([$_POST['baslik'], $_POST['ozet'], $_POST['icerik'], $_POST['platform'], $resim, $kaynak_url, $kategori, $_POST['haber_id']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'İçerik Düzenleme', "İçerik ID: {$_POST['haber_id']} güncellendi.");
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
        $user_kadi = trim($_POST['kullanici_adi']);
        $user_eposta = trim($_POST['eposta']); 
        $user_rol = $_POST['rol'];
        
        if ($tip == "user") {
            $hashed = password_hash($_POST['sifre'], PASSWORD_DEFAULT);
            $db->prepare("INSERT INTO kullanicilar (kullanici_adi, eposta, sifre, rol) VALUES (?,?,?,?)")->execute([$user_kadi, $user_eposta, $hashed, $user_rol]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Kullanıcı Ekleme', "Yeni $user_rol: $user_kadi");
        } else {
            if (!empty($_POST['sifre'])) {
                $hashed = password_hash($_POST['sifre'], PASSWORD_DEFAULT);
                $db->prepare("UPDATE kullanicilar SET kullanici_adi=?, eposta=?, sifre=?, rol=? WHERE id=?")->execute([$user_kadi, $user_eposta, $hashed, $user_rol, $_POST['user_id']]);
            } else {
                $db->prepare("UPDATE kullanicilar SET kullanici_adi=?, eposta=?, rol=? WHERE id=?")->execute([$user_kadi, $user_eposta, $user_rol, $_POST['user_id']]);
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

    // --- PLATFORM / ÜRETİCİ İŞLEMLERİ ---
    else if ($tip == "platform" || $tip == "platform_guncelle") {
        $logo = $_POST['eski_logo'] ?? "default.png";
        if (!empty($_POST['logo_metin'])) { $logo = trim($_POST['logo_metin']); }
        if (isset($_FILES['logo_dosya']) && $_FILES['logo_dosya']['error'] == 0) {
            $dosya_adi = $_FILES['logo_dosya']['name'];
            $path = "img/logolar/" . $dosya_adi;
            if (move_uploaded_file($_FILES['logo_dosya']['tmp_name'], $path)) { $logo = $dosya_adi; }
        }

        if ($tip == "platform") {
            $db->prepare("INSERT INTO platformlar (isim, logo, kategori) VALUES (?,?,?)")->execute([trim($_POST['isim']), $logo, $_POST['kategori']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Platform Ekleme', "Yeni Kategori eklendi: {$_POST['isim']}");
        } else {
            $db->prepare("UPDATE platformlar SET isim=?, logo=?, kategori=? WHERE id=?")->execute([trim($_POST['isim']), $logo, $_POST['kategori'], $_POST['platform_id']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Platform Düzenleme', "Marka ID: {$_POST['platform_id']} güncellendi.");
        }
        $aktif_sekme = "platform";
    }

    // --- OYUN İŞLEMLERİ ---
    else if ($tip == "oyun" || $tip == "oyun_guncelle") {
        $logo = $_POST['eski_logo'] ?? "default.png";
        if (!empty($_POST['logo_metin'])) { $logo = trim($_POST['logo_metin']); }
        if (isset($_FILES['logo_dosya']) && $_FILES['logo_dosya']['error'] == 0) {
            $dosya_adi = $_FILES['logo_dosya']['name'];
            $path = "img/logolar/" . $dosya_adi;
            if (move_uploaded_file($_FILES['logo_dosya']['tmp_name'], $path)) { $logo = $dosya_adi; }
        }

        if ($tip == "oyun") {
            $db->prepare("INSERT INTO oyunlar (isim, logo) VALUES (?,?)")->execute([trim($_POST['isim']), $logo]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Oyun Ekleme', "Yeni Oyun eklendi: {$_POST['isim']}");
        } else {
            $db->prepare("UPDATE oyunlar SET isim=?, logo=? WHERE id=?")->execute([trim($_POST['isim']), $logo, $_POST['oyun_id']]);
            islemKaydet($db, $_SESSION['kullanici_id'], 'Oyun Düzenleme', "Oyun ID: {$_POST['oyun_id']} güncellendi.");
        }
        $aktif_sekme = "oyun";
    }

    $mesaj = "<div class='basarili'>✅ İşlem başarıyla gerçekleştirildi.</div>";
}

// === VERİLERİ ÇEK ===
$haberler = $db->query("SELECT * FROM haberler ORDER BY id DESC")->fetchAll(); 
$skorlar = $db->query("SELECT * FROM canli_skor ORDER BY id DESC")->fetchAll();
$users = $db->query("SELECT * FROM kullanicilar ORDER BY id DESC")->fetchAll();
$yorumlar = $db->query("SELECT y.*, h.baslik as haber_baslik FROM yorumlar y JOIN haberler h ON y.haber_id = h.id ORDER BY y.id DESC")->fetchAll();
$mevcut_ligler = $db->query("SELECT DISTINCT lig FROM canli_skor ORDER BY lig ASC")->fetchAll();
$takimlar = $db->query("SELECT * FROM takimlar ORDER BY takim_adi ASC")->fetchAll();
$platformlar = $db->query("SELECT * FROM platformlar ORDER BY id DESC")->fetchAll();
$oyunlar_tablosu = $db->query("SELECT * FROM oyunlar ORDER BY id DESC")->fetchAll();

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
        .top-navbar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; border-bottom: 1px solid #333; padding-bottom: 15px; }
        .top-btn { text-decoration: none; font-weight: bold; font-size: 13px; padding: 10px 22px; border-radius: 8px; transition: 0.3s; text-transform: uppercase; letter-spacing: 0.5px; display: inline-flex; align-items: center; gap: 8px; }
        .btn-home { background: rgba(183, 107, 255, 0.1); color: #b76bff; border: 1px solid #b76bff; }
        .btn-home:hover { background: #b76bff; color: #fff; box-shadow: 0 0 15px rgba(183,107,255,0.4); }
        .btn-logout { background: rgba(255, 71, 71, 0.1); color: #ff4747; border: 1px solid #ff4747; }
        .btn-logout:hover { background: #ff4747; color: #fff; box-shadow: 0 0 15px rgba(255,71,71,0.4); }
        h2 { font-family: 'Oswald'; text-align: center; color: #b76bff; font-size: 30px; letter-spacing: 2px; margin-bottom: 30px; }
        .main-tabs { display: flex; flex-wrap: wrap; background: #0a0a0a; padding: 8px; border-radius: 12px; border: 1px solid #222; margin-bottom: 30px; gap: 8px; }
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
        <a href="index.php" class="top-btn btn-home">ANA SAYFA</a>
        <a href="cikis.php" class="top-btn btn-logout">ÇIKIŞ YAP</a>
    </div>

    <h2>[GAMEPORTAL] SÜPER KONTROL MERKEZİ</h2>
    <?= $mesaj ?>

    <div class="main-tabs">
        <button class="m-tab <?= $aktif_sekme=='haber'?'active':'' ?>" onclick="git('haber')">📰 Haber</button>
        <button class="m-tab <?= $aktif_sekme=='skor'?'active':'' ?>" onclick="git('skor')">🏆 Skor</button>
        <button class="m-tab <?= $aktif_sekme=='takim'?'active':'' ?>" onclick="git('takim')">🚩 Takım</button>
        <button class="m-tab <?= $aktif_sekme=='user'?'active':'' ?>" onclick="git('user')">👥 Kullanıcı</button>
        <button class="m-tab <?= $aktif_sekme=='yorum'?'active':'' ?>" onclick="git('yorum')">💬 Yorum</button>
        <button class="m-tab <?= $aktif_sekme=='platform'?'active':'' ?>" onclick="git('platform')">🎮 Kategori</button>
        <button class="m-tab <?= $aktif_sekme=='oyun'?'active':'' ?>" onclick="git('oyun')">🕹️ Oyunlar</button>
        <button class="m-tab <?= $aktif_sekme=='log'?'active':'' ?>" onclick="git('log')">🕒 Log</button>
    </div>

    <div id="haber-sekme" class="form-section <?= $aktif_sekme=='haber'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_haber ? 'İçeriği Düzenle' : 'Yeni İçerik Ekle' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="form_tipi" value="<?= $edit_haber?'haber_guncelle':'haber' ?>">
                <input type="hidden" name="haber_id" value="<?= $edit_haber['id']??'' ?>">
                <input type="hidden" name="eski_resim" value="<?= $edit_haber['resim']??'' ?>">
                <input type="text" name="baslik" placeholder="Başlık" value="<?= $edit_haber['baslik']??'' ?>" required>
                
                <div class="form-row">
                    <select name="platform" required>
                        <option value="">Platform / Oyun Seçin</option>
                        <optgroup label="Platformlar & Üreticiler">
                            <?php foreach($platformlar as $p): ?>
                                <option value="<?= $p['isim'] ?>" <?= ($edit_haber && $edit_haber['platform'] == $p['isim']) ? 'selected' : '' ?>><?= $p['isim'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <optgroup label="Oyunlar">
                            <?php foreach($oyunlar_tablosu as $o): ?>
                                <option value="<?= $o['isim'] ?>" <?= ($edit_haber && $edit_haber['platform'] == $o['isim']) ? 'selected' : '' ?>><?= $o['isim'] ?></option>
                            <?php endforeach; ?>
                        </optgroup>
                        <option value="PC" <?= ($edit_haber && $edit_haber['platform']=='PC')?'selected':'' ?>>PC (Genel)</option>
                    </select>
                    <input type="file" name="resim_dosya">
                </div>
                
                <div class="form-row"><input type="url" name="resim_url" placeholder="URL (http://...)"></div>
                <input type="text" name="ozet" placeholder="Kısa Özet" value="<?= $edit_haber['ozet']??'' ?>" required>
                <textarea name="icerik" placeholder="Detaylar" style="height:120px;" required><?= $edit_haber['icerik']??'' ?></textarea>
                <button class="btn-submit"><?= $edit_haber?'İÇERİĞİ GÜNCELLE':'İÇERİĞİ YAYINLA' ?></button>
                <?php if($edit_haber): ?><a href="?sekme=haber" style="display:block; text-align:center; margin-top:10px; color:#ff4747; text-decoration:none;">İptal Et</a><?php endif; ?>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex">
                <h3>Kayıtlı Haberler</h3>
                <input type="text" id="aramaHaber" class="arama-kutusu" placeholder="🔍 Başlık, ID veya Platform Ara..." onkeyup="tabloFiltrele('aramaHaber', 'tabloHaber')">
            </div>
            <form method="POST" action="admin.php?sekme=haber">
                <input type="hidden" name="tablo_adi" value="haberler">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili haberleri silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloHaber">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'haber-checkbox')"></th><th>ID</th><th>Başlık</th><th>Platform</th><th style="text-align:right;">İşlem</th></tr>
                    <?php foreach($haberler as $h): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $h['id'] ?>" class="haber-checkbox"></td><td>#<?= $h['id'] ?></td><td><strong><?= mb_substr($h['baslik'],0,40) ?>...</strong></td><td><?= $h['platform'] ?></td>
                        <td style="text-align:right;"><a href="?edit_haber=<?= $h['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_haber=<?= $h['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr><?php endforeach; ?>
                </table>
            </form>
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
                <datalist id="ligListesi"><?php foreach($mevcut_ligler as $l): ?><option value="<?= htmlspecialchars($l['lig']) ?>"><?php endforeach; ?></datalist>
                <div class="form-row">
                    <select name="ev_sahibi" required><option value="">Ev Sahibi Seç</option><?php foreach($takimlar as $t): ?><option value="<?= $t['takim_adi'] ?>" <?= ($edit_skor && $edit_skor['ev_sahibi']==$t['takim_adi'])?'selected':'' ?>><?= $t['takim_adi'] ?></option><?php endforeach; ?></select>
                    <select name="deplasman" required><option value="">Deplasman Seç</option><?php foreach($takimlar as $t): ?><option value="<?= $t['takim_adi'] ?>" <?= ($edit_skor && $edit_skor['deplasman']==$t['takim_adi'])?'selected':'' ?>><?= $t['takim_adi'] ?></option><?php endforeach; ?></select>
                </div>
                <div class="form-row">
                    <input type="text" name="skor" id="skorKutusu" placeholder="Skor (Örn: 2 - 1)" value="<?= $edit_skor['skor']??'' ?>">
                    <input type="time" name="saat" id="saatKutusu" value="<?= $edit_skor['saat']??'' ?>" required>
                </div>
                <input type="text" name="periyot" placeholder="Periyot / Detay (Örn: 2. Yarı)" value="<?= $edit_skor['periyot']??'' ?>">
                <button class="btn-submit"><?= $edit_skor?'MAÇI GÜNCELLE':'MAÇI SİSTEME EKLE' ?></button>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Sistemdeki Maçlar</h3><input type="text" id="aramaSkor" class="arama-kutusu" placeholder="🔍 Oyun, Takım veya Durum Ara..." onkeyup="tabloFiltrele('aramaSkor', 'tabloSkor')"></div>
            <form method="POST" action="admin.php?sekme=skor">
                <input type="hidden" name="tablo_adi" value="canli_skor">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili maçları silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloSkor">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'skor-checkbox')"></th><th>Oyun</th><th>Karşılaşma</th><th>Durum</th><th style="text-align:right;">İşlem</th></tr>
                    <?php foreach($skorlar as $s): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $s['id'] ?>" class="skor-checkbox"></td><td style="text-transform:uppercase;"><strong><?= $s['oyun'] ?></strong></td><td><?= $s['ev_sahibi'] ?> vs <?= $s['deplasman'] ?></td>
                        <td><?php if($s['durum'] == 'CANLI') echo '<span style="color:#ff4747; font-weight:bold;">CANLI</span>'; else echo $s['saat']; ?></td>
                        <td style="text-align:right;"><a href="?edit_skor=<?= $s['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_skor=<?= $s['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr><?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>

    <div id="takim-sekme" class="form-section <?= $aktif_sekme=='takim'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_takim ? 'Takımı Düzenle' : 'Yeni Takım Ekle' ?></h3>
            <form method="POST">
                <input type="hidden" name="form_tipi" value="<?= $edit_takim?'takim_guncelle':'takim' ?>">
                <input type="hidden" name="takim_id" value="<?= $edit_takim['id']??'' ?>">
                <input type="text" name="takim_adi" placeholder="Takım Adı (Örn: Sangal Esports)" value="<?= $edit_takim['takim_adi']??'' ?>" required>
                <button class="btn-submit"><?= $edit_takim?'TAKIMI GÜNCELLE':'TAKIMI EKLE' ?></button>
                <?php if($edit_takim): ?><a href="?sekme=takim" style="display:block; text-align:center; margin-top:10px; color:#ff4747; text-decoration:none;">İptal Et</a><?php endif; ?>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Sistemdeki Takımlar</h3><input type="text" id="aramaTakim" class="arama-kutusu" placeholder="🔍 Takım Ara..." onkeyup="tabloFiltrele('aramaTakim', 'tabloTakim')"></div>
            <form method="POST" action="admin.php?sekme=takim">
                <input type="hidden" name="tablo_adi" value="takimlar">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili takımları silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloTakim">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'takim-checkbox')"></th><th>ID</th><th>Takım Adı</th><th style="text-align:right;">İşlem</th></tr>
                    <?php foreach($takimlar as $t): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $t['id'] ?>" class="takim-checkbox"></td><td>#<?= $t['id'] ?></td><td><strong><?= $t['takim_adi'] ?></strong></td>
                        <td style="text-align:right;"><a href="?edit_takim=<?= $t['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_takim=<?= $t['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr><?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>

    <div id="user-sekme" class="form-section <?= $aktif_sekme=='user'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_user ? 'Kullanıcıyı Düzenle' : 'Sisteme Kullanıcı Ekle' ?></h3>
            <form method="POST">
                <input type="hidden" name="form_tipi" value="<?= $edit_user?'user_guncelle':'user' ?>">
                <input type="hidden" name="user_id" value="<?= $edit_user['id']??'' ?>">
                <div class="form-row">
                    <input type="text" name="kullanici_adi" placeholder="Kullanıcı Adı" value="<?= $edit_user['kullanici_adi']??'' ?>" required>
                    <input type="email" name="eposta" placeholder="E-Posta Adresi" value="<?= $edit_user['eposta']??'' ?>" required>
                    <select name="rol">
                        <option value="kullanici" <?= ($edit_user && $edit_user['rol']=='kullanici')?'selected':'' ?>>Kullanıcı (Üye)</option>
                        <option value="admin" <?= ($edit_user && $edit_user['rol']=='admin')?'selected':'' ?>>Admin (Yönetici)</option>
                    </select>
                </div>
                <input type="text" name="sifre" placeholder="<?= $edit_user?'Yeni Şifre (Değişmeyecekse boş bırak)':'Kullanıcı Şifresi' ?>" <?= $edit_user?'':'required' ?>>
                <button class="btn-submit"><?= $edit_user?'KULLANICIYI GÜNCELLE':'KULLANICIYI KAYDET' ?></button>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Üye Tablosu</h3><input type="text" id="aramaUser" class="arama-kutusu" placeholder="🔍 ID, Kullanıcı Adı veya Rol Ara..." onkeyup="tabloFiltrele('aramaUser', 'tabloUser')"></div>
            <form method="POST" action="admin.php?sekme=user">
                <input type="hidden" name="tablo_adi" value="kullanicilar">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili kullanıcıları silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloUser">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'user-checkbox')"></th><th>ID</th><th>Kullanıcı Adı</th><th>Rol</th><th style="text-align:right;">İşlem</th></tr>
                    <?php foreach($users as $u): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $u['id'] ?>" class="user-checkbox"></td><td>#<?= $u['id'] ?></td><td><strong><?= $u['kullanici_adi'] ?></strong></td><td><?= strtoupper($u['rol']) ?></td>
                        <td style="text-align:right;"><a href="?edit_user=<?= $u['id'] ?>" class="act-btn edit">Düzenle</a><?php if($u['id'] != $_SESSION['kullanici_id']): ?><a href="?sil_user=<?= $u['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a><?php endif; ?></td>
                    </tr><?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>

    <div id="yorum-sekme" class="form-section <?= $aktif_sekme=='yorum'?'active':'' ?>">
        <?php if($edit_yorum): ?><div class="admin-card"><h3>Yorumu Düzenle</h3><form method="POST"><input type="hidden" name="form_tipi" value="yorum_guncelle"><input type="hidden" name="yorum_id" value="<?= $edit_yorum['id'] ?>"><input type="text" name="yazan_kisi" value="<?= $edit_yorum['yazan_kisi'] ?>" required><textarea name="yorum" style="height:100px;" required><?= $edit_yorum['yorum'] ?></textarea><button class="btn-submit">YORUMU GÜNCELLE</button></form></div><?php endif; ?>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Tüm Yorumlar</h3><input type="text" id="aramaYorum" class="arama-kutusu" placeholder="🔍 Haber, Yazan veya Yorum Ara..." onkeyup="tabloFiltrele('aramaYorum', 'tabloYorum')"></div>
            <form method="POST" action="admin.php?sekme=yorum">
                <input type="hidden" name="tablo_adi" value="yorumlar">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili yorumları silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloYorum">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'yorum-checkbox')"></th><th>Haber</th><th>Yazan</th><th>Yorum</th><th style="text-align:right;">İşlem</th></tr>
                    <?php foreach($yorumlar as $y): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $y['id'] ?>" class="yorum-checkbox"></td><td><?= mb_substr($y['haber_baslik'],0,20) ?>...</td><td><strong><?= $y['yazan_kisi'] ?></strong></td><td><?= mb_substr($y['yorum'],0,30) ?>...</td>
                        <td style="text-align:right;"><a href="?edit_yorum=<?= $y['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_yorum=<?= $y['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr><?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>

    <div id="platform-sekme" class="form-section <?= $aktif_sekme=='platform'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= $edit_platform ? 'Kaydı Düzenle' : 'Platform / Üretici Ekle' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="form_tipi" value="<?= $edit_platform ? 'platform_guncelle' : 'platform' ?>">
                <input type="hidden" name="platform_id" value="<?= $edit_platform['id']??'' ?>">
                <input type="hidden" name="eski_logo" value="<?= $edit_platform['logo']??'' ?>">
                <div class="form-row">
                    <input type="text" name="isim" placeholder="Platform veya Oyun Adı (Örn: CS2, Steam)" value="<?= $edit_platform['isim']??'' ?>" required>
                    <select name="kategori" required>
                        <option value="Platform" <?= ($edit_platform && $edit_platform['kategori']=='Platform')?'selected':'' ?>>Platform</option>
                        <option value="Üretici" <?= ($edit_platform && $edit_platform['kategori']=='Üretici')?'selected':'' ?>>Üretici</option>
                        <option value="Oyun" <?= ($edit_platform && $edit_platform['kategori']=='Oyun')?'selected':'' ?>>Oyun</option>
                    </select>
                </div>
                <div class="form-row"><input type="text" name="logo_metin" placeholder="Logo Dosya Adı" value="<?= $edit_platform['logo']??'' ?>"><input type="file" name="logo_dosya"></div>
                <button class="btn-submit"><?= $edit_platform ? 'KAYDI GÜNCELLE' : 'SİSTEME EKLE' ?></button>
                <?php if($edit_platform): ?><a href="?sekme=platform" style="display:block; text-align:center; margin-top:10px; color:#ff4747; text-decoration:none;">İptal Et</a><?php endif; ?>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Kayıtlı Platformlar ve Oyunlar</h3><input type="text" id="aramaPlatform" class="arama-kutusu" placeholder="🔍 İsim Ara..." onkeyup="tabloFiltrele('aramaPlatform', 'tabloPlatform')"></div>
            <form method="POST" action="admin.php?sekme=platform">
                <input type="hidden" name="tablo_adi" value="platformlar">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili markaları silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloPlatform">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'plat-checkbox')"></th><th>ID</th><th>Önizleme</th><th>Kategori İsmi</th><th>Kategori</th><th style="text-align:right;">İşlem</th></tr>
                    <?php foreach($platformlar as $p): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $p['id'] ?>" class="plat-checkbox"></td><td>#<?= $p['id'] ?></td><td><img src="img/logolar/<?= htmlspecialchars($p['logo']) ?>" style="height:25px; max-width: 50px; object-fit:contain;"></td><td><strong><?= htmlspecialchars($p['isim']) ?></strong></td><td><?= htmlspecialchars($p['kategori']) ?></td>
                        <td style="text-align:right;"><a href="?edit_platform=<?= $p['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_platform=<?= $p['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr><?php endforeach; ?>
                </table>
            </form>
        </div>
    </div>

    <div id="oyun-sekme" class="form-section <?= $aktif_sekme=='oyun'?'active':'' ?>">
        <div class="admin-card">
            <h3><?= isset($edit_oyun) && $edit_oyun ? 'Oyunu Düzenle' : 'Sisteme Yeni Oyun Ekle' ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="form_tipi" value="<?= isset($edit_oyun) && $edit_oyun ? 'oyun_guncelle' : 'oyun' ?>">
                <input type="hidden" name="oyun_id" value="<?= $edit_oyun['id']??'' ?>">
                <input type="hidden" name="eski_logo" value="<?= $edit_oyun['logo']??'' ?>">
                <div class="form-row">
                    <input type="text" name="isim" placeholder="Oyun Adı (Örn: CS2, Valorant)" value="<?= $edit_oyun['isim']??'' ?>" required>
                </div>
                <div class="form-row"><input type="text" name="logo_metin" placeholder="Logo Dosya Adı" value="<?= $edit_oyun['logo']??'' ?>"><input type="file" name="logo_dosya"></div>
                <button class="btn-submit"><?= isset($edit_oyun) && $edit_oyun ? 'OYUNU GÜNCELLE' : 'OYUNU SİSTEME EKLE' ?></button>
                <?php if(isset($edit_oyun) && $edit_oyun): ?><a href="?sekme=oyun" style="display:block; text-align:center; margin-top:10px; color:#ff4747; text-decoration:none;">İptal Et</a><?php endif; ?>
            </form>
        </div>
        <div class="admin-card">
            <div class="card-header-flex"><h3>Kayıtlı Oyunlar</h3><input type="text" id="aramaOyun" class="arama-kutusu" placeholder="🔍 Oyun Ara..." onkeyup="tabloFiltrele('aramaOyun', 'tabloOyun')"></div>
            <form method="POST" action="admin.php?sekme=oyun">
                <input type="hidden" name="tablo_adi" value="oyunlar">
                <div style="margin-bottom: 15px; display: flex; align-items: center; gap: 15px;">
                    <button type="submit" name="toplu_sil_btn" class="act-btn del" style="padding: 10px 20px; cursor: pointer;" onclick="return confirm('Seçili oyunları silmek istediğine emin misin?')">🗑️ SEÇİLENLERİ TOPLU SİL</button>
                </div>
                <table class="admin-table" id="tabloOyun">
                    <tr><th><input type="checkbox" onclick="toggleChecks(this, 'oyun-checkbox')"></th><th>ID</th><th>Logo</th><th>Oyun İsmi</th><th style="text-align:right;">İşlem</th></tr>
                    <?php if(isset($oyunlar_tablosu)): foreach($oyunlar_tablosu as $o): ?>
                    <tr><td><input type="checkbox" name="silme_idleri[]" value="<?= $o['id'] ?>" class="oyun-checkbox"></td><td>#<?= $o['id'] ?></td><td><img src="img/logolar/<?= htmlspecialchars($o['logo']) ?>" style="height:25px; max-width: 50px; object-fit:contain;"></td><td><strong><?= htmlspecialchars($o['isim']) ?></strong></td>
                        <td style="text-align:right;"><a href="?edit_oyun=<?= $o['id'] ?>" class="act-btn edit">Düzenle</a><a href="?sil_oyun=<?= $o['id'] ?>" class="act-btn del" onclick="return confirm('Silinsin mi?')">Sil</a></td>
                    </tr><?php endforeach; endif; ?>
                </table>
            </form>
        </div>
    </div>
    <div id="log-sekme" class="form-section <?= $aktif_sekme=='log'?'active':'' ?>">
        <div class="admin-card">
            <h3>Filtrele</h3>
            <form method="GET" class="form-row">
                <input type="hidden" name="sekme" value="log">
                <select name="admin_filter"><option value="">Tüm Adminler</option><?php foreach($log_adminler as $a): ?><option value="<?= $a['id'] ?>" <?= $log_admin_filter==$a['id']?'selected':'' ?>><?= $a['kullanici_adi'] ?></option><?php endforeach; ?></select>
                <select name="tip_filter"><option value="">Tüm İşlemler</option><?php foreach($log_tipler as $t): ?><option value="<?= $t['islem_tipi'] ?>" <?= $log_tip_filter==$t['islem_tipi']?'selected':'' ?>><?= $t['islem_tipi'] ?></option><?php endforeach; ?></select>
                <button type="submit" class="btn-submit" style="width:auto;">FİLTRELE</button>
            </form>
        </div>
        <div class="admin-card">
            <h3>Son İşlemler</h3>
            <table class="admin-table">
                <tr><th>Tarih</th><th>Admin</th><th>İşlem</th><th>Detay</th></tr>
                <?php foreach($loglar as $l): ?>
                <tr><td><?= date('d.m.Y H:i', strtotime($l['tarih'])) ?></td><td><strong><?= $l['kullanici_adi'] ?? 'Silinmiş' ?></strong></td><td><?= $l['islem_tipi'] ?></td><td><?= $l['islem_detay'] ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<script>
    function git(sekme) { window.location.href = "?sekme=" + sekme; }
    function toggleChecks(source, className) {
        var checkboxes = document.getElementsByClassName(className);
        for(var i=0; i<checkboxes.length; i++) checkboxes[i].checked = source.checked;
    }
    function tabloFiltrele(inputId, tabloId) {
        var input = document.getElementById(inputId);
        var filter = input.value.toUpperCase();
        var table = document.getElementById(tabloId);
        var tr = table.getElementsByTagName("tr");
        for (var i = 1; i < tr.length; i++) { 
            var rowContainsFilter = false;
            var td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
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
    const saatKutusu = document.getElementById('saatKutusu');
    function durumKontrolu() {
        if (!durumSecici) return;
        if (skorKutusu) {
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
        if (saatKutusu) {
            if (durumSecici.value === 'MS') {
                saatKutusu.removeAttribute('required'); 
                saatKutusu.style.opacity = '0.3'; 
            } else {
                saatKutusu.setAttribute('required', 'required'); 
                saatKutusu.style.opacity = '1'; 
            }
        }
    }
    if(durumSecici) { 
        durumSecici.addEventListener('change', durumKontrolu); 
        document.addEventListener('DOMContentLoaded', durumKontrolu); 
    }
</script>
</body>
</html>