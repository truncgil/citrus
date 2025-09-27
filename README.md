# Citrus Platform

## Genel Bakış

Citrus Platform, Laravel tabanlı modüler bir platformdur. Türkçe NLP, sınıflandırma, özetleme ve raporlama özelliklerini içeren evrensel bir AI entegrasyon sistemi olarak tasarlanmıştır.

## Teknoloji Stack

- **Backend**: Laravel 12.x
- **Admin Panel**: Filament 3.x
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade Templates + Alpine.js
- **Localization**: Laravel Localization (TR/EN)
- **Testing**: PHPUnit

## Kurulum

### Gereksinimler
- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+ veya PostgreSQL 13+

### Adım 1: Projeyi Klonla
```bash
git clone <repository-url>
cd citrus-platform
```

### Adım 2: Bağımlılıkları Yükle
```bash
composer install
npm install
```

### Adım 3: Environment Ayarları
```bash
cp .env.example .env
php artisan key:generate
```

### Adım 4: Veritabanı Ayarları
`.env` dosyasında veritabanı ayarlarını yapın:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citrus_platform
DB_USERNAME=root
DB_PASSWORD=
```

### Adım 5: Migration ve Seed
```bash
php artisan migrate
php artisan db:seed
```

### Adım 6: Storage Link
```bash
php artisan storage:link
```

### Adım 7: Frontend Build
```bash
npm run build
```

## Geliştirme

### Modül Geliştirme

Citrus Platform'da yeni modül geliştirmek için Pages modülünü referans alın:

1. **Geliştirici El Kitabı**: `docs/DEVELOPER_HANDBOOK.md`
2. **Localization Pattern**: `docs/LOCALIZATION_PATTERN.md`
3. **Modül Template**: `docs/MODULE_TEMPLATE.md`
4. **Cursor Rules**: `.cursorrules`

### Pages Modülü - Örnek Modül

Pages modülü, platformdaki tüm modüller için referans alınacak örnek modüldür:

#### Özellikler
- ✅ **Localization**: Türkçe ve İngilizce dil desteği
- ✅ **CRUD Operations**: Oluşturma, okuma, güncelleme, silme
- ✅ **Soft Delete**: Yumuşak silme özelliği
- ✅ **Form Validation**: Kapsamlı form doğrulama
- ✅ **Table Features**: Filtreleme, sıralama, arama
- ✅ **Action Buttons**: Silme, geri yükleme, kalıcı silme
- ✅ **Notifications**: Başarı/hata mesajları
- ✅ **Redirects**: Sayfa yönlendirmeleri

#### Dosya Yapısı
```
app/Filament/Admin/Resources/Pages/
├── PageResource.php
├── Pages/
│   ├── ListPages.php
│   ├── CreatePage.php
│   └── EditPage.php
├── Schemas/
│   └── PageForm.php
└── Tables/
    └── PagesTable.php

lang/
├── tr/pages.php
└── en/pages.php
```

### Localization Sistemi

Platform, Laravel Localization sistemi kullanarak çoklu dil desteği sağlar:

#### Dil Değiştirme
```php
use Illuminate\Support\Facades\App;

// Türkçe'ye geç
App::setLocale('tr');

// İngilizce'ye geç
App::setLocale('en');
```

#### Çeviri Kullanımı
```php
// Blade template'lerde
{{ __('pages.title') }}

// Controller'larda
$title = __('pages.navigation_label');
```

## Test

### Test Çalıştırma
```bash
# Tüm testler
php artisan test

# Belirli test sınıfı
php artisan test --filter=PageTest

# Coverage ile
php artisan test --coverage
```

### Test Kategorileri
- **Unit Tests**: Model ve sınıf testleri
- **Feature Tests**: API ve sayfa testleri
- **Localization Tests**: Çeviri testleri
- **Integration Tests**: Sistem entegrasyon testleri

## Deployment

### Production Hazırlığı
```bash
# Cache temizleme
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache oluşturma
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Migration
php artisan migrate --force

# Storage link
php artisan storage:link
```

### Environment Variables
```env
# Localization
APP_LOCALE=tr
APP_FALLBACK_LOCALE=en

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citrus_platform
DB_USERNAME=root
DB_PASSWORD=
```

## Dokümantasyon

### Geliştirici Dokümantasyonu
- [Geliştirici El Kitabı](docs/DEVELOPER_HANDBOOK.md)
- [Localization Pattern](docs/LOCALIZATION_PATTERN.md)
- [Modül Template](docs/MODULE_TEMPLATE.md)

### API Dokümantasyonu
- [API Endpoints](docs/API.md)
- [Authentication](docs/AUTHENTICATION.md)
- [Rate Limiting](docs/RATE_LIMITING.md)

## Katkıda Bulunma

### Geliştirme Süreci
1. Fork yapın
2. Feature branch oluşturun (`git checkout -b feature/amazing-feature`)
3. Değişikliklerinizi commit edin (`git commit -m 'Add amazing feature'`)
4. Branch'inizi push edin (`git push origin feature/amazing-feature`)
5. Pull Request oluşturun

### Kod Standartları
- PSR-12 standartlarına uyun
- Type hinting kullanın
- Test yazın
- Dokümantasyonu güncelleyin
- Localization kullanın

## Lisans

Bu proje MIT lisansı altında lisanslanmıştır. Detaylar için [LICENSE](LICENSE) dosyasına bakın.

## İletişim

- **Proje Sahibi**: [İsim]
- **Email**: [email@example.com]
- **Website**: [https://example.com]

## Changelog

### v1.0.0 (2024-01-01)
- İlk sürüm
- Pages modülü eklendi
- Localization sistemi kuruldu
- Filament admin panel entegrasyonu
- Test altyapısı oluşturuldu

---

**Not**: Bu README dosyası, Citrus Platform'un genel yapısını ve kullanımını açıklar. Detaylı geliştirme bilgileri için `docs/` klasöründeki dokümantasyonları inceleyin.