# 🎮 Oyun Dünyası Haber & İçerik Portalı

Oyun dünyasındaki en güncel gelişmeleri, yeni çıkan yapımları ve sektör haberlerini tek bir platformda toplayan modern bir içerik portalıdır.

## 📌 Proje Açıklaması
Bu proje, kullanıcıların sadece haber okumakla kalmayıp, yaklaşan oyunların çıkış tarihlerini takip edebilecekleri ve kendi aralarında fikir alışverişi yapabilecekleri interaktif bir yapı sunar. Büyük ve küçük ölçekli tüm güncellemeler anlık olarak platformda yer alır.

## 👥 Hedef Kullanıcılar
| Kullanıcı Grubu | Odak Noktası |
| :--- | :--- |
| **🕹️ Sıkı Oyuncular** | Yama notları ve rekabetçi oyun güncellemelerini anlık takip edenler. |
| **🔍 Takipçiler** | Yeni çıkacak oyunları ve sistem gereksinimlerini merak eden kitle. |
| **💼 Sektör Meraklıları** | İş alımları, stüdyo satın almaları ve teknolojik gelişmeleri izleyenler. |

## 🚀 Temel Özellikler
* **📰 Haber Akışı:** Kategorize edilmiş (PC, Konsol, Mobil, E-spor) güncel haberler.
* **📅 Güncelleme Takvimi:** Popüler oyun yamalarının özetleri ve tarihleri.
* **⏳ Gelecek Oyunlar:** Beklenen büyük yapımlar için geri sayım ve çıkış takvimi.
* **⚡ Filtreleme Sistemi:** İlgi alanına göre (platform/tür) özelleştirilmiş haber akışı.
* **💬 Yorum ve Etkileşim:** Haberler hakkında fikir yürütülebilecek tartışma alanı.

## 🛠️ Kullanılan Teknolojiler
![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white)
![CSS3](https://img.shields.io/badge/css3-%231572B6.svg?style=for-the-badge&logo=css3&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23F7DF1E.svg?style=for-the-badge&logo=javascript&logoColor=black)
![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/mysql-%2300f.svg?style=for-the-badge&logo=mysql&logoColor=white)
<<<<<<< HEAD

"BU SİTE MERT DOGAN TARAFINDAN YAPILMIŞTIR"

--- DOSYA YAPISI ---

gameportal/
├── index.php                 ← Ana Sayfa (Hero slider ve haber listesi)
├── README.md                 ← Bu dosya (Proje açıklamaları ve dökümantasyon)
│
├── pages/                    ← Tüm Alt Sayfalar
│   ├── canli-skor.php        ← Canlı Skor Listesi ve Maç Filtrelemeleri
│   ├── espor.php             ← E-Spor Arenası (Haberler ve Günün Maçları widget'ı)
│   ├── haber-detay.php       ← Haberin Tamamının ve Yorumların Okunduğu Sayfa
│   ├── hmkategoriler.php     ← Mobil Cihazlar İçin Kategori/Platform Seçim Menüsü
│   └── platform.php          ← Sadece Seçilen Markaya/Platforma Ait Haberler
│
├── assets/                   ← CSS ve JS Kaynakları
│   ├── style.css             ← Tüm Stiller (Renkler, animasyonlar, UI, responsive)
│   └── script.js             ← Ana JavaScript (Menüler, filtreler, slider, AJAX, animasyonlar)
│
├── img/                      ← Tüm Görsel Arşivi
│   ├── canliskorkartlar/     ← Canlı skor sayfasındaki kayan oyun kartı resimleri
│   ├── canliskorlogolar/     ← Oyunlara ait minik logolar (CS2, LoL, Valorant vb.)
│   ├── haberresim/           ← Admin panelinden yüklenen haber kapak görselleri
│   ├── logolar/              ← Marka/Platform logoları (Steam, Xbox, PS vb.)
│   └── takimlogolar/         ← E-Spor takımlarının isimlerine göre eşleşen takım logoları
│
├── sql/                      ← Veritabanı Dosyaları
│   └── gameportal_db.sql     ← Veritabanı kurulum, tablo ve yedek (Export) dosyası
│
├── php/                      ← (NOT: Mevcut yapıda ana dizinde, dilersen bir klasöre toplayabilirsin)
│   ├── admin.php             ← Süper Admin Kontrol Paneli (Tüm içerik/veri yönetimi)
│   ├── baglan.php            ← Veritabanı Bağlantı (PDO) Ayarları (Ana damar)
│   ├── header.php            ← Üst Menü (Navigasyon) ve Oturum Arayüzü (Her sayfada çağrılır)
│   ├── modal.php             ← Giriş Yap / Kayıt Ol / Profil Popup (Modal) Sistemi
│   ├── skor_bot.php          ← PandaScore API Canlı Skor Çekme ve Ekleme Botu (CronJob)
│   ├── api.php               ← Haberleri Veritabanından JSON Olarak Çeken Servis
│   ├── api_skor.php          ← Maçları Veritabanından JSON Olarak Çeken Servis
│   ├── ajax_haber_detay.php  ← Haber Detayını JavaScript'e Aktaran AJAX İşlemcisi
│   ├── ajax_kayit.php        ← Yeni Üye Kayıt AJAX POST İşlemcisi
│   ├── ajax_login.php        ← Üye Girişi AJAX POST İşlemcisi
│   ├── ajax_session.php      ← Kullanıcının Oturum Durumunu Kontrol Eden İşlemci
│   ├── ajax_sifre_degistir.php ← Profil Üzerinden Şifre Güncelleme AJAX İşlemcisi
│   ├── ajax_yorum.php        ← Yorum Ekleme ve Okuma AJAX İşlemcisi
│   └── cikis.php             ← Kullanıcı Oturumunu Sonlandırma (Logout) Yönlendirmesi