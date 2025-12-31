# Universal Dynamic Translation System

## 🌟 Genel Bakış

Citrus Platform için geliştirilmiş **evrensel, dinamik ve role-based** çeviri sistemi. Bu sistem, herhangi bir modelin çeviri desteğine sahip olmasını sağlar ve kullanıcı bazlı dil yönetimi sunar.

## 📋 Sistem Mimarisi

```
┌─────────────────┐
│   languages     │ → Dinamik dil tanımları (TR, EN, DE, FR, AR...)
└─────────────────┘
        ↓
┌─────────────────┐
│  translations   │ → Evrensel çeviri tablosu (polymorphic)
└─────────────────┘
        ↓
┌─────────────────┐
│ user_languages  │ → Kullanıcı-Dil ilişkisi (yetkiler)
└─────────────────┘
        ↓
┌─────────┐ ┌─────────┐ ┌─────────┐ ┌──────────┐
│  pages  │ │  blogs  │ │products │ │   news   │ → Herhangi bir model
└─────────┘ └─────────┘ └─────────┘ └──────────┘
```

## ✅ Kurulum ve Yapılandırma

### 1. Database Tabloları

```bash
php artisan migrate
```

Oluşturulan tablolar:
- `languages` - Dil tanımları
- `translations` - Çeviri veriler (polymorphic)
- `user_languages` - Kullanıcı-dil yetkileri

### 2. Varsayılan Diller

```bash
php artisan db:seed --class=LanguageSeeder
```

Eklenen diller:
- 🇹🇷 Türkçe (tr) - Varsayılan, Aktif
- 🇬🇧 İngilizce (en) - Aktif
- 🇩🇪 Almanca (de) - Pasif
- 🇫🇷 Fransızca (fr) - Pasif
- 🇸🇦 Arapça (ar) - Pasif, RTL

### 3. Model Entegrasyonu

Herhangi bir modele çeviri desteği eklemek için:

```php
use App\Traits\HasTranslations;

class YourModel extends Model
{
    use HasTranslations;
    
    protected $translatable = [
        'title',
        'description',
        'content',
    ];
}
```

## 🎯 Kullanım

### Çeviri Kaydetme

```php
// Basit çeviri kaydetme
$blog->setTranslation('title', 'en', 'My Blog Post');

// Status ile kaydetme
$blog->setTranslation('title', 'en', 'My Blog Post', 'published');

// Kullanıcı ID ile
$blog->setTranslation('title', 'en', 'My Blog Post', 'draft', auth()->id());
```

### Çeviri Okuma

```php
// Mevcut dilde
$title = $blog->translate('title');

// Belirli bir dilde
$title = $blog->translate('title', 'en');

// Fallback olmadan
$title = $blog->translate('title', 'en', false);
```

### Toplu İşlemler

```php
// Tüm çevirileri al (bir alan için)
$translations = $blog->getTranslations('title');
// ['tr' => 'Blog Yazım', 'en' => 'My Blog Post']

// Bir dildeki tüm çevirileri al
$translations = $blog->getTranslationsForLanguage('en');
// ['title' => 'My Blog Post', 'content' => '...']

// Çeviri var mı kontrol et
if ($blog->hasTranslation('title', 'en')) {
    // ...
}
```

### Translation Progress

```php
// Tüm diller için ilerleme
$progress = $blog->getTranslationProgress();
// ['tr' => 100, 'en' => 75, 'de' => 0]

// Eksik çevirileri bul
$missing = $blog->getMissingTranslations('en');
// ['meta_description', 'excerpt']

// Çeviri durumu
$status = $blog->getTranslationStatus('en');
// 'complete', 'partial', 'missing'
```

### Translation Workflow

```php
// Çeviri oluştur (draft)
$translation = $blog->setTranslation('title', 'en', 'My Title', 'draft');

// Onaya gönder
$translation->submitForReview();

// Onayla
$translation->approve(auth()->id());

// Yayınla
$translation->publish(auth()->id());

// Reddet
$translation->reject();
```

### Dil Değiştirme

```php
// Runtime'da dil değiştir
switch_language('en');

// Uygulama dili
app()->setLocale('tr');
```

## 🔐 Kullanıcı Yetkilendirme

### Kullanıcıya Dil Atama

```php
// Tam yetki ile dil ata
$user->assignLanguage('tr', 
    canCreate: true, 
    canEdit: true, 
    canApprove: true, 
    canPublish: true
);

// Sadece oluşturma ve düzenleme yetkisi
$user->assignLanguage('en', 
    canCreate: true, 
    canEdit: true, 
    canApprove: false, 
    canPublish: false
);
```

### Yetki Kontrolleri

```php
// Kullanıcı bu dili yönetebilir mi?
if ($user->canManageLanguage('en')) {
    // ...
}

// Specific permissions
if ($user->canCreateInLanguage('en')) { }
if ($user->canEditInLanguage('en')) { }
if ($user->canApproveInLanguage('en')) { }
if ($user->canPublishInLanguage('en')) { }

// Kullanıcının yönettiği diller
$languages = $user->getManagedLanguages();
$codes = $user->getManagedLanguageCodes(); // ['tr', 'en']
```

### Query Filtering

```php
// Sadece belirli dildeki içerikleri getir
Blog::whereHasTranslation('en')->get();

// Kullanıcının yönettiği dillerdeki içerikleri getir
Blog::whereHasTranslationForUser(auth()->user())->get();
```

## 🛠️ Helper Functions

```php
// Mevcut dil
$language = current_language(); // Language model
$code = current_language_code(); // 'tr'

// Varsayılan dil
$defaultLang = default_language();
$defaultCode = default_language_code();

// Aktif diller
$languages = available_languages(); // Collection
$codes = available_language_codes(); // ['tr', 'en']

// Model çevirisi
$value = translate_model($blog, 'title', 'en');

// Çeviri kontrolü
$exists = has_translation($blog, 'title', 'en');

// İlerleme
$progress = translation_progress($blog, 'en'); // 75

// Kullanıcı yetkileri
$can = user_can_manage_language('en');
$languages = user_managed_languages();
$codes = user_managed_language_codes();

// Dil bilgileri
$flag = get_language_flag('tr'); // 🇹🇷
$name = format_language_name('tr'); // Turkish (Türkçe)

// Status
$badge = get_translation_status_badge('published');
$color = get_translation_status_color('draft');
```

## 📊 Filament Admin Panel

### Language Management

Admin panelde **Languages** resource'u üzerinden:
- ✅ Dil ekleme/düzenleme/silme
- ✅ Dil aktif/pasif yapma
- ✅ Varsayılan dil seçme
- ✅ Sıralama düzenleme
- ✅ RTL/LTR desteği

### Permissions

Spatie Permission ile entegre:
- `language::viewAny`
- `language::view`
- `language::create`
- `language::update`
- `language::delete`
- `language::restore`
- `language::forceDelete`
- `language::activate`
- `language::setDefault`

### Policy Kuralları

- Varsayılan dil silinemez
- Varsayılan dil pasif edilemez
- Super admin tüm yetkilere sahip
- Diğer kullanıcılar permission'lara göre erişir

## 🎨 Translation Workflow Statuses

| Status | Açıklama | Badge Color |
|--------|----------|-------------|
| `draft` | Taslak, henüz onaylanmamış | Gray |
| `review` | Onay bekliyor | Warning |
| `approved` | Onaylanmış, yayınlanmayı bekliyor | Success |
| `published` | Yayınlanmış, görünür | Primary |

## 📦 Database Schema

### languages

```sql
id, code (unique), name, native_name, flag, direction,
is_active, is_default, sort_order,
created_by, updated_by, created_at, updated_at, deleted_at
```

### translations

```sql
id, translatable_type, translatable_id, language_code, 
field_name, field_value, status, version,
created_by, updated_by, approved_by, approved_at, published_at,
created_at, updated_at, deleted_at

UNIQUE: translatable_type + translatable_id + language_code + field_name
```

### user_languages

```sql
id, user_id, language_code,
can_create, can_edit, can_approve, can_publish,
created_at, updated_at

UNIQUE: user_id + language_code
```

## 🚀 Örnekler

### Yeni Model için Çeviri Ekle

```php
// 1. Model oluştur
class Product extends Model
{
    use HasTranslations;
    
    protected $translatable = ['name', 'description', 'features'];
}

// 2. Çeviri ekle
$product = Product::create(['name' => 'Ürün', 'slug' => 'urun']);
$product->setTranslation('name', 'en', 'Product', 'published');
$product->setTranslation('description', 'en', 'Product description', 'published');

// 3. Kullan
echo $product->translate('name'); // Mevcut dilde
echo $product->translate('name', 'en'); // İngilizce'de
```

### Çeviri İlerlemesi Widget

```php
$progress = $blog->getTranslationProgress();
foreach ($progress as $langCode => $percentage) {
    $language = Language::findByCode($langCode);
    echo "{$language->flag} {$language->name}: {$percentage}%";
}
```

### Kullanıcı Dil Yönetimi

```php
// Turkish Editor oluştur
$user = User::find(1);
$user->assignLanguage('tr', true, true, false, true);

// English Translator oluştur
$translator = User::find(2);
$translator->assignLanguage('en', true, true, false, false);

// Multi-language Manager
$manager = User::find(3);
$manager->assignLanguage('tr', true, true, true, true);
$manager->assignLanguage('en', true, true, true, true);
```

## ⚡ Performans

- ✅ Indexed queries (translatable_type, translatable_id, language_code)
- ✅ Eager loading desteği
- ✅ Cache-ready yapı
- ✅ Efficient polymorphic relationships
- ✅ Unique constraints

## 🔄 Migration

Mevcut projeden yeni sisteme geçiş için:

```php
// Eski sistem
$blog->title_tr
$blog->title_en

// Yeni sisteme migrate
$blog->setTranslation('title', 'tr', $blog->title_tr, 'published');
$blog->setTranslation('title', 'en', $blog->title_en, 'published');
```

## 📝 Notlar

1. **Zero Configuration**: Yeni model için sadece trait ekle
2. **Dynamic**: Runtime'da dil ekle/çıkar
3. **Role-Based**: Her kullanıcı farklı dilleri yönetebilir
4. **Workflow**: Draft → Review → Approved → Published
5. **Fallback**: Çeviri yoksa default dile düş
6. **Version Control**: Her çevirinin versiyonu
7. **Soft Delete**: Tüm tablolar soft delete destekli

## 🎯 Gelecek Özellikler (TODO)

- [ ] Translation approval notifications
- [ ] Bulk translation import/export
- [ ] Translation memory (önceki çevirilerden öner)
- [ ] AI-powered translation suggestions
- [ ] Translation dashboard widget
- [ ] Language-specific user roles
- [ ] Translation history/audit log
- [ ] Compare translations side-by-side
- [ ] Missing translations report

## 📚 İlgili Dosyalar

- Models: `app/Models/Language.php`, `Translation.php`, `UserLanguage.php`
- Trait: `app/Traits/HasTranslations.php`
- Helpers: `app/Helpers/translation_helpers.php`
- Resource: `app/Filament/Admin/Resources/Languages/`
- Policy: `app/Policies/LanguagePolicy.php`
- Migrations: `database/migrations/*_create_languages_table.php`
- Translations: `lang/tr/language.php`, `lang/en/language.php`

---

**Geliştirici:** Citrus Platform Team  
**Versiyon:** 1.0.0  
**Tarih:** 1 Ekim 2025

