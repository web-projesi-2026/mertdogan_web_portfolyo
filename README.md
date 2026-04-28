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


"BU SİTE MERT DOGAN TARAFINDAN YAPILMIŞTIR"

--- DOSYA YAPISI ---

``` gameportal/
├── index.php                   <- Ana Sayfa
├── README.md                   <- Bu dosya
│
├── pages/                      <- Alt Sayfalar
│   ├── canli-skor.php          <- Canlı Skor sayfası
│   ├── espor.php               <- E-Spor fikstür ve haberleri
│   ├── favoriler.php           <- Kullanıcıya özel favori haberler listesi
│   ├── haber-detay.php         <- Seçilen haberin detay ve okuma sayfası
│   ├── hmkategoriler.php       <- Mobil/Mega menü platformlar ve üreticiler arayüzü
│   ├── hmoyunlar.php           <- Mobil/Mega menü oyunlar arayüzü
│   ├── kategori.php            <- Genel haber kategori listeleme sayfası
│   └── platform.php            <- Seçilen platforma özel (ör. Steam) haber filtreleme sayfası
│
├── assets/
│   ├── style.css               <- Tüm stiller (UI, butonlar, animasyonlar)
│   └── script.js               <- Ana JavaScript (DOM işlemleri, favori/takip, API istekleri)
│
├── img/                        <- Görseller
│   ├── canliskorkartlar/       <- Canlı skor panosunda kullanılan kart arka planları
│   ├── canliskorlogolar/       <- Skor sayfasındaki oyun ikonları (CS2, LoL vb.)
│   ├── haberresim/             <- Haberlerin ana kapak görselleri
│   ├── logolar/                <- Platform ve üretici logoları (Steam, Riot, Epic vb.)
│   └── takimlogolar/           <- E-spor takımlarının logoları
│
├── sql/
│   └── gameportal_db.sql       <- Veritabanı kurulum ve tablo oluşturma sorgusu
│
├── ajax_... (API ve İstekler)  <- Asenkron Arka Plan İşlemleri
│   ├── ajax_haber_detay.php    <- Haber içeriğini veritabanından çekme servisi
│   ├── ajax_kayit.php          <- Yeni kullanıcı kayıt işlemi (POST)
│   ├── ajax_login.php          <- Kullanıcı giriş kontrol işlemi (POST)
│   ├── ajax_session.php        <- Aktif oturum ve yetki kontrolü
│   ├── ajax_sifre_degistir.php <- Kullanıcı şifre güncelleme servisi
│   └── ajax_yorum.php          <- Haberlere yorum ekleme ve okuma servisi
│
└── PHP ve Ayar Dosyaları       <- Temel Sistem Bileşenleri
    ├── admin.php               <- Haber/İçerik ekleme yönetim paneli arayüzü
    ├── api.php                 <- Haberleri JSON formatında frontend'e sunan servis
    ├── api_skor.php            <- Canlı skorları JSON formatında sunan servis
    ├── baglan.php              <- Veritabanı (PDO) bağlantı dosyası
    ├── cikis.php               <- Oturum kapatma işlemi (Logout)
    ├── gizli_ayarlar.php       <- Veritabanı şifreleri ve çevresel (ENV) değişkenler
    ├── header.php              <- Tüm sayfalarda ortak kullanılan üst menü ve navigasyon
    ├── modal.php               <- Giriş, kayıt ve profil pop-up (modal) bileşenleri
    └── skor_bot.php            <- Otomatik maç sonuçlarını güncelleyen arka plan botu ```