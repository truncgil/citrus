# Trunçgil - Modern & Multipurpose Tailwind CSS Template

Modern ve çok amaçlı bir HTML template koleksiyonu. Tailwind CSS kullanılarak geliştirilmiş, profesyonel ve responsive web siteleri için hazır bir şablon setidir.

## 📋 İçindekiler

- [Özellikler](#-özellikler)
- [Demo Sayfaları](#-demo-sayfaları)
- [Kurulum](#-kurulum)
- [Yapı](#-yapı)
- [Renk Şemaları](#-renk-şemaları)
- [Yazı Tipleri](#-yazı-tipleri)
- [Kullanım](#-kullanım)
- [Dokümantasyon](#-dokümantasyon)
- [Lisans](#-lisans)

## ✨ Özellikler

- 🎨 **Modern Tasarım**: Güncel ve profesyonel tasarım anlayışı
- 📱 **Tam Responsive**: Tüm cihazlarda mükemmel görünüm
- 🎯 **Çok Amaçlı**: Kurumsal, e-ticaret, blog, portfolio ve daha fazlası
- ⚡ **Hızlı**: Optimize edilmiş kod ve performans
- 🎭 **10 Farklı Renk Şeması**: Kolayca değiştirilebilir tema renkleri
- 🔤 **4 Farklı Yazı Tipi**: Space Grotesk, THICCCBOI, Urbanist, DM
- 🧩 **Hazır Bloklar**: Kolayca kullanılabilir UI bileşenleri
- 📦 **Zengin İçerik**: 34 demo sayfası, blog, portfolio, e-ticaret ve daha fazlası

## 🎨 Demo Sayfaları

### Ana Sayfalar
- `index.html` - Ana sayfa (Space Grotesk, Grape)
- `onepage.html` - Tek sayfa versiyonu
- `page-loader.html` - Yükleme animasyonlu sayfa

### Demo Sayfaları (34 Adet)
- `demo1.html` - demo34.html arası çeşitli tasarım seçenekleri
- Farklı yazı tipleri, renk şemaları ve düzenler

### Blog Sayfaları
- `blog.html`, `blog2.html`, `blog3.html` - Blog listesi sayfaları
- `blog-post.html`, `blog-post2.html`, `blog-post3.html` - Blog detay sayfaları

### Portfolio Sayfaları
- `projects.html`, `projects2.html`, `projects3.html`, `projects4.html` - Proje listesi
- `single-project.html`, `single-project2.html`, `single-project3.html`, `single-project4.html` - Proje detay

### Hizmet Sayfaları
- `services.html`, `services2.html` - Hizmet sayfaları

### Hakkında Sayfaları
- `about.html`, `about2.html` - Hakkında sayfaları

### İletişim Sayfaları
- `contact.html`, `contact2.html`, `contact3.html` - İletişim formları

### Kariyer Sayfaları
- `career.html`, `career2.html` - Kariyer sayfaları
- `career-job.html` - İş ilanı detay

### E-Ticaret Sayfaları
- `shop.html`, `shop2.html` - Ürün listesi
- `shop-product.html` - Ürün detay
- `shop-cart.html` - Sepet
- `shop-checkout.html` - Ödeme

### Fiyatlandırma
- `pricing.html` - Fiyatlandırma tabloları

### Kimlik Doğrulama
- `signin.html`, `signin2.html` - Giriş sayfaları
- `signup.html`, `signup2.html` - Kayıt sayfaları

### Diğer Sayfalar
- `404.html` - Hata sayfası
- `terms.html` - Kullanım koşulları

## 🚀 Kurulum

### Gereksinimler
- Modern bir web tarayıcı
- (Opsiyonel) Yerel sunucu (Live Server, XAMPP, WAMP, vb.)

### Adımlar

1. **Projeyi İndirin**
   ```bash
   git clone <repository-url>
   cd templates
   ```

2. **Dosyaları Açın**
   - Doğrudan tarayıcıda `index.html` dosyasını açabilirsiniz
   - Veya yerel sunucu kullanarak çalıştırabilirsiniz

3. **Yerel Sunucu ile Çalıştırma** (Önerilen)
   ```bash
   # Python ile
   python -m http.server 8000
   
   # Node.js ile (http-server)
   npx http-server
   
   # PHP ile
   php -S localhost:8000
   ```

4. **Tarayıcıda Açın**
   - `http://localhost:8000` adresine gidin

## 📁 Yapı

```
templates/
├── assets/
│   ├── css/
│   │   ├── colors/          # 10 farklı renk şeması
│   │   │   ├── aqua.css
│   │   │   ├── grape.css
│   │   │   ├── leaf.css
│   │   │   ├── navy.css
│   │   │   ├── orange.css
│   │   │   ├── pink.css
│   │   │   ├── purple.css
│   │   │   ├── sky.css
│   │   │   ├── violet.css
│   │   │   └── yellow.css
│   │   ├── fonts/           # Yazı tipi tanımlamaları
│   │   │   ├── dm.css
│   │   │   ├── space.css
│   │   │   ├── thicccboi.css
│   │   │   └── urbanist.css
│   │   ├── icon.css
│   │   └── plugins.css
│   ├── fonts/               # Web fontları
│   │   ├── custom/
│   │   ├── space/
│   │   ├── thicccboi/
│   │   ├── unicons/
│   │   └── urbanist/
│   ├── img/                 # Görseller
│   │   ├── avatars/
│   │   ├── brands/
│   │   ├── demos/
│   │   ├── docs/
│   │   ├── icons/
│   │   ├── illustrations/
│   │   ├── photos/
│   │   └── svg/
│   ├── js/
│   │   ├── plugins.js
│   │   └── theme.js
│   └── media/               # Video ve medya dosyaları
├── docs/                    # Dokümantasyon
│   ├── blocks/             # Hazır bloklar
│   ├── elements/           # UI elementleri
│   ├── styleguide/         # Stil kılavuzu
│   ├── blog-post.html
│   ├── changelog.html
│   ├── credits.html
│   ├── faq.html
│   └── forms.html
├── *.html                  # Ana sayfa dosyaları
├── style.css              # Ana stil dosyası
└── README.md              # Bu dosya
```

## 🎨 Renk Şemaları

Template, 10 farklı renk şeması ile gelir:

1. **Aqua** - Mavi tonları
2. **Grape** - Mor tonları
3. **Leaf** - Yeşil tonları
4. **Navy** - Lacivert tonları
5. **Orange** - Turuncu tonları
6. **Pink** - Pembe tonları
7. **Purple** - Mor tonları
8. **Sky** - Açık mavi tonları
9. **Violet** - Eflatun tonları
10. **Yellow** - Sarı tonları

### Renk Şeması Değiştirme

HTML dosyasının `<head>` bölümünde renk şemasını değiştirebilirsiniz:

```html
<!-- Mevcut -->
<link rel="stylesheet" href="../assets/css/colors/grape.css">

<!-- Yeni renk şeması -->
<link rel="stylesheet" href="../assets/css/colors/aqua.css">
```

## 🔤 Yazı Tipleri

Template, 4 farklı yazı tipi seçeneği sunar:

1. **Space Grotesk** - Modern ve okunabilir
2. **THICCCBOI** - Kalın ve dikkat çekici
3. **Urbanist** - Şehirli ve profesyonel
4. **DM** - Minimal ve şık

### Yazı Tipi Değiştirme

HTML dosyasının `<head>` bölümünde yazı tipini değiştirebilirsiniz:

```html
<!-- Mevcut -->
<link rel="stylesheet" type="text/css" href="../assets/css/fonts/space.css">

<!-- Yeni yazı tipi -->
<link rel="stylesheet" type="text/css" href="../assets/css/fonts/thicccboi.css">
```

Ve `<body>` etiketine font sınıfı ekleyin:

```html
<body class="font-THICCCBOI">
```

## 💻 Kullanım

### 1. Sayfa Oluşturma

Mevcut demo sayfalarından birini kopyalayarak başlayabilirsiniz:

```bash
cp demo1.html yeni-sayfa.html
```

### 2. İçerik Düzenleme

HTML dosyasını düzenleyerek:
- Başlıkları değiştirin
- Metinleri güncelleyin
- Görselleri değiştirin
- Renk şemasını seçin

### 3. Hazır Blokları Kullanma

`docs/blocks/` klasöründeki hazır blokları sayfalarınıza ekleyebilirsiniz:
- Hero bölümleri
- Özellikler
- Testimonials
- Pricing
- FAQ
- Footer
- vb.

### 4. UI Elementlerini Keşfetme

`docs/elements/` klasöründe tüm UI elementlerini bulabilirsiniz:
- Butonlar
- Form elemanları
- Kartlar
- Modals
- Tabs
- Accordion
- vb.

## 📚 Dokümantasyon

Detaylı dokümantasyon için:

- `docs/index.html` - Genel bakış
- `docs/changelog.html` - Değişiklik geçmişi
- `docs/credits.html` - Krediler ve kaynaklar
- `docs/faq.html` - Sık sorulan sorular
- `docs/styleguide/` - Kapsamlı stil kılavuzu

### Hazır Bloklar

`docs/blocks/` klasöründe kullanıma hazır bölümler:
- `about.html` - Hakkında bölümleri
- `blog.html` - Blog bölümleri
- `call-to-action.html` - CTA bölümleri
- `clients.html` - Müşteri logoları
- `contact.html` - İletişim formları
- `facts.html` - İstatistikler
- `faq.html` - SSS bölümleri
- `features.html` - Özellikler
- `footer.html` - Footer şablonları
- `hero.html` - Hero bölümleri
- `misc.html` - Çeşitli bölümler
- `navbar.html` - Navigasyon menüleri
- `portfolio.html` - Portfolio galerileri
- `pricing.html` - Fiyatlandırma tabloları
- `process.html` - Süreç adımları
- `team.html` - Takım üyeleri
- `testimonials.html` - Müşteri yorumları

### UI Elementleri

`docs/elements/` klasöründe detaylı örnekler:
- Accordion, Alerts, Animations
- Avatars, Backgrounds, Badges
- Buttons, Cards, Carousels
- Dividers, Form Elements
- Image Hover, Image Mask
- Lightbox, Modal, Pagination
- Player, Progressbar, Shadows
- Shapes, Tables, Tabs
- Text Animations, Tooltips
- Typography ve daha fazlası

## 🎯 Özelleştirme İpuçları

### Logo Değiştirme

```html
<a href='index.html'>
  <img src="../assets/img/logo-dark.png" alt="Logo">
</a>
```

### Favicon Değiştirme

```html
<link rel="shortcut icon" href="../assets/img/favicon.png">
```

### Meta Bilgileri

```html
<meta name="description" content="Sitenizin açıklaması">
<meta name="keywords" content="anahtar, kelimeler">
<meta name="author" content="Yazar Adı">
<title>Sayfa Başlığı</title>
```

## 🌐 Tarayıcı Desteği

- Chrome (son 2 versiyon)
- Firefox (son 2 versiyon)
- Safari (son 2 versiyon)
- Edge (son 2 versiyon)
- Opera (son 2 versiyon)

## 📞 Destek

Sorularınız için:
- Dokümantasyonu inceleyin: `docs/index.html`
- FAQ sayfasını ziyaret edin: `docs/faq.html`
- GitHub issues kullanın

## 📄 Lisans

Bu template, [elemis](https://themeforest.net/user/elemis) tarafından geliştirilmiştir.

## 🙏 Teşekkürler

- [Tailwind CSS](https://tailwindcss.com/)
- [Unicons](https://iconscout.com/unicons)
- Tüm açık kaynak kütüphaneler

---

**Not**: Bu template, modern web standartlarına uygun olarak geliştirilmiştir ve tüm cihazlarda mükemmel performans sağlar.

**Güncelleme**: Template, düzenli olarak güncellenmekte ve yeni özellikler eklenmektedir.

