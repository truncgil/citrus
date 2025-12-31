# Citrus Platform - Geliştirici El Kitabı

## İçindekiler
1. [Proje Genel Bakış](#proje-genel-bakış)
2. [Modül Geliştirme Rehberi](#modül-geliştirme-rehberi)
3. [Pages Modülü - Örnek Uygulama](#pages-modülü---örnek-uygulama)
4. [Localization Sistemi](#localization-sistemi)
5. [Kod Standartları](#kod-standartları)
6. [Test Stratejisi](#test-stratejisi)
7. [Deployment](#deployment)

## Proje Genel Bakış

Citrus Platform, Laravel tabanlı modüler bir platformdur. Türkçe NLP, sınıflandırma, özetleme ve raporlama özelliklerini içeren evrensel bir AI entegrasyon sistemi olarak tasarlanmıştır.

### Teknoloji Stack
- **Backend**: Laravel 12.x
- **Admin Panel**: Filament 3.x
- **Database**: MySQL/PostgreSQL
- **Frontend**: Blade Templates + Alpine.js
- **Localization**: Laravel Localization
- **Testing**: PHPUnit

## Modül Geliştirme Rehberi

### 1. Yeni Modül Oluşturma

#### Adım 1: Model ve Migration
```bash
# Model oluştur
php artisan make:model ModuleName -m

# Migration dosyasını düzenle
# database/migrations/xxxx_create_module_names_table.php
```

#### Adım 2: Filament Resource
```bash
# Filament resource oluştur
php artisan make:filament-resource ModuleName --generate
```

#### Adım 3: Dil Dosyaları
```bash
# Dil dosyalarını oluştur
touch lang/tr/module_names.php
touch lang/en/module_names.php
```

### 2. Modül Yapısı

```
app/Filament/Admin/Resources/ModuleName/
├── ModuleNameResource.php          # Ana resource sınıfı
├── Pages/
│   ├── ListModuleNames.php         # Liste sayfası
│   ├── CreateModuleName.php        # Oluşturma sayfası
│   └── EditModuleName.php          # Düzenleme sayfası
├── Schemas/
│   └── ModuleNameForm.php          # Form şeması
└── Tables/
    └── ModuleNamesTable.php        # Tablo şeması
```

## Pages Modülü - Örnek Uygulama

Pages modülü, platformdaki tüm modüller için referans alınacak örnek modüldür. Bu modül aşağıdaki özellikleri içerir:

### Özellikler
- ✅ **Localization**: Türkçe ve İngilizce dil desteği
- ✅ **CRUD Operations**: Oluşturma, okuma, güncelleme, silme
- ✅ **Soft Delete**: Yumuşak silme özelliği
- ✅ **Form Validation**: Kapsamlı form doğrulama
- ✅ **Table Features**: Filtreleme, sıralama, arama
- ✅ **Action Buttons**: Silme, geri yükleme, kalıcı silme
- ✅ **Notifications**: Başarı/hata mesajları
- ✅ **Redirects**: Sayfa yönlendirmeleri

### Dosya Yapısı

#### 1. PageResource.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages;

use App\Filament\Admin\Resources\Pages\Pages\CreatePage;
use App\Filament\Admin\Resources\Pages\Pages\EditPage;
use App\Filament\Admin\Resources\Pages\Pages\ListPages;
use App\Filament\Admin\Resources\Pages\Schemas\PageForm;
use App\Filament\Admin\Resources\Pages\Tables\PagesTable;
use App\Models\Page;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    // Localization metodları
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

    // Form ve Table konfigürasyonları
    public static function form(Schema $schema): Schema
    {
        return PageForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PagesTable::configure($table);
    }

    // Sayfa rotaları
    public static function getPages(): array
    {
        return [
            'index' => ListPages::route('/'),
            'create' => CreatePage::route('/create'),
            'edit' => EditPage::route('/{record}/edit'),
        ];
    }

    // Soft delete scope
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
```

#### 2. ListPages.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Pages\PageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('pages.create')),
        ];
    }
}
```

#### 3. CreatePage.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Pages\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages.create');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('pages.created_successfully');
    }
}
```

#### 4. EditPage.php
```php
<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages.edit');
    }

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

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('pages.updated_successfully');
    }
}
```

## Localization Sistemi

### Dil Dosyası Yapısı

#### Türkçe (lang/tr/pages.php)
```php
<?php

return [
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

### Kullanım Örnekleri

#### Blade Template'lerde
```blade
{{ __('pages.title') }}
{{ __('pages.create') }}
{{ __('pages.status_published') }}
```

#### Controller'larda
```php
$title = __('pages.navigation_label');
$message = __('pages.created_successfully');
```

#### Form Field'larında
```php
TextInput::make('title')
    ->label(__('pages.title_field'))
    ->required()
    ->validationMessages([
        'required' => __('pages.title_required'),
    ])
```

### Dil Değiştirme
```php
use Illuminate\Support\Facades\App;

// Runtime'da dil değiştirme
App::setLocale('tr'); // Türkçe
App::setLocale('en'); // İngilizce
```

## Kod Standartları

### 1. PSR-12 Uyumluluğu
- Tüm kod PSR-12 standartlarına uygun olmalı
- Type hinting kullanılmalı
- Return type'lar belirtilmeli

### 2. Naming Conventions
- **Sınıflar**: PascalCase (`PageResource`)
- **Metodlar**: camelCase (`getTitle`)
- **Değişkenler**: camelCase (`$pageTitle`)
- **Sabitler**: UPPER_SNAKE_CASE (`STATUS_PUBLISHED`)
- **Dosyalar**: PascalCase (`PageResource.php`)

### 3. DocBlock Standartları
```php
/**
 * Sayfa oluşturma işlemini gerçekleştirir.
 *
 * @param array $data Form verileri
 * @return Page Oluşturulan sayfa modeli
 * @throws ValidationException Form doğrulama hatası
 */
public function createPage(array $data): Page
{
    // Implementation
}
```

### 4. Error Handling
```php
try {
    $page = Page::create($data);
    return redirect()->route('pages.index')
        ->with('success', __('pages.created_successfully'));
} catch (Exception $e) {
    return redirect()->back()
        ->withInput()
        ->with('error', __('pages.create_error'));
}
```

## Test Stratejisi

### 1. Unit Tests
```php
<?php

namespace Tests\Unit\Models;

use App\Models\Page;
use Tests\TestCase;

class PageTest extends TestCase
{
    public function test_can_create_page()
    {
        $page = Page::factory()->create([
            'title' => 'Test Page',
            'slug' => 'test-page'
        ]);

        $this->assertDatabaseHas('pages', [
            'title' => 'Test Page',
            'slug' => 'test-page'
        ]);
    }
}
```

### 2. Feature Tests
```php
<?php

namespace Tests\Feature\Admin\Pages;

use App\Models\Page;
use Tests\TestCase;

class PageResourceTest extends TestCase
{
    public function test_can_list_pages()
    {
        $response = $this->get(route('filament.admin.resources.pages.index'));
        $response->assertStatus(200);
    }

    public function test_can_create_page()
    {
        $data = [
            'title' => 'New Page',
            'slug' => 'new-page',
            'content' => 'Page content'
        ];

        $response = $this->post(route('filament.admin.resources.pages.store'), $data);
        $response->assertRedirect();
        
        $this->assertDatabaseHas('pages', $data);
    }
}
```

### 3. Localization Tests
```php
<?php

namespace Tests\Feature\Localization;

use Tests\TestCase;

class LocalizationTest extends TestCase
{
    public function test_turkish_translations()
    {
        app()->setLocale('tr');
        
        $this->assertEquals('Sayfalar', __('pages.navigation_label'));
        $this->assertEquals('Yeni Sayfa Oluştur', __('pages.create'));
    }

    public function test_english_translations()
    {
        app()->setLocale('en');
        
        $this->assertEquals('Pages', __('pages.navigation_label'));
        $this->assertEquals('Create New Page', __('pages.create'));
    }
}
```

## Deployment

### 1. Environment Configuration
```env
# Localization
APP_LOCALE=tr
APP_FALLBACK_LOCALE=en

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=citrus_platform
DB_USERNAME=root
DB_PASSWORD=

# Cache
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

### 2. Deployment Checklist
- [ ] Environment variables ayarlandı
- [ ] Database migration'ları çalıştırıldı
- [ ] Cache temizlendi
- [ ] Config cache oluşturuldu
- [ ] Route cache oluşturuldu
- [ ] View cache oluşturuldu
- [ ] Storage link oluşturuldu
- [ ] Permissions ayarlandı

### 3. Production Commands
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

# Storage link
php artisan storage:link

# Migration
php artisan migrate --force

# Queue restart
php artisan queue:restart
```

## Sonuç

Bu el kitabı, Citrus Platform'da modül geliştirme sürecini standartlaştırmak için hazırlanmıştır. Pages modülü, tüm yeni modüller için referans alınacak örnek uygulamadır.

Her yeni modül geliştirirken:
1. Bu el kitabındaki standartları takip edin
2. Pages modülünü referans alın
3. Localization sistemini kullanın
4. Test yazın
5. Dokümantasyonu güncelleyin

Sorularınız için: [Geliştirici Ekibi]
