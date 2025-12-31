# Localization Pattern - Citrus Platform

## Genel Bakış

Citrus Platform'da tüm modüller Laravel Localization sistemi kullanarak çoklu dil desteği sağlar. Bu dokümantasyon, localization pattern'ini ve Pages modülü örneğini detaylandırır.

## Pattern Yapısı

### 1. Dil Dosyası Organizasyonu

```
lang/
├── tr/                    # Türkçe çeviriler
│   ├── pages.php         # Pages modülü çevirileri
│   ├── users.php         # Users modülü çevirileri
│   └── common.php        # Ortak çeviriler
├── en/                    # İngilizce çeviriler
│   ├── pages.php         # Pages modülü çevirileri
│   ├── users.php         # Users modülü çevirileri
│   └── common.php        # Ortak çeviriler
└── validation.php         # Validation mesajları
```

### 2. Çeviri Anahtarı Yapısı

```php
// Modül adı (kebab-case) + alt kategoriler
'module_name' => [
    'title' => 'Modül Başlığı',
    'navigation_label' => 'Navigasyon Etiketi',
    'model_label' => 'Tekil Model Etiketi',
    'plural_model_label' => 'Çoğul Model Etiketi',
    
    // Actions
    'create' => 'Oluştur',
    'edit' => 'Düzenle',
    'delete' => 'Sil',
    'restore' => 'Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    
    // Form fields
    'field_name' => 'Alan Etiketi',
    
    // Status options
    'status_option' => 'Durum Seçeneği',
    
    // Messages
    'created_successfully' => 'Başarıyla oluşturuldu.',
    'updated_successfully' => 'Başarıyla güncellendi.',
    'deleted_successfully' => 'Başarıyla silindi.',
    
    // Table columns
    'table_column_name' => 'Sütun Başlığı',
    
    // Validation messages
    'field_required' => 'Bu alan zorunludur.',
    'field_unique' => 'Bu değer zaten kullanılıyor.',
];
```

## Pages Modülü - Örnek Uygulama

### 1. Resource Sınıfı Localization

```php
<?php

namespace App\Filament\Admin\Resources\Pages;

use Filament\Resources\Resource;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    // Navigation ve model etiketleri için localization
    public static function getNavigationLabel(): string
    {
        return __('pages.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('pages.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('pages.plural_model_label');
    }
}
```

### 2. Page Sınıfları Localization

#### ListPages.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    // Sayfa başlığı için localization
    public function getTitle(): string
    {
        return __('pages.title');
    }

    // Action butonları için localization
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('pages.create')),
        ];
    }
}
```

#### CreatePage.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    // Sayfa başlığı
    public function getTitle(): string
    {
        return __('pages.create');
    }

    // Başarı mesajı
    protected function getCreatedNotificationTitle(): ?string
    {
        return __('pages.created_successfully');
    }
}
```

#### EditPage.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use Filament\Resources\Pages\EditRecord;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    // Sayfa başlığı
    public function getTitle(): string
    {
        return __('pages.edit');
    }

    // Action butonları
    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('pages.delete')),
            ForceDeleteAction::make()
                ->label(__('pages.force_delete')),
            RestoreAction::make()
                ->label(__('pages.restore')),
        ];
    }

    // Başarı mesajı
    protected function getSavedNotificationTitle(): ?string
    {
        return __('pages.updated_successfully');
    }
}
```

### 3. Form ve Table Localization

#### PageForm.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label(__('pages.title_field'))
                    ->required()
                    ->validationMessages([
                        'required' => __('pages.title_required'),
                    ]),
                
                TextInput::make('slug')
                    ->label(__('pages.slug_field'))
                    ->required()
                    ->validationMessages([
                        'required' => __('pages.slug_required'),
                        'unique' => __('pages.slug_unique'),
                    ]),
                
                Textarea::make('content')
                    ->label(__('pages.content_field'))
                    ->required()
                    ->validationMessages([
                        'required' => __('pages.content_required'),
                    ]),
                
                Select::make('status')
                    ->label(__('pages.status_field'))
                    ->options([
                        'draft' => __('pages.status_draft'),
                        'published' => __('pages.status_published'),
                        'archived' => __('pages.status_archived'),
                    ]),
            ]);
    }
}
```

#### PagesTable.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('pages.table_title'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('slug')
                    ->label(__('pages.table_slug'))
                    ->searchable(),
                
                BadgeColumn::make('status')
                    ->label(__('pages.table_status'))
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ]),
                
                TextColumn::make('created_at')
                    ->label(__('pages.table_created_at'))
                    ->dateTime()
                    ->sortable(),
                
                TextColumn::make('updated_at')
                    ->label(__('pages.table_updated_at'))
                    ->dateTime()
                    ->sortable(),
            ]);
    }
}
```

## Dil Dosyası Örnekleri

### Türkçe (lang/tr/pages.php)
```php
<?php

return [
    // Genel
    'title' => 'Sayfalar',
    'navigation_label' => 'Sayfalar',
    'model_label' => 'Sayfa',
    'plural_model_label' => 'Sayfalar',
    
    // Actions
    'create' => 'Yeni Sayfa Oluştur',
    'edit' => 'Sayfayı Düzenle',
    'delete' => 'Sayfayı Sil',
    'restore' => 'Sayfayı Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    
    // Form fields
    'title_field' => 'Başlık',
    'slug_field' => 'URL Yolu',
    'content_field' => 'İçerik',
    'meta_title_field' => 'Meta Başlık',
    'meta_description_field' => 'Meta Açıklama',
    'status_field' => 'Durum',
    'published_at_field' => 'Yayın Tarihi',
    
    // Status options
    'status_draft' => 'Taslak',
    'status_published' => 'Yayınlandı',
    'status_archived' => 'Arşivlendi',
    
    // Messages
    'created_successfully' => 'Sayfa başarıyla oluşturuldu.',
    'updated_successfully' => 'Sayfa başarıyla güncellendi.',
    'deleted_successfully' => 'Sayfa başarıyla silindi.',
    'restored_successfully' => 'Sayfa başarıyla geri yüklendi.',
    
    // Table columns
    'table_title' => 'Başlık',
    'table_slug' => 'URL Yolu',
    'table_status' => 'Durum',
    'table_created_at' => 'Oluşturulma Tarihi',
    'table_updated_at' => 'Güncellenme Tarihi',
    
    // Validation messages
    'title_required' => 'Başlık alanı zorunludur.',
    'slug_required' => 'URL yolu alanı zorunludur.',
    'slug_unique' => 'Bu URL yolu zaten kullanılıyor.',
    'content_required' => 'İçerik alanı zorunludur.',
];
```

### İngilizce (lang/en/pages.php)
```php
<?php

return [
    // General
    'title' => 'Pages',
    'navigation_label' => 'Pages',
    'model_label' => 'Page',
    'plural_model_label' => 'Pages',
    
    // Actions
    'create' => 'Create New Page',
    'edit' => 'Edit Page',
    'delete' => 'Delete Page',
    'restore' => 'Restore Page',
    'force_delete' => 'Force Delete',
    
    // Form fields
    'title_field' => 'Title',
    'slug_field' => 'URL Slug',
    'content_field' => 'Content',
    'meta_title_field' => 'Meta Title',
    'meta_description_field' => 'Meta Description',
    'status_field' => 'Status',
    'published_at_field' => 'Published At',
    
    // Status options
    'status_draft' => 'Draft',
    'status_published' => 'Published',
    'status_archived' => 'Archived',
    
    // Messages
    'created_successfully' => 'Page created successfully.',
    'updated_successfully' => 'Page updated successfully.',
    'deleted_successfully' => 'Page deleted successfully.',
    'restored_successfully' => 'Page restored successfully.',
    
    // Table columns
    'table_title' => 'Title',
    'table_slug' => 'URL Slug',
    'table_status' => 'Status',
    'table_created_at' => 'Created At',
    'table_updated_at' => 'Updated At',
    
    // Validation messages
    'title_required' => 'The title field is required.',
    'slug_required' => 'The URL slug field is required.',
    'slug_unique' => 'This URL slug is already taken.',
    'content_required' => 'The content field is required.',
];
```

## Kullanım Örnekleri

### 1. Blade Template'lerde
```blade
<!-- Sayfa başlığı -->
<h1>{{ __('pages.title') }}</h1>

<!-- Buton -->
<button>{{ __('pages.create') }}</button>

<!-- Durum -->
<span class="status">{{ __('pages.status_published') }}</span>

<!-- Form alanı -->
<label>{{ __('pages.title_field') }}</label>
```

### 2. Controller'larda
```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $title = __('pages.title');
        $pages = Page::all();
        
        return view('pages.index', compact('title', 'pages'));
    }
    
    public function store(Request $request)
    {
        $page = Page::create($request->validated());
        
        return redirect()->route('pages.index')
            ->with('success', __('pages.created_successfully'));
    }
}
```

### 3. JavaScript'te
```javascript
// Alpine.js component'inde
Alpine.data('pageForm', () => ({
    title: '',
    content: '',
    
    submit() {
        // Form submission logic
        this.$dispatch('notify', {
            type: 'success',
            message: this.$t('pages.created_successfully')
        });
    }
}));
```

## Dil Değiştirme

### 1. Runtime'da Dil Değiştirme
```php
use Illuminate\Support\Facades\App;

// Türkçe'ye geç
App::setLocale('tr');

// İngilizce'ye geç
App::setLocale('en');

// Mevcut dili al
$currentLocale = App::getLocale();
```

### 2. Route ile Dil Değiştirme
```php
// routes/web.php
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['tr', 'en'])) {
        App::setLocale($locale);
        session(['locale' => $locale]);
    }
    
    return redirect()->back();
});
```

### 3. Middleware ile Dil Yönetimi
```php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->session()->get('locale', config('app.locale'));
        App::setLocale($locale);
        
        return $next($request);
    }
}
```

## Best Practices

### 1. Çeviri Anahtarı Adlandırma
- ✅ `pages.create` - Modül.action
- ✅ `pages.title_field` - Modül.field_type
- ✅ `pages.status_published` - Modül.status_value
- ❌ `create_page` - Açıklayıcı değil
- ❌ `pageTitle` - camelCase kullanma

### 2. Çeviri Dosyası Organizasyonu
- ✅ Her modül için ayrı dosya
- ✅ Ortak çeviriler için `common.php`
- ✅ Validation mesajları için `validation.php`
- ❌ Tüm çevirileri tek dosyada toplama

### 3. Çeviri Kalitesi
- ✅ Kısa ve açıklayıcı
- ✅ Tutarlı terminoloji
- ✅ Kültürel uygunluk
- ❌ Kelime kelime çeviri
- ❌ Teknik jargon

### 4. Performans
- ✅ Çevirileri cache'le
- ✅ Lazy loading kullan
- ❌ Her request'te dosya okuma
- ❌ Gereksiz çeviri yükleme

## Test Stratejisi

### 1. Localization Test'leri
```php
<?php

namespace Tests\Feature\Localization;

use Tests\TestCase;

class PagesLocalizationTest extends TestCase
{
    public function test_turkish_translations_exist()
    {
        app()->setLocale('tr');
        
        $this->assertNotEmpty(__('pages.title'));
        $this->assertNotEmpty(__('pages.create'));
        $this->assertNotEmpty(__('pages.edit'));
    }
    
    public function test_english_translations_exist()
    {
        app()->setLocale('en');
        
        $this->assertNotEmpty(__('pages.title'));
        $this->assertNotEmpty(__('pages.create'));
        $this->assertNotEmpty(__('pages.edit'));
    }
    
    public function test_fallback_locale_works()
    {
        app()->setLocale('fr'); // Desteklenmeyen dil
        
        // Fallback locale'e düşmeli
        $this->assertEquals('Pages', __('pages.title'));
    }
}
```

### 2. UI Test'leri
```php
<?php

namespace Tests\Feature\Admin\Pages;

use Tests\TestCase;

class PagesUITest extends TestCase
{
    public function test_pages_list_shows_turkish_labels()
    {
        app()->setLocale('tr');
        
        $response = $this->get(route('filament.admin.resources.pages.index'));
        
        $response->assertSee('Sayfalar');
        $response->assertSee('Yeni Sayfa Oluştur');
    }
    
    public function test_pages_list_shows_english_labels()
    {
        app()->setLocale('en');
        
        $response = $this->get(route('filament.admin.resources.pages.index'));
        
        $response->assertSee('Pages');
        $response->assertSee('Create New Page');
    }
}
```

## Sonuç

Bu localization pattern'i, Citrus Platform'da tutarlı ve ölçeklenebilir çoklu dil desteği sağlar. Pages modülü, bu pattern'in uygulandığı örnek modüldür ve tüm yeni modüller için referans alınmalıdır.

### Önemli Noktalar:
1. **Tutarlılık**: Tüm modüller aynı pattern'i kullanmalı
2. **Kapsamlılık**: Tüm UI elementleri için çeviri sağlanmalı
3. **Test Edilebilirlik**: Localization test'leri yazılmalı
4. **Performans**: Çeviriler cache'lenmeli
5. **Bakım Kolaylığı**: Çeviri dosyaları düzenli tutulmalı
