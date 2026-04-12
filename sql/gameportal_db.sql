-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 13 Nis 2026, 00:33:16
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
  `oyun` varchar(50) NOT NULL COMMENT 'cs2, valorant, lol, dota',
  `lig` varchar(255) NOT NULL,
  `saat` varchar(20) NOT NULL,
  `durum` varchar(50) NOT NULL COMMENT 'CANLI, MS, BAŞLAMADI',
  `ev_sahibi` varchar(100) NOT NULL,
  `skor` varchar(20) NOT NULL,
  `deplasman` varchar(100) NOT NULL,
  `periyot` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `canli_skor`
--

INSERT INTO `canli_skor` (`id`, `oyun`, `lig`, `saat`, `durum`, `ev_sahibi`, `skor`, `deplasman`, `periyot`) VALUES
(3, 'cs2', 'VCT EMEA 2026', '19:00', 'MS', 'araba esports', '3 - 0', 'ev esports', ''),
(4, 'valorant', 'VCT EMEA 2026', '20:00', 'CANLI', 'BBL Esports', '1 - 1', 'FUT Esports', ''),
(9, 'lol', 'VCT EMEA 2027', '22:00', 'MS', 'BBL Esports', '4 - 2', 'FUT Esports', '1. Yarı'),
(10, 'dota', 'VCT EMEA 2026', '23:00', 'CANLI', 'BBL Esports', '3 - 0', 'FUT Esports', '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `haberler`
--

CREATE TABLE `haberler` (
  `id` int(11) NOT NULL,
  `baslik` varchar(255) NOT NULL,
  `ozet` text NOT NULL,
  `icerik` longtext NOT NULL,
  `kaynak_url` varchar(255) DEFAULT NULL,
  `platform` varchar(100) NOT NULL,
  `resim` varchar(500) NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `haberler`
--

INSERT INTO `haberler` (`id`, `baslik`, `ozet`, `icerik`, `kaynak_url`, `platform`, `resim`, `tarih`) VALUES
(1, 'Steam Yaz İndirimleri Başlıyor', 'Cüzdanları hazırlayın, devasa indirimler kapıda!', '<p>Steam yaz indirimleri bu yıl çok daha büyük oranlarla geliyor. Birçok AAA oyunda %80 e varan indirimler bekleniyor...</p>', NULL, 'Steam', 'img/haberresim/1776033138_steam.png', '2026-04-12 13:53:25'),
(2, 'Epic Games Ücretsiz Oyun Yağmuru', 'Bu hafta Epic Games Store da kaçırmamanız gereken fırsatlar.', '<p>Epic Games bu hafta sürpriz bir şekilde 3 farklı AAA oyunu tamamen ücretsiz olarak kütüphanelere ekleme fırsatı sunuyor...</p>', NULL, 'Epic Games', 'img/haberresim/1776033089_epicgames.png', '2026-04-12 13:53:25'),
(3, 'Nvidia RTX 5090 Sızıntıları Başladı', 'Yeni nesil ekran kartı hakkında teknik detaylar.', '<p>Donanım dünyasını sarsacak olan RTX 5090 modelinin ilk benchmark testleri sızdırıldı. Kartın performansı beklentilerin çok üzerinde...</p>', NULL, 'Nvidia', 'img/haberresim/1776033053_nvidia.png', '2026-04-12 13:53:25'),
(7, 'Xbox\'dan Beklenmedik Hamle', 'Xbox\'dan Beklenmedik Hamle', 'Xbox\'dan Beklenmedik Hamle', NULL, 'Xbox', 'img/haberresim/1776033000_xboxtümyollarıkapattı.png', '2026-04-12 18:07:24'),
(8, 'PS\'den Beklenmedik Hamle', 'PS\'den Beklenmedik Hamle', 'PS\'den Beklenmedik Hamle', NULL, 'PS', 'img/haberresim/1776032876_1776032723_deabbf4669aa18f84573f6ea705664b4.webp', '2026-04-12 18:07:39'),
(10, 'Nintendo\'dan Beklenmedik Hamle', 'Nintendo\'dan Beklenmedik Hamle', 'Nintendo\'dan Beklenmedik HamleNintendo\'dan Beklenmedik HamleNintendo\'dan Beklenmedik Hamle', NULL, 'Nintendo', 'img/haberresim/1776030772_nintendodanbeklenmedikhamle.png', '2026-04-12 21:52:52'),
(11, 'EA Games\'den Beklenmedik Hamle', 'EA Games\'den Beklenmedik Hamle', 'EA Games\'den Beklenmedik HamleEA Games\'den Beklenmedik HamleEA Games\'den Beklenmedik Hamle', NULL, 'EA Games', 'img/haberresim/1776030841_ea.png', '2026-04-12 21:54:01'),
(12, 'Ubisoft\'tan Beklenmedik Hamle', 'Ubisoft\'tan Beklenmedik Hamle', 'Ubisoft\'tan Beklenmedik HamleUbisoft\'tan Beklenmedik HamleUbisoft\'tan Beklenmedik Hamle', NULL, 'Ubisoft', 'img/haberresim/1776030885_ubisoft.png', '2026-04-12 21:54:45'),
(13, 'AMD\'den Beklenmedik Hamle', 'AMD\'den Beklenmedik Hamle', 'AMD\'den Beklenmedik HamleAMD\'den Beklenmedik HamleAMD\'den Beklenmedik Hamle', NULL, 'AMD', 'img/haberresim/1776030952_amd.png', '2026-04-12 21:55:52'),
(14, 'Intel\'den Beklenmedik Hamle', 'Intel\'den Beklenmedik Hamle', 'Intel\'den Beklenmedik HamleIntel\'den Beklenmedik HamleIntel\'den Beklenmedik Hamle', NULL, 'Intel', 'img/haberresim/1776030999_intel.png', '2026-04-12 21:56:39');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `islem_loglari`
--

CREATE TABLE `islem_loglari` (
  `id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `islem_tipi` varchar(50) NOT NULL,
  `islem_detay` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `islem_loglari`
--

INSERT INTO `islem_loglari` (`id`, `admin_id`, `islem_tipi`, `islem_detay`, `tarih`) VALUES
(1, 4, 'Kullanıcı Ekleme', 'Yeni kullanici: emre', '2026-04-12 17:20:22'),
(2, 4, 'Kullanıcı Silme', 'Kullanıcı ID: 5 sistemden silindi.', '2026-04-12 17:21:48'),
(3, 4, 'Skor Silme', 'Skor ID: 2 fikstürden silindi.', '2026-04-12 17:24:10'),
(4, 1, 'Haber Ekleme', 'Yeni Haber: Xbox\'dan Beklenmedik Hamle', '2026-04-12 18:07:24'),
(5, 1, 'Haber Ekleme', 'Yeni Haber: PS\'den Beklenmedik Hamle', '2026-04-12 18:07:39'),
(6, 1, 'Skor Ekleme', 'Yeni Maç: araba esports vs ev esports', '2026-04-12 18:08:52'),
(7, 1, 'Skor Ekleme', 'Yeni Maç: BBL Esports vs FUT Esports', '2026-04-12 18:09:12'),
(8, 1, 'Skor Ekleme', 'Yeni Maç: DWADA vs WADW', '2026-04-12 18:10:54'),
(9, 1, 'Skor Ekleme', 'Yeni Maç: DWADA vs WADW', '2026-04-12 18:17:15'),
(10, 1, 'Skor Ekleme', 'Yeni Maç: DWADA vs WADW', '2026-04-12 18:17:16'),
(11, 1, 'Skor Ekleme', 'Yeni Maç: DWADA vs WADW', '2026-04-12 18:17:18'),
(12, 1, 'Skor Ekleme', 'Yeni Maç: BBL Esports vs FUT Esports', '2026-04-12 18:17:48'),
(13, 1, 'Skor Silme', 'Skor ID: 8 fikstürden silindi.', '2026-04-12 18:26:26'),
(14, 1, 'Skor Silme', 'Skor ID: 7 fikstürden silindi.', '2026-04-12 18:26:28'),
(15, 1, 'Skor Silme', 'Skor ID: 5 fikstürden silindi.', '2026-04-12 18:26:30'),
(16, 1, 'Skor Silme', 'Skor ID: 6 fikstürden silindi.', '2026-04-12 18:26:33'),
(17, 1, 'Skor Silme', 'Skor ID: 6 fikstürden silindi.', '2026-04-12 18:27:08'),
(18, 1, 'Skor Ekleme', 'Yeni Maç: BBL Esports vs FUT Esports', '2026-04-12 18:27:08'),
(19, 1, 'Skor Düzenleme', 'Maç ID: 9 güncellendi.', '2026-04-12 18:27:44'),
(20, 1, 'Skor Düzenleme', 'Maç ID: 9 güncellendi.', '2026-04-12 18:27:55'),
(21, 1, 'Skor Düzenleme', 'Maç ID: 9 güncellendi.', '2026-04-12 18:31:52'),
(22, 1, 'Haber Ekleme', 'Yeni Haber: Yusuf\'u Götten Siktim', '2026-04-12 21:09:31'),
(23, 1, 'Haber Silme', 'Haber ID: 9 sistemden silindi.', '2026-04-12 21:10:04'),
(24, 1, 'Haber Ekleme', 'Yeni Haber: Nintendo\'dan Beklenmedik Hamle', '2026-04-12 21:52:52'),
(25, 1, 'Haber Ekleme', 'Yeni Haber: EA Games\'den Beklenmedik Hamle', '2026-04-12 21:54:01'),
(26, 1, 'Haber Ekleme', 'Yeni Haber: Ubisoft\'tan Beklenmedik Hamle', '2026-04-12 21:54:45'),
(27, 1, 'Haber Ekleme', 'Yeni Haber: AMD\'den Beklenmedik Hamle', '2026-04-12 21:55:52'),
(28, 1, 'Haber Ekleme', 'Yeni Haber: Intel\'den Beklenmedik Hamle', '2026-04-12 21:56:39'),
(29, 1, 'Haber Düzenleme', 'Haber ID: 8 güncellendi.', '2026-04-12 22:25:23'),
(30, 1, 'Haber Düzenleme', 'Haber ID: 8 güncellendi.', '2026-04-12 22:27:56'),
(31, 1, 'Haber Düzenleme', 'Haber ID: 7 güncellendi.', '2026-04-12 22:30:00'),
(32, 1, 'Haber Düzenleme', 'Haber ID: 3 güncellendi.', '2026-04-12 22:30:53'),
(33, 1, 'Haber Düzenleme', 'Haber ID: 2 güncellendi.', '2026-04-12 22:31:29'),
(34, 1, 'Haber Düzenleme', 'Haber ID: 1 güncellendi.', '2026-04-12 22:32:18');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `id` int(11) NOT NULL,
  `kullanici_adi` varchar(50) NOT NULL,
  `sifre` varchar(255) NOT NULL,
  `rol` varchar(20) NOT NULL DEFAULT 'kullanici'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `kullanici_adi`, `sifre`, `rol`) VALUES
(1, 'sadecedqn', '$2y$10$/7Rs82lIzCrl7cfw.jiEReAm2Dz9w43Y/MAoFXFgRz6CGZJsWlcaK', 'admin'),
(2, 'adagoksen', '$2y$10$krekdCkoIK1XihVoV2yeNOawwh2ynm/i8Z8vgXZkB.lz8qDuzgs6C', 'kullanici'),
(4, 'mert', '$2y$10$akA74mWj1Hs/S.fuJjJ3FugMUc/JSOuB7Cw4VCqWfXkZJv1xdxeeK', 'admin');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yorumlar`
--

CREATE TABLE `yorumlar` (
  `id` int(11) NOT NULL,
  `haber_id` int(11) NOT NULL,
  `yazan_kisi` varchar(50) NOT NULL,
  `yorum` text NOT NULL,
  `tarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kullanici_adi` (`kullanici_adi`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `haberler`
--
ALTER TABLE `haberler`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Tablo için AUTO_INCREMENT değeri `islem_loglari`
--
ALTER TABLE `islem_loglari`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `yorumlar`
--
ALTER TABLE `yorumlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
