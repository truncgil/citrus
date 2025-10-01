# Translation System - Quick Start Guide

## 🚀 5 Dakikada Başlangıç

### 1️⃣ Admin Panel'e Git

```
http://your-domain.com/admin/languages
```

### 2️⃣ Dilleri Aktifleştir

- 🇹🇷 Türkçe (TR) - Zaten aktif (varsayılan)
- 🇬🇧 İngilizce (EN) - Zaten aktif
- 🇩🇪 Almanca (DE) - İsterseniz aktif edin
- 🇫🇷 Fransızca (FR) - İsterseniz aktif edin

### 3️⃣ İlk Çeviriyi Ekle

#### Tinker ile (Terminal):
```bash
php artisan tinker

# Blog çevirisi ekle
$blog = App\Models\Blog::first();
$blog->setTranslation('title', 'en', 'My First Blog Post', 'published');
$blog->setTranslation('content', 'en', 'This is my blog content in English...', 'published');

# Kontrol et
echo $blog->translate('title', 'en');
```

#### Kod ile:
```php
use App\Models\Blog;

$blog = Blog::find(1);

// İngilizce çeviri ekle
$blog->setTranslation('title', 'en', 'My Blog Title', 'published');
$blog->setTranslation('content', 'en', 'Blog content here...', 'published');
$blog->setTranslation('excerpt', 'en', 'Short description', 'published');

// Oku
echo $blog->translate('title'); // Mevcut dilde
echo $blog->translate('title', 'en'); // İngilizce
echo $blog->translate('title', 'tr'); // Türkçe
```

### 4️⃣ Translation Progress Kontrol Et

```php
$blog = Blog::find(1);

// İlerleme yüzdeleri
$progress = $blog->getTranslationProgress();
print_r($progress);
// ['tr' => 100, 'en' => 60, 'de' => 0]

// Eksik çeviriler
$missing = $blog->getMissingTranslations('en');
print_r($missing);
// ['meta_title', 'meta_description']

// Durum
echo $blog->getTranslationStatus('en'); // 'partial'
```

### 5️⃣ Kullanıcıya Dil Yetkisi Ver

```php
use App\Models\User;

$user = User::find(1);

// Türkçe içerik yöneticisi
$user->assignLanguage('tr', 
    canCreate: true, 
    canEdit: true, 
    canApprove: true, 
    canPublish: true
);

// İngilizce çevirmen (yayınlayamaz)
$user->assignLanguage('en', 
    canCreate: true, 
    canEdit: true, 
    canApprove: false, 
    canPublish: false
);

// Kontrol
if ($user->canManageLanguage('tr')) {
    echo "User can manage Turkish!";
}
```

## 💡 Yaygın Kullanım Örnekleri

### Örnek 1: Blog Oluştur ve Çevir

```php
// 1. Türkçe blog oluştur
$blog = Blog::create([
    'title' => 'Laravel Eğitimi',
    'slug' => 'laravel-egitimi',
    'content' => 'Laravel hakkında detaylı bilgi...',
    'excerpt' => 'Laravel nedir?',
    'status' => 'published',
    'author_id' => 1,
]);

// 2. İngilizce çevirisi ekle
$blog->setTranslation('title', 'en', 'Laravel Tutorial', 'published');
$blog->setTranslation('content', 'en', 'Detailed info about Laravel...', 'published');
$blog->setTranslation('excerpt', 'en', 'What is Laravel?', 'published');

// 3. Almanca çevirisi ekle (draft olarak)
$blog->setTranslation('title', 'de', 'Laravel Tutorial', 'draft');
$blog->setTranslation('content', 'de', 'Detaillierte Informationen über Laravel...', 'draft');

// 4. Çevirileri kullan
echo $blog->translate('title'); // Mevcut dilde
echo $blog->translate('title', 'en'); // İngilizce
echo $blog->translate('title', 'de'); // Almanca (draft, yayında değil)
```

### Örnek 2: Translation Workflow

```php
$blog = Blog::find(1);

// Çeviri oluştur (draft olarak başlar)
$translation = $blog->setTranslation('title', 'en', 'My Title', 'draft');

// Workflow adımları
$translation->submitForReview(); // Draft → Review
$translation->approve(auth()->id()); // Review → Approved
$translation->publish(auth()->id()); // Approved → Published

// Veya direkt yayınla
$translation->publish(); // Draft/Review/Approved → Published

// Geri al
$translation->unpublish(); // Published → Approved
$translation->reject(); // Review → Draft
```

### Örnek 3: Yeni Model Ekle

```php
// 1. Model oluştur
class Product extends Model
{
    use HasTranslations;
    
    protected $fillable = [
        'name', 'slug', 'description', 'price', 'sku'
    ];
    
    protected $translatable = [
        'name',
        'description',
    ];
}

// 2. Migration
Schema::create('products', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description');
    $table->decimal('price', 10, 2);
    $table->string('sku')->unique();
    $table->timestamps();
});

// 3. Kullan
$product = Product::create([
    'name' => 'Laptop',
    'slug' => 'laptop',
    'description' => 'Yüksek performanslı laptop',
    'price' => 15000,
    'sku' => 'LAP-001'
]);

$product->setTranslation('name', 'en', 'Laptop', 'published');
$product->setTranslation('description', 'en', 'High performance laptop', 'published');

// Artık Product'da çeviri var! 🎉
echo $product->translate('name', 'en'); // "Laptop"
```

### Örnek 4: Tüm Çevirileri Getir

```php
$blog = Blog::find(1);

// Bir alanın tüm dillerdeki çevirileri
$titleTranslations = $blog->getTranslations('title');
foreach ($titleTranslations as $langCode => $translation) {
    echo "{$langCode}: {$translation->field_value}\n";
}
// tr: Laravel Eğitimi
// en: Laravel Tutorial
// de: Laravel Tutorial

// Bir dilin tüm alan çevirileri
$enTranslations = $blog->getTranslationsForLanguage('en');
foreach ($enTranslations as $fieldName => $translation) {
    echo "{$fieldName}: {$translation->field_value}\n";
}
// title: Laravel Tutorial
// content: Detailed info about Laravel...
// excerpt: What is Laravel?
```

### Örnek 5: Helper Functions

```php
// Mevcut dil
$currentLang = current_language(); // Language model
$currentCode = current_language_code(); // 'tr'

// Varsayılan dil
$defaultLang = default_language();
$defaultCode = default_language_code(); // 'tr'

// Aktif diller
$languages = available_languages(); // Collection [TR, EN]
$codes = available_language_codes(); // ['tr', 'en']

// Dil değiştir
switch_language('en');
app()->setLocale('en');

// Model çevirisi
$title = translate_model($blog, 'title', 'en');

// Çeviri var mı?
if (has_translation($blog, 'title', 'en')) {
    echo "English translation exists!";
}

// İlerleme
$progress = translation_progress($blog, 'en'); // 75

// Kullanıcı dilleri
$userLanguages = user_managed_languages(); // Collection
$userCodes = user_managed_language_codes(); // ['tr', 'en']

// Dil bilgileri
echo get_language_flag('tr'); // 🇹🇷
echo format_language_name('tr'); // Turkish (Türkçe)
```

## 🎯 Sık Sorulan Sorular

### 1. Varsayılan dilde çeviri lazım mı?
Hayır! Varsayılan dil (TR) için veritabanındaki orijinal değer kullanılır. Sadece diğer diller için çeviri eklemeniz yeterli.

### 2. Çeviri yoksa ne olur?
Fallback mekanizması devreye girer:
1. İstenen dilde ara
2. Yoksa varsayılan dilde ara
3. Yoksa model'deki orijinal değeri kullan

### 3. Draft çeviriler görünür mü?
Hayır, sadece `published` çeviriler görünür. Ama parametre ile draft'ları da alabilirsiniz:
```php
$translation = $blog->getTranslation('title', 'en', published: false);
```

### 4. Toplu çeviri nasıl yapılır?
```php
// TR'den EN'e tüm alanları kopyala
$blog->duplicateTranslation('tr', 'en');

// Tüm diller için placeholder oluştur
$blog->syncTranslations(['tr', 'en', 'de']);
```

### 5. Performans nasıl?
- ✅ Indexed queries
- ✅ Eager loading desteği
- ✅ Tek query ile tüm çevirileri çek
- ✅ Cache-ready yapı

## 📊 Dashboard Özet Örneği

```php
// Admin dashboard widget örneği
$stats = [
    'total_languages' => Language::active()->count(),
    'total_translations' => Translation::published()->count(),
    'pending_approvals' => Translation::review()->count(),
    'translation_progress' => []
];

foreach (Language::active()->get() as $language) {
    $stats['translation_progress'][$language->code] = [
        'name' => $language->name,
        'flag' => $language->flag,
        'count' => Translation::forLanguage($language->code)->published()->count(),
    ];
}
```

## 🎨 Blade Template Kullanımı

```blade
{{-- Mevcut dilde --}}
<h1>{{ $blog->translate('title') }}</h1>

{{-- Belirli dilde --}}
<h1>{{ $blog->translate('title', 'en') }}</h1>

{{-- Helper ile --}}
<h1>{{ translate_model($blog, 'title') }}</h1>

{{-- Dil seçici --}}
@foreach(available_languages() as $language)
    <a href="?lang={{ $language->code }}">
        {{ $language->flag }} {{ $language->name }}
    </a>
@endforeach

{{-- Progress bar --}}
@php
    $progress = $blog->getTranslationProgress();
@endphp

@foreach($progress as $code => $percentage)
    <div class="progress-bar">
        <span>{{ get_language_flag($code) }}</span>
        <div style="width: {{ $percentage }}%">{{ $percentage }}%</div>
    </div>
@endforeach
```

## 🔥 Pro Tips

1. **Her zaman published status kullanın** (son kullanıcı için)
2. **Draft status kullanın** (henüz tamamlanmamış çeviriler için)
3. **Translation progress ile takip edin** (hangi diller eksik?)
4. **User-language permissions ile kontrol edin** (kim ne yapabilir?)
5. **Fallback mekanizmasını kullanın** (eksik çeviriler için)

---

Hazırsınız! 🚀 Artık universal translation sisteminiz tamamen çalışıyor!

