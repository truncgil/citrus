# Trunçgil Teknoloji Web Sitesi Kurulum Kılavuzu

## 🎉 Web sitesi başarıyla oluşturuldu!

Modern, responsive ve dark mode destekli bir web sitesi hazır.

## 📋 Özellikler

✅ **Dinamik Menü Sistemi**
- Admin panelinden yönetilebilir
- `show_in_menu` işaretli sayfalar otomatik görünür
- `parent_page` ile hiyerarşik menü yapısı
- `sort_order` ile sıralama desteği
- Dropdown menüler

✅ **Dark/Light Mode**
- Otomatik tema algılama
- Local storage ile tercih kaydetme
- Smooth transitions
- Her sayfada erişilebilir toggle buton

✅ **Modern Tasarım**
- Tailwind CSS ile responsive design
- Gradient backgrounds
- Smooth animations
- Custom scrollbar
- Modern tipografi (Inter font)

✅ **SEO Friendly**
- Meta title ve description desteği
- Semantic HTML
- Clean URLs
- Open Graph hazır

## 🚀 Kurulum Adımları

### 1. NPM Paketlerini Kur ve Build Et

```bash
npm install
npm run build
```

### 2. Veritabanını Kontrol Et

Eğer henüz migration'ları çalıştırmadıysanız:

```bash
php artisan migrate
```

### 3. Storage Link Oluştur

Featured image'ların görünmesi için:

```bash
php artisan storage:link
```

### 4. İlk Kullanıcı ve Sayfa Oluştur

Admin paneline giriş yapın:
```
https://citrus.truncgil.com/admin
```

**İlk Sayfa Oluşturma:**
1. Pages > Create New Page
2. Başlık ve içerik girin
3. "Homepage" checkbox'ını işaretleyin (anasayfa için)
4. "Show in Menu" işaretleyin (menüde görünsün)
5. Status: Published
6. Save

**Menü Yapısı:**
- Ana sayfa: `parent_page` boş, `sort_order: 0`
- Alt sayfa: `parent_page` seçili, `sort_order: 1, 2, 3...`

## 📁 Oluşturulan Dosyalar

### Controllers
- `app/Http/Controllers/PageController.php` - Sayfa kontrolcüsü

### Routes
- `routes/web.php` - Web route'ları

### Views
- `resources/views/layouts/app.blade.php` - Ana layout
- `resources/views/components/navigation.blade.php` - Dinamik menü
- `resources/views/components/footer.blade.php` - Footer
- `resources/views/home.blade.php` - Anasayfa
- `resources/views/page.blade.php` - Sayfa detay

### Assets
- `resources/css/app.css` - Güncellenmiş CSS
- `resources/js/app.js` - Dark mode JavaScript

## 🎨 Tasarım Özellikleri

### Renkler
- **Primary:** Red (#DC2626)
- **Secondary:** Orange (#EA580C)
- **Dark Mode:** Gray scale

### Logo Kullanımı
- Light mode: `truncgil-yatay.svg` / `truncgil-dikey.svg`
- Dark mode: `truncgil-yatay-dark.svg` / `truncgil-dikey-dark.svg`

### Responsive Breakpoints
- Mobile: < 768px
- Tablet: 768px - 1024px
- Desktop: > 1024px

## 📖 Kullanım

### Yeni Sayfa Ekleme

1. Admin Panel > Pages > Create
2. Form alanlarını doldurun:
   - **Title:** Sayfa başlığı
   - **Slug:** URL (otomatik oluşur)
   - **Content:** Sayfa içeriği (Rich Editor)
   - **Excerpt:** Kısa açıklama
   - **Featured Image:** Öne çıkan görsel
   - **Status:** published (yayında olması için)
   - **Parent Page:** Boş = Ana menü, Dolu = Alt menü
   - **Sort Order:** Menüde sıralama (0, 1, 2...)
   - **Show in Menu:** ✅ İşaretli olmalı
   - **Is Homepage:** Sadece anasayfa için ✅

### Menü Yapısı Örneği

```
Ana Sayfa (parent_id: null, sort_order: 0)
Hakkımızda (parent_id: null, sort_order: 1)
  ├─ Ekibimiz (parent_id: Hakkımızda, sort_order: 0)
  └─ Tarihçe (parent_id: Hakkımızda, sort_order: 1)
Hizmetler (parent_id: null, sort_order: 2)
  ├─ Web Yazılım (parent_id: Hizmetler, sort_order: 0)
  └─ Mobil Uygulama (parent_id: Hizmetler, sort_order: 1)
İletişim (parent_id: null, sort_order: 3)
```

## 🔧 Geliştirme

### Development Mode
```bash
npm run dev
```

### Build for Production
```bash
npm run build
```

### Clear Cache
```bash
php artisan cache:clear
php artisan view:clear
php artisan config:clear
```

## 🎯 SEO Optimizasyonu

Her sayfa için:
1. **Meta Title:** 60 karakter max
2. **Meta Description:** 160 karakter max
3. **Slug:** URL-friendly (otomatik oluşur)
4. **Alt Text:** Görsellere açıklayıcı text

## 🌐 Tarayıcı Desteği

- ✅ Chrome (son 2 versiyon)
- ✅ Firefox (son 2 versiyon)
- ✅ Safari (son 2 versiyon)
- ✅ Edge (son 2 versiyon)

## 📱 Mobil Responsive

Tüm sayfalar mobil uyumlu:
- Touch-friendly menü
- Responsive images
- Mobile-optimized typography
- Hamburger menu

## 🎨 Özelleştirme

### Logo Değiştirme
Logolar `public/logos/` klasöründe. Değiştirmek için:
1. Aynı isimde yeni logo yükleyin
2. Cache'i temizleyin

### Renk Değiştirme
`resources/css/app.css` dosyasında Tailwind theme ayarları

### İletişim Bilgileri
`resources/views/components/footer.blade.php` dosyasında düzenleyin

## 🐛 Sorun Giderme

### Stiller Yüklenmiyorsa
```bash
npm run build
php artisan cache:clear
```

### Dark Mode Çalışmıyorsa
Browser console'da:
```javascript
localStorage.clear()
```
Sayfayı yenileyin.

### Menü Görünmüyorsa
Kontrol edin:
- ✅ Status: published
- ✅ Show in Menu: checked
- ✅ Parent sayfalar da published

## 📞 Destek

Sorularınız için:
- Email: info@truncgil.com
- Admin Panel: /admin

## 🎉 Başarılar!

Web siteniz hazır! Citrus admin panelinden içerik yönetmeye başlayabilirsiniz.

