# Veritabanı Seeder Kullanım Kılavuzu

## Genel Bakış

Sistemde 2 ana seeder bulunmaktadır:
1. **PageSeeder** - Örnek sayfalar (home, about, services, contact, pricing)
2. **SettingSeeder** - Site ayarları ve yapılandırmaları

## Seeder'ları Çalıştırma

### Tüm Seeder'ları Çalıştırma

```bash
php artisan db:seed
```

### Sadece Page Seeder'ı Çalıştırma

```bash
php artisan db:seed --class=PageSeeder
```

### Sadece Setting Seeder'ı Çalıştırma

```bash
php artisan db:seed --class=SettingSeeder
```

### Fresh Migration + Seed (Dikkat: Tüm veriler silinir!)

```bash
php artisan migrate:fresh --seed
```

---

## PageSeeder İçeriği

### Oluşturulan Sayfalar

1. **Anasayfa** (`slug: home`)
   - `is_homepage: true`
   - `template: home`
   - Bloklar: Hero, Features, Stats, CTA
   - Durum: published

2. **Hakkımızda** (`slug: about`)
   - `template: generic`
   - Bloklar: Hero, Features
   - Durum: published

3. **Hizmetlerimiz** (`slug: services`)
   - `template: generic`
   - Bloklar: Hero, Features (6 hizmet)
   - Durum: published

4. **İletişim** (`slug: contact`)
   - `template: generic`
   - Bloklar: Hero, Contact Form
   - Durum: published

5. **Fiyatlandırma** (`slug: pricing`)
   - `template: generic`
   - Bloklar: Hero, Pricing (3 paket)
   - Durum: published
   - `show_in_menu: false` (menüde görünmez)

### Blok Yapısı Örneği

```json
{
  "sections": [
    {
      "type": "hero",
      "data": {
        "badge": "YENİ PLATFORM",
        "title": "Modern ve Çok Amaçlı Web Çözümleri",
        "subtitle": "...",
        "primary_button_text": "Hemen Başla",
        "primary_button_url": "#features"
      }
    },
    {
      "type": "features",
      "data": {
        "section_title": "Neden Truncgil Citrus?",
        "features": [...]
      }
    }
  ]
}
```

---

## SettingSeeder İçeriği

### Gruplar ve Ayarlar

| Grup | Açıklama | Örnek Ayarlar |
|------|----------|---------------|
| `general` | Genel site ayarları | site_name, site_description, logo, favicon |
| `theme` | Tema ve renk ayarları | primary_color, secondary_color, custom_css |
| `localization` | Dil ve bölge ayarları | timezone, currency, date_format |
| `email` | E-posta sunucu ayarları | mail_host, mail_port, mail_from |
| `social` | Sosyal medya linkleri | facebook, instagram, linkedin, twitter |
| `layout` | Frontend layout ayarları | default_meta_title, logo_path, favicon_path |
| `seo` | SEO ve analitik ayarları | google_analytics, meta_keywords |
| `security` | Güvenlik ayarları | max_login_attempts, password_rules |
| `upload` | Dosya yükleme ayarları | max_size, allowed_types, image_quality |
| `notification` | Bildirim ayarları | email_enabled, sms_enabled |
| `cache` | Cache ayarları | cache_driver, cache_duration |
| `payment` | Ödeme ayarları | default_gateway, test_mode |
| `api` | API ayarları | rate_limit, auth_method |
| `logging` | Log ayarları | log_level, retention_days |
| `performance` | Performans ayarları | query_cache, cdn_enabled |
| `integration` | 3. parti entegrasyonlar | recaptcha, stripe, paypal |

### Frontend için Kritik Ayarlar

```php
// Layout için
'default_meta_title' => 'Truncgil Citrus - Modern Web Çözümleri'
'default_meta_description' => 'Yenilikçi teknoloji çözümleri...'
'default_meta_image' => 'assets/img/demos/f1.png'
'logo_path' => 'assets/img/truncgil-yatay.svg'
'favicon_path' => 'assets/img/favicon.ico'

// Sosyal medya
'social_links' => {
  'facebook': 'https://facebook.com/',
  'instagram': 'https://instagram.com/',
  'linkedin': 'https://linkedin.com/',
  'twitter': 'https://twitter.com/'
}
```

---

## Seeder Sonrası Kontrol

### 1. Veritabanı Kontrolü

```bash
# Pages tablosunu kontrol et
php artisan tinker
>>> App\Models\Page::count()
=> 5

>>> App\Models\Page::where('status', 'published')->count()
=> 5

>>> App\Models\Page::where('is_homepage', true)->first()->slug
=> "home"
```

### 2. Setting Kontrolü

```bash
php artisan tinker
>>> App\Models\Setting::where('key', 'default_meta_title')->first()->value
=> "Truncgil Citrus - Modern Web Çözümleri"

>>> App\Models\Setting::where('key', 'social_links')->first()->value
=> "{\"facebook\":\"https://facebook.com/\",...}"
```

### 3. Frontend Kontrolü

- `https://citrus.truncgil.com/` → Anasayfa (home template + bloklar)
- `https://citrus.truncgil.com/about` → Hakkımızda
- `https://citrus.truncgil.com/services` → Hizmetler
- `https://citrus.truncgil.com/contact` → İletişim
- `https://citrus.truncgil.com/pricing` → Fiyatlandırma

---

## Özelleştirme

### Yeni Sayfa Ekleme

`database/seeders/PageSeeder.php` içinde `$pages` dizisine ekleyin:

```php
[
    'title' => 'Portfolyo',
    'slug' => 'portfolio',
    'template' => 'generic',
    'status' => 'published',
    'show_in_menu' => true,
    'sort_order' => 6,
    'published_at' => now(),
    'sections' => [
        // Bloklar...
    ],
]
```

### Var Olan Sayfayı Güncelleme

Seeder updateOrCreate kullanıyor, slug'a göre günceller:

```bash
php artisan db:seed --class=PageSeeder
```

Aynı slug varsa güncellenir, yoksa yeni kayıt oluşturulur.

### Setting Değerlerini Değiştirme

`database/seeders/SettingSeeder.php` içinde ilgili `value` alanını değiştirin ve çalıştırın:

```bash
php artisan db:seed --class=SettingSeeder
```

---

## Sorun Giderme

### "Class not found" Hatası

```bash
composer dump-autoload
php artisan clear-compiled
php artisan config:clear
php artisan db:seed
```

### "Table doesn't exist" Hatası

```bash
php artisan migrate
php artisan db:seed
```

### Seeder Çalışmıyor

```bash
# Verbose mode ile hata detaylarını görün
php artisan db:seed --class=PageSeeder -vvv
```

### Fresh Start (Tüm veriyi sıfırlama)

```bash
php artisan migrate:fresh --seed
```

⚠️ **Uyarı:** Bu komut tüm tabloları siler ve yeniden oluşturur!

---

**Son Güncelleme:** {{ now()->format('d.m.Y H:i') }}

