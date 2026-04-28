-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 28 Nis 2026, 19:34:19
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gameportal_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `canli_skor`
--

CREATE TABLE `canli_skor` (
  `id` int(11) NOT NULL,
  `oyun` varchar(100) NOT NULL,
  `lig` varchar(100) NOT NULL,
  `saat` varchar(50) NOT NULL,
  `durum` varchar(50) NOT NULL,
  `ev_sahibi` varchar(100) NOT NULL,
  `skor` varchar(50) NOT NULL,
  `deplasman` varchar(100) NOT NULL,
  `periyot` varchar(50) DEFAULT NULL,
  `ev_sahibi_logo` varchar(255) DEFAULT '../img/varsayilan_logo.png',
  `deplasman_logo` varchar(255) DEFAULT '../img/varsayilan_logo.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `canli_skor`
--

INSERT INTO `canli_skor` (`id`, `oyun`, `lig`, `saat`, `durum`, `ev_sahibi`, `skor`, `deplasman`, `periyot`, `ev_sahibi_logo`, `deplasman_logo`) VALUES
(1, 'valorant', 'VCL', '20:00', 'BAŞLAMADI', 'Otakar Esports', 'v', 'Ramboot Club', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/137824/600px_otakar_esports_lightmode.png', 'https://cdn-api.pandascore.co/images/team/image/131338/285px_ramboot_club_2022_allmode.png'),
(2, 'dota', 'DREAMLEAGUE', '17:36', 'CANLI', 'Team Lynx', '1 - 0', 'South America Rejects', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/136531/109px_team_lynx_lightmode.png', '../img/varsayilan_logo.png'),
(3, 'cs2', 'BC GAME MASTERS', '19:00', 'BAŞLAMADI', 'CYBERSHOKE Esports', 'v', 'ex-Zero Tenacity', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/133542/128px_cybershoke_esports_allmode.png', '../img/varsayilan_logo.png'),
(4, 'cs2', 'BC GAME MASTERS', '22:00', 'BAŞLAMADI', 'AaB Esport', 'v', 'The Last Resort', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/128394/aa_b_esport_logo_red_hvid_bg.png', 'https://cdn-api.pandascore.co/images/team/image/130590/190px_the_last_resort_lightmode.png'),
(5, 'cs2', 'BC GAME MASTERS', '00:00', 'BAŞLAMADI', 'Walczaki', 'v', 'ASTRAL', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/138610/800px_walczaki_lightmode.png', 'https://cdn-api.pandascore.co/images/team/image/137440/265px_astral_esports_lightmode.png'),
(6, 'cs2', 'BC GAME MASTERS', '19:00', 'BAŞLAMADI', 'HEROIC Academy', 'v', 'HyperSpirit', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/136815/680px_heroic_2023_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/133988/172px_hyper_spirit_2024_allmode.png'),
(7, 'cs2', 'BC GAME MASTERS', '00:00', 'BAŞLAMADI', 'SPARTA', 'v', 'megoshort', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/136659/233px_sparta__russian_team__allmode.png', 'https://cdn-api.pandascore.co/images/team/image/128629/megashort.png'),
(8, 'cs2', 'BC GAME MASTERS', '19:00', 'BAŞLAMADI', 'TNC', 'v', 'GenOne', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/137416/285px_tnc_esports_lightmode.png', 'https://cdn-api.pandascore.co/images/team/image/128519/genone_csgo.png'),
(9, 'cs2', 'BC GAME MASTERS', '19:00', 'BAŞLAMADI', 'Lavked', 'v', 'against All authority', 'Bekleniyor', '../img/varsayilan_logo.png', 'https://cdn-api.pandascore.co/images/team/image/137790/600px_against_all_authority_allmode.png'),
(10, 'valorant', 'VCL', '20:00', 'BAŞLAMADI', 'Formulation Gaming', 'v', 'Bitfix Gaming', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/132430/216px_formulation_gaming_2021_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/134011/190px_bitfix_gaming_2021_lightmode.png'),
(11, 'cs2', 'CONQUEST OF PRAGUE', '20:00', 'BAŞLAMADI', 'Walczaki', 'v', 'Tricked', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/138610/800px_walczaki_lightmode.png', 'https://cdn-api.pandascore.co/images/team/image/125071/222px_tricked_esport_2025_allmode.png'),
(12, 'lol', 'HLL', '20:00', 'BAŞLAMADI', 'WLGaming Esports', 'v', 'The ParadOx', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/126215/we_love_gaminglogo_square.png', 'https://cdn-api.pandascore.co/images/team/image/134916/ezgif_2bdeaa78b8c724fc.png'),
(13, 'cs2', 'ESL CHALLENGER LEAGUE', '18:22', 'CANLI', 'Boring Players', '0 - 0', 'Just Swing', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/135162/205px_boring_players_2024_lightmode.png', 'https://cdn-api.pandascore.co/images/team/image/136330/474px_just_swing_2026_allmode.png'),
(14, 'valorant', 'VCL', '19:30', 'BAŞLAMADI', 'Fire Flux Esports', 'v', 'Misa Esports', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/129194/60b41997755c0.png', 'https://cdn-api.pandascore.co/images/team/image/137017/599px_misa_esports_2023_allmode.png'),
(15, 'cs2', 'EXORT SERIES', '17:34', 'CANLI', 'Ctrl Alt Defeat', '0 - 1', 'VP.Future', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/136564/ctrl_alt_defeat_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/137235/223px_vp.future_allmode.png'),
(16, 'cs2', 'UKIC', '22:00', 'BAŞLAMADI', 'MAGIC PIGGY', 'v', 'Dripmen', 'Bekleniyor', '../img/varsayilan_logo.png', '../img/varsayilan_logo.png'),
(17, 'cs2', 'ESL CHALLENGER LEAGUE', '18:07', 'CANLI', 'Rare Atom', '0 - 0', 'Kaleido Gaming', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/130329/162px_rare_atom_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/137155/kaleido_gaming_2025_allmode.png'),
(18, 'lol', 'HLL', '18:07', 'CANLI', 'GOAL', '0 - 0', 'Team Phantasma', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/136763/goal_esportslogo_square.png', 'https://cdn-api.pandascore.co/images/team/image/129409/190px_team_phantasma_teamcard.png'),
(19, 'lol', 'LPL', '16:17', 'MS', 'Weibo Gaming', '2 - 0', 'Top Esports', 'Maç Sonu', 'https://cdn-api.pandascore.co/images/team/image/129972/weibo_gaminglogo_profile.png', 'https://cdn-api.pandascore.co/images/team/image/126059/top_esportslogo_square.png'),
(20, 'cs2', 'ESL CHALLENGER LEAGUE', '18:00', 'BAŞLAMADI', 'Alter Ego', 'v', 'Last Bullet', 'Bekleniyor', 'https://cdn-api.pandascore.co/images/team/image/135214/226px_alter_ego_july2021_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/137353/190px_last_bullet_allmode.png'),
(21, 'cs2', 'ESL CHALLENGER LEAGUE', '18:06', 'CANLI', 'BMZ', '0 - 0', 'The QUBE Esports', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/138152/bmz_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/134069/c794.png'),
(22, 'cs2', 'CCT SOUTH AMERICA', '18:06', 'CANLI', 'Yawara Esports', '0 - 0', 'Alzon', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/131538/285px_yawara_esports_lightmode.png', '../img/varsayilan_logo.png'),
(23, 'cs2', 'EUROPEAN PRO LEAGUE', '17:47', 'CANLI', 'BIG Academy', '0 - 0', 'ReThink', 'Canlı Oynanıyor', 'https://cdn-api.pandascore.co/images/team/image/126694/big.png', 'https://cdn-api.pandascore.co/images/team/image/137967/re_think_lightmode.png'),
(24, 'lol', 'LCK CHALLENGERS LEAGUE', '14:58', 'MS', 'KT Rolster Challengers', '1 - 2', 'T1 Academy', 'Maç Sonu', 'https://cdn-api.pandascore.co/images/team/image/128348/800px_kt_rolster_2026_allmode.png', 'https://cdn-api.pandascore.co/images/team/image/131040/t1logo_profile.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `haberler`
--

CREATE TABLE `haberler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `ozet` text NOT NULL,
  `icerik` longtext NOT NULL,
  `platform` varchar(100) NOT NULL,
  `resim` varchar(255) NOT NULL,
  `kaynak_url` varchar(255) DEFAULT NULL,
  `kategori` varchar(100) DEFAULT 'Haber',
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `haberler`
--

INSERT INTO `haberler` (`id`, `baslik`, `ozet`, `icerik`, `platform`, `resim`, `kaynak_url`, `kategori`, `tarih`) VALUES
(3, 'NVIDIA RTX 5090 Sızdırıldı: 8K Oyunculukta Yeni Bir Standart!', 'Yeni nesil RTX 5090 ekran kartının teknik özellikleri ve tahmini çıkış tarihi donanım dünyasına bomba gibi düştü.', 'Donanım dünyasında heyecan yaratan yeni bir sızıntıya göre, NVIDIA\'nın amiral gemisi RTX 5090 modeli, önceki nesle göre (RTX 4090) tam %40 daha fazla saf güç sunacak. Yeni GDDR7 bellek teknolojisi ve 512-bit veri yolu ile gelmesi beklenen kartın, 8K çözünürlükte bile 60 FPS barajını rahatlıkla aşacağı konuşuluyor. Özellikle soğutma bloğunun yeniden tasarlandığı ve enerji verimliliği konusunda da ciddi adımlar atıldığı belirtiliyor.', 'NVİDİA', 'img/haberresim/1777394573_1776033053_nvidia.png', NULL, 'Haber', '2026-04-28 16:42:53'),
(4, 'Steam Yaz İndirimleri Tarihleri Belli Oldu: Cüzdanları Hazırlayın!', 'PC oyuncularının her yıl merakla beklediği, binlerce oyunun indirime gireceği Steam Yaz İndirimleri\'nin başlangıç tarihi sızdırıldı.', 'Valve\'in dijital oyun platformu Steam\'in en büyük kampanya dönemi olan Yaz İndirimleri\'ne çok az kaldı. Güvenilir kaynaklardan gelen bilgilere göre, devasa indirim festivali bu yıl 27 Haziran tarihinde başlayacak ve iki hafta sürecek. Özellikle AAA kalitesindeki yüksek bütçeli yapımların ve son dönemde popüler olan bağımsız (indie) oyunların %90\'a varan indirimlerle oyunculara sunulması bekleniyor. İstek listelerinizi şimdiden hazırlamakta fayda var.', 'STEAM', 'img/haberresim/1777394612_1776033138_steam.png', NULL, 'Haber', '2026-04-28 16:43:32'),
(5, 'PlayStation 5 Pro İçin Geri Sayım: Geliştirici Kitleri Dağıtıldı!', 'Sony\'nin uzun süredir dedikodusu yapılan ara nesil konsolu PS5 Pro\'nun oyun stüdyolarına gönderilmeye başlandığı doğrulandı.', 'Konsol savaşlarında vites büyüten Sony, PlayStation 5\'in gücünü katlayacak olan \'Pro\' versiyonu için son aşamaya geldi. Sektör içerisinden sızdırılan belgelere göre yeni konsol, özellikle ışın izleme (ray tracing) teknolojisinde devrim yaratacak ve 4K çözünürlükte 60 FPS standartını tavizsiz bir şekilde sunacak. Cihazın yıl sonu tatil döneminde piyasaya sürülmesi planlanıyor.', 'PLAYSTATİON', 'img/haberresim/1777394631_1776032876_1776032723_deabbf4669aa18f84573f6ea705664b4.webp', NULL, 'Haber', '2026-04-28 16:43:51'),
(6, 'Epic Games Store\'da \"Mega İndirim\" Fırtınası: 10 Ücretsiz Gizemli Oyun!', 'Epic Games, her yıl düzenlenen geleneksel indirim dönemini başlatırken, her gün bir adet gizemli oyunu ücretsiz vereceğini duyurdu.', 'Dijital oyun dünyasının en büyük rekabetlerinden birini sürdüren Epic Games Store, 2026 Mega İndirimleri ile oyuncuların karşısına çıktı. %25\'lik ekstra indirim kuponlarının yanı sıra, platformun simgesi haline gelen \"Gizemli Oyun\" kampanyası da start aldı. Sızdırılan bilgilere göre bu yıl verilecek oyunlar arasında son dönemin popüler AAA yapımlarının da yer alması bekleniyor. Ayrıca Epic Games, geliştiriciler için Unreal Engine 6\'nın kapalı beta sürecine dair ilk detayları da mağaza üzerinden paylaştı.', 'EPİC GAMES', 'img/haberresim/1777394955_1776033089_epicgames.png', NULL, 'Haber', '2026-04-28 16:49:15'),
(7, 'Riot Games\'in Sır Gibi Sakladığı MMORPG Projesinden İlk Detaylar Geldi!', 'League of Legends evreninde geçecek olan devasa çevrimiçi rol yapma oyunu için beklenen resmi açıklama nihayet yapıldı.', 'Yıllardır \"Project F\" kod adıyla anılan ve Runeterra evrenini keşfetmemize olanak tanıyacak Riot MMORPG projesi için sessizlik bozuldu. Riot Games yönetimi, oyunun grafik motorunun son halinden ilk görselleri paylaşarak, açık dünya mekaniklerinin derinliğini gözler önüne serdi. Oyunun, serinin diğer oyunlarıyla (LoL ve Valorant) entegre bir ödül sistemine sahip olacağı ve 2027 başında kapalı beta sürecine gireceği kesinleşti. Bu proje, Riot\'un \"yayıncı\" kimliğinden \"dünya kurucu\" kimliğine geçişindeki en büyük adım olarak görülüyor.', 'RİOT GAMES', 'img/haberresim/1777395116_riot.png', NULL, 'Haber', '2026-04-28 16:50:07'),
(8, 'Nintendo Switch 2 Sızıntıları: Geriye Uyumluluk Müjdesi!', 'Nintendo\'un yeni nesil konsolu Switch 2\'nin mevcut oyun kütüphanesini destekleyeceği ve DLSS teknolojisiyle geleceği konuşuluyor.', 'Nintendo cephesinden heyecan verici haberler gelmeye devam ediyor. Sektör içinden sızdırılan yeni raporlara göre, Switch 2 sadece donanım gücüyle değil, oyuncu dostu özellikleriyle de öne çıkacak. Mevcut Switch oyun kartuşlarının yeni konsolda çalışacağı ve NVIDIA\'nın DLSS 3.5 teknolojisi sayesinde 4K çözünürlükte akıcı bir deneyim sunulacağı belirtiliyor. Konsolun tanıtımının önümüzdeki mali yılın başında yapılması bekleniyor.', 'NİNTENDO', 'img/haberresim/1777397534_1776030772_nintendodanbeklenmedikhamle.png', NULL, 'Haber', '2026-04-28 17:32:14'),
(9, 'Assassin’s Creed Shadows: Feodal Japonya Kapıları Aralanıyor!', 'Ubisoft, merakla beklenen yeni Assassin\'s Creed oyununda oyuncuları samuray ve shinobi dünyasına davet ediyor.', 'Ubisoft\'un en ikonik serisi olan Assassin\'s Creed, Shadows ile hayranlarının yıllardır beklediği Japonya temasına geri dönüyor. İki farklı oynanabilir karakter (Samuray Yasuke ve Shinobi Naoe) sunan yapım, dinamik hava durumu ve mevsim geçişleri sistemine sahip olacak. Gizlilik mekaniklerinin modernize edildiği oyun, feodal Japonya\'nın büyüleyici atmosferini en ince ayrıntısına kadar yansıtmayı hedefliyor. Assassin\'s Creed Shadows, yıl sonunda tüm platformlar için çıkış yapacak.', 'UBİSOFT', 'img/haberresim/1777397551_1776030885_ubisoft.png', NULL, 'Haber', '2026-04-28 17:32:31'),
(10, 'EA Sports FC 25: Futbol Simülasyonunda Yeni Bir Dönem!', 'EA, yeni oyunuyla birlikte oyuncu rolleri ve taktiksel derinlikte devrim yaratmaya hazırlanıyor.', 'Electronic Arts, futbol dünyasının kalbinin attığı FC serisinin en yeni halkasını duyurdu. FC 25 ile birlikte gelen \"FC IQ\" sistemi, takımların sahadaki dizilişlerini ve oyuncuların özel rollerini yapay zeka yardımıyla çok daha gerçekçi bir şekilde yönetmenizi sağlayacak. Ayrıca yeni eklenen 5\'e 5 \"Rush\" modu, arkadaşlarınızla daha hızlı ve eğlenceli maçlar yapmanıza olanak tanıyacak. Oyun, Eylül ayı sonunda raflardaki yerini alacak.', 'EA GAMES', 'img/haberresim/1777397569_1776030841_ea.png', NULL, 'Haber', '2026-04-28 17:32:49'),
(11, 'Xbox Game Pass\'e Dev Eklemeler: Call of Duty Geliyor!', 'Microsoft, abonelik sistemini güçlendirmek adına ikonik serilerin Game Pass kütüphanesine ekleneceğini onayladı.', 'Xbox ve PC oyuncularının göz bebeği olan Game Pass hizmeti, tarihinin en büyük genişlemesine hazırlanıyor. Microsoft, Activision Blizzard satın alımı sonrası Call of Duty serisinin en yeni halkasının çıktığı ilk gün Game Pass kütüphanesine ekleneceğini resmi olarak duyurdu. Bu hamlenin abonelik sayılarını rekor seviyelere çıkarması beklenirken, bulut oyun sistemine yapılacak yatırımlarla her cihazda yüksek kaliteli oyun deneyimi hedefleniyor.', 'XBOX', 'img/haberresim/1777397587_1776177665_xboxt#U00fcmyollar#U0131kapatt#U0131.png', NULL, 'Haber', '2026-04-28 17:33:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `islem_loglari`
--

CREATE TABLE `islem_loglari` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `islem_tipi` varchar(100) NOT NULL,
  `islem_detay` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `islem_loglari`
--

INSERT INTO `islem_loglari` (`id`, `admin_id`, `islem_tipi`, `islem_detay`, `tarih`) VALUES
(1, 2, 'Kullanıcı Silme', 'Kullanıcı ID: 1 sistemden silindi.', '2026-04-28 13:11:48'),
(2, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: STEAM', '2026-04-28 13:12:49'),
(3, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: EPİC GAMES', '2026-04-28 13:13:21'),
(4, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: UBİSOFT', '2026-04-28 13:13:30'),
(5, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: EA GAMES', '2026-04-28 13:13:37'),
(6, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: RİOT GAMES', '2026-04-28 13:14:00'),
(7, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: XBOX', '2026-04-28 13:14:37'),
(8, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: PLAYSTATİON', '2026-04-28 13:15:00'),
(9, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: NİNTENDO', '2026-04-28 13:15:08'),
(10, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: NVİDİA', '2026-04-28 13:15:28'),
(11, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: AMD', '2026-04-28 13:15:34'),
(12, 2, 'Platform Ekleme', 'Yeni Kategori eklendi: INTEL', '2026-04-28 13:15:44'),
(13, 2, 'Oyun Ekleme', 'Yeni Oyun eklendi: VALORANT', '2026-04-28 13:16:20'),
(14, 2, 'İçerik Ekleme', 'Yeni Haber: EAAA', '2026-04-28 13:32:07'),
(15, 2, 'İçerik Ekleme', 'Yeni Haber: OVAL', '2026-04-28 13:32:44'),
(16, 2, 'Oyun Ekleme', 'Yeni Oyun eklendi: LEAGUE OF LEGENDS', '2026-04-28 13:47:02'),
(17, 2, 'Oyun Ekleme', 'Yeni Oyun eklendi: DOTA 2', '2026-04-28 13:48:49'),
(18, 2, 'Oyun Ekleme', 'Yeni Oyun eklendi: COUNTER - STRİKE 2', '2026-04-28 13:49:03'),
(19, 2, 'Haber Silme', 'Haber ID: 2 sistemden silindi.', '2026-04-28 16:38:04'),
(20, 2, 'Haber Silme', 'Haber ID: 1 sistemden silindi.', '2026-04-28 16:38:06'),
(21, 2, 'Haber Silme', 'Haber ID: 1 sistemden silindi.', '2026-04-28 16:42:53'),
(22, 2, 'İçerik Ekleme', 'Yeni Haber: NVIDIA RTX 5090 Sızdırıldı: 8K Oyunculukta Yeni Bir Standart!', '2026-04-28 16:42:53'),
(23, 2, 'Haber Silme', 'Haber ID: 1 sistemden silindi.', '2026-04-28 16:43:32'),
(24, 2, 'İçerik Ekleme', 'Yeni Haber: Steam Yaz İndirimleri Tarihleri Belli Oldu: Cüzdanları Hazırlayın!', '2026-04-28 16:43:32'),
(25, 2, 'Haber Silme', 'Haber ID: 1 sistemden silindi.', '2026-04-28 16:43:51'),
(26, 2, 'İçerik Ekleme', 'Yeni Haber: PlayStation 5 Pro İçin Geri Sayım: Geliştirici Kitleri Dağıtıldı!', '2026-04-28 16:43:51'),
(27, 2, 'Haber Silme', 'Haber ID: 1 sistemden silindi.', '2026-04-28 16:49:15'),
(28, 2, 'İçerik Ekleme', 'Yeni Haber: Epic Games Store\'da \"Mega İndirim\" Fırtınası: 10 Ücretsiz Gizemli Oyun!', '2026-04-28 16:49:15'),
(29, 2, 'Haber Silme', 'Haber ID: 1 sistemden silindi.', '2026-04-28 16:50:07'),
(30, 2, 'İçerik Ekleme', 'Yeni Haber: Riot Games\'in Sır Gibi Sakladığı MMORPG Projesinden İlk Detaylar Geldi!', '2026-04-28 16:50:07'),
(31, 2, 'İçerik Düzenleme', 'İçerik ID: 7 güncellendi.', '2026-04-28 16:51:56'),
(32, 2, 'İçerik Ekleme', 'Yeni Haber: Nintendo Switch 2 Sızıntıları: Geriye Uyumluluk Müjdesi!', '2026-04-28 17:32:14'),
(33, 2, 'İçerik Ekleme', 'Yeni Haber: Assassin’s Creed Shadows: Feodal Japonya Kapıları Aralanıyor!', '2026-04-28 17:32:31'),
(34, 2, 'İçerik Ekleme', 'Yeni Haber: EA Sports FC 25: Futbol Simülasyonunda Yeni Bir Dönem!', '2026-04-28 17:32:49'),
(35, 2, 'İçerik Ekleme', 'Yeni Haber: Xbox Game Pass\'e Dev Eklemeler: Call of Duty Geliyor!', '2026-04-28 17:33:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(100) NOT NULL,
  `eposta` varchar(100) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` varchar(50) NOT NULL DEFAULT 'kullanici',
  `kayit_tarihi` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `eposta`, `sifre`, `rol`, `kayit_tarihi`) VALUES
(2, 'admin1', 'admin@gasmeportal.com', '$2y$10$idUNa4c.lVU0MH4oLGjKRu9MFVugNsAoD87i2zmnKLZIKANHHZYvW', 'admin', '2026-04-28 13:11:27');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `oyunlar`
--

CREATE TABLE `oyunlar` (
  `id` int(11) NOT NULL,
  `isim` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT 'default.png'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `oyunlar`
--

INSERT INTO `oyunlar` (`id`, `isim`, `logo`) VALUES
(1, 'VALORANT', 'valorant.png'),
(2, 'LEAGUE OF LEGENDS', 'lol.png'),
(3, 'DOTA 2', 'dota2.png'),
(4, 'COUNTER - STRİKE 2', 'cs2.png');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `platformlar`
--

CREATE TABLE `platformlar` (
  `id` int(11) NOT NULL,
  `isim` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT 'default.png',
  `kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `platformlar`
--

INSERT INTO `platformlar` (`id`, `isim`, `logo`, `kategori`) VALUES
(1, 'STEAM', 'steam.png', 'Platform'),
(2, 'EPİC GAMES', 'epic.png', 'Platform'),
(3, 'UBİSOFT', 'ubisoft.png', 'Platform'),
(4, 'EA GAMES', 'ea.png', 'Platform'),
(5, 'RİOT GAMES', 'riot.png', 'Platform'),
(6, 'XBOX', 'xbox.png', 'Platform'),
(7, 'PLAYSTATİON', 'ps.png', 'Platform'),
(8, 'NİNTENDO', 'nintendo.png', 'Platform'),
(9, 'NVİDİA', 'nvidia.png', 'Üretici'),
(10, 'AMD', 'amd.png', 'Üretici'),
(11, 'INTEL', 'intel.png', 'Üretici');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `takimlar`
--

CREATE TABLE `takimlar` (
  `id` int(11) NOT NULL,
  `takim_adi` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `haber_id` int(11) NOT NULL,
  `yazan_kisi` varchar(100) NOT NULL,
  `yorum` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `canli_skor`
--
ALTER TABLE `canli_skor`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `haberler`
--
ALTER TABLE `haberler`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `islem_loglari`
--
ALTER TABLE `islem_loglari`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `oyunlar`
--
ALTER TABLE `oyunlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `platformlar`
--
ALTER TABLE `platformlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `takimlar`
--
ALTER TABLE `takimlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `yorumlar`
--
ALTER TABLE `yorumlar`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `canli_skor`
--
ALTER TABLE `canli_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Tablo için AUTO_INCREMENT değeri `haberler`
--
ALTER TABLE `haberler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `islem_loglari`
--
ALTER TABLE `islem_loglari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `oyunlar`
--
ALTER TABLE `oyunlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `platformlar`
--
ALTER TABLE `platformlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Tablo için AUTO_INCREMENT değeri `takimlar`
--
ALTER TABLE `takimlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
