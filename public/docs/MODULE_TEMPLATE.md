# Modül Template - Citrus Platform

## Genel Bakış

Bu dokümantasyon, Citrus Platform'da yeni modül oluştururken kullanılacak template yapısını ve Pages modülü örneğini detaylandırır.

## Template Yapısı

### 1. Dosya Organizasyonu

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

lang/
├── tr/
│   └── module_names.php            # Türkçe çeviriler
└── en/
    └── module_names.php            # İngilizce çeviriler

app/Models/
└── ModuleName.php                  # Model sınıfı

database/migrations/
└── xxxx_create_module_names_table.php  # Migration dosyası
```

## Template Dosyaları

### 1. Model Template

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModuleName extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Accessors & Mutators
    public function getStatusLabelAttribute()
    {
        return __('module_names.status_' . $this->status);
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = \Str::slug($value);
    }
}
```

### 2. Migration Template

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('module_names', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('status');
            $table->index('published_at');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('module_names');
    }
};
```

### 3. Resource Template

```php
<?php

namespace App\Filament\Admin\Resources\ModuleNames;

use App\Filament\Admin\Resources\ModuleNames\Pages\CreateModuleName;
use App\Filament\Admin\Resources\ModuleNames\Pages\EditModuleName;
use App\Filament\Admin\Resources\ModuleNames\Pages\ListModuleNames;
use App\Filament\Admin\Resources\ModuleNames\Schemas\ModuleNameForm;
use App\Filament\Admin\Resources\ModuleNames\Tables\ModuleNamesTable;
use App\Models\ModuleName;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ModuleNameResource extends Resource
{
    protected static ?string $model = ModuleName::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    // Localization
    public static function getNavigationLabel(): string
    {
        return __('module_names.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('module_names.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('module_names.plural_model_label');
    }

    // Form and Table
    public static function form(Schema $schema): Schema
    {
        return ModuleNameForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ModuleNamesTable::configure($table);
    }

    // Relations
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // Pages
    public static function getPages(): array
    {
        return [
            'index' => ListModuleNames::route('/'),
            'create' => CreateModuleName::route('/create'),
            'edit' => EditModuleName::route('/{record}/edit'),
        ];
    }

    // Query
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
```

### 4. List Page Template

```php
<?php

namespace App\Filament\Admin\Resources\ModuleNames\Pages;

use App\Filament\Admin\Resources\ModuleNameResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListModuleNames extends ListRecords
{
    protected static string $resource = ModuleNameResource::class;

    public function getTitle(): string
    {
        return __('module_names.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('module_names.create')),
        ];
    }
}
```

### 5. Create Page Template

```php
<?php

namespace App\Filament\Admin\Resources\ModuleNames\Pages;

use App\Filament\Admin\Resources\ModuleNameResource;
use Filament\Resources\Pages\CreateRecord;

class CreateModuleName extends CreateRecord
{
    protected static string $resource = ModuleNameResource::class;

    public function getTitle(): string
    {
        return __('module_names.create');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('module_names.created_successfully');
    }
}
```

### 6. Edit Page Template

```php
<?php

namespace App\Filament\Admin\Resources\ModuleNames\Pages;

use App\Filament\Admin\Resources\ModuleNameResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditModuleName extends EditRecord
{
    protected static string $resource = ModuleNameResource::class;

    public function getTitle(): string
    {
        return __('module_names.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('module_names.delete')),
            ForceDeleteAction::make()
                ->label(__('module_names.force_delete')),
            RestoreAction::make()
                ->label(__('module_names.restore')),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('module_names.updated_successfully');
    }
}
```

### 7. Form Schema Template

```php
<?php

namespace App\Filament\Admin\Resources\ModuleNames\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Schema;

class ModuleNameForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')
                    ->label(__('module_names.title_field'))
                    ->required()
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => __('module_names.title_required'),
                        'max' => __('module_names.title_max'),
                    ]),

                TextInput::make('slug')
                    ->label(__('module_names.slug_field'))
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->validationMessages([
                        'required' => __('module_names.slug_required'),
                        'unique' => __('module_names.slug_unique'),
                        'max' => __('module_names.slug_max'),
                    ]),

                Textarea::make('content')
                    ->label(__('module_names.content_field'))
                    ->required()
                    ->rows(10)
                    ->validationMessages([
                        'required' => __('module_names.content_required'),
                    ]),

                Select::make('status')
                    ->label(__('module_names.status_field'))
                    ->options([
                        'draft' => __('module_names.status_draft'),
                        'published' => __('module_names.status_published'),
                        'archived' => __('module_names.status_archived'),
                    ])
                    ->default('draft')
                    ->required(),

                TextInput::make('meta_title')
                    ->label(__('module_names.meta_title_field'))
                    ->maxLength(255)
                    ->validationMessages([
                        'max' => __('module_names.meta_title_max'),
                    ]),

                Textarea::make('meta_description')
                    ->label(__('module_names.meta_description_field'))
                    ->maxLength(500)
                    ->rows(3)
                    ->validationMessages([
                        'max' => __('module_names.meta_description_max'),
                    ]),

                DateTimePicker::make('published_at')
                    ->label(__('module_names.published_at_field'))
                    ->nullable(),
            ]);
    }
}
```

### 8. Table Schema Template

```php
<?php

namespace App\Filament\Admin\Resources\ModuleNames\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class ModuleNamesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('module_names.table_title'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('slug')
                    ->label(__('module_names.table_slug'))
                    ->searchable()
                    ->limit(30),

                BadgeColumn::make('status')
                    ->label(__('module_names.table_status'))
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                        'danger' => 'archived',
                    ]),

                TextColumn::make('published_at')
                    ->label(__('module_names.table_published_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('module_names.table_created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('module_names.table_updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('module_names.status_field'))
                    ->options([
                        'draft' => __('module_names.status_draft'),
                        'published' => __('module_names.status_published'),
                        'archived' => __('module_names.status_archived'),
                    ]),
            ])
            ->actions([
                // Table actions
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
```

### 9. Türkçe Dil Dosyası Template

```php
<?php

return [
    // Genel
    'title' => 'Modül Başlığı',
    'navigation_label' => 'Modül Navigasyon',
    'model_label' => 'Modül',
    'plural_model_label' => 'Modüller',
    
    // Actions
    'create' => 'Yeni Modül Oluştur',
    'edit' => 'Modülü Düzenle',
    'delete' => 'Modülü Sil',
    'restore' => 'Modülü Geri Yükle',
    'force_delete' => 'Kalıcı Olarak Sil',
    
    // Form fields
    'title_field' => 'Başlık',
    'slug_field' => 'URL Yolu',
    'content_field' => 'İçerik',
    'status_field' => 'Durum',
    'meta_title_field' => 'Meta Başlık',
    'meta_description_field' => 'Meta Açıklama',
    'published_at_field' => 'Yayın Tarihi',
    
    // Status options
    'status_draft' => 'Taslak',
    'status_published' => 'Yayınlandı',
    'status_archived' => 'Arşivlendi',
    
    // Messages
    'created_successfully' => 'Modül başarıyla oluşturuldu.',
    'updated_successfully' => 'Modül başarıyla güncellendi.',
    'deleted_successfully' => 'Modül başarıyla silindi.',
    'restored_successfully' => 'Modül başarıyla geri yüklendi.',
    
    // Table columns
    'table_title' => 'Başlık',
    'table_slug' => 'URL Yolu',
    'table_status' => 'Durum',
    'table_published_at' => 'Yayın Tarihi',
    'table_created_at' => 'Oluşturulma Tarihi',
    'table_updated_at' => 'Güncellenme Tarihi',
    
    // Validation messages
    'title_required' => 'Başlık alanı zorunludur.',
    'title_max' => 'Başlık en fazla :max karakter olabilir.',
    'slug_required' => 'URL yolu alanı zorunludur.',
    'slug_unique' => 'Bu URL yolu zaten kullanılıyor.',
    'slug_max' => 'URL yolu en fazla :max karakter olabilir.',
    'content_required' => 'İçerik alanı zorunludur.',
    'meta_title_max' => 'Meta başlık en fazla :max karakter olabilir.',
    'meta_description_max' => 'Meta açıklama en fazla :max karakter olabilir.',
];
```

### 10. İngilizce Dil Dosyası Template

```php
<?php

return [
    // General
    'title' => 'Module Title',
    'navigation_label' => 'Module Navigation',
    'model_label' => 'Module',
    'plural_model_label' => 'Modules',
    
    // Actions
    'create' => 'Create New Module',
    'edit' => 'Edit Module',
    'delete' => 'Delete Module',
    'restore' => 'Restore Module',
    'force_delete' => 'Force Delete',
    
    // Form fields
    'title_field' => 'Title',
    'slug_field' => 'URL Slug',
    'content_field' => 'Content',
    'status_field' => 'Status',
    'meta_title_field' => 'Meta Title',
    'meta_description_field' => 'Meta Description',
    'published_at_field' => 'Published At',
    
    // Status options
    'status_draft' => 'Draft',
    'status_published' => 'Published',
    'status_archived' => 'Archived',
    
    // Messages
    'created_successfully' => 'Module created successfully.',
    'updated_successfully' => 'Module updated successfully.',
    'deleted_successfully' => 'Module deleted successfully.',
    'restored_successfully' => 'Module restored successfully.',
    
    // Table columns
    'table_title' => 'Title',
    'table_slug' => 'URL Slug',
    'table_status' => 'Status',
    'table_published_at' => 'Published At',
    'table_created_at' => 'Created At',
    'table_updated_at' => 'Updated At',
    
    // Validation messages
    'title_required' => 'The title field is required.',
    'title_max' => 'The title may not be greater than :max characters.',
    'slug_required' => 'The URL slug field is required.',
    'slug_unique' => 'This URL slug is already taken.',
    'slug_max' => 'The URL slug may not be greater than :max characters.',
    'content_required' => 'The content field is required.',
    'meta_title_max' => 'The meta title may not be greater than :max characters.',
    'meta_description_max' => 'The meta description may not be greater than :max characters.',
];
```

## Kullanım Rehberi

### 1. Yeni Modül Oluşturma Adımları

1. **Model ve Migration Oluştur**
```bash
php artisan make:model ModuleName -m
```

2. **Filament Resource Oluştur**
```bash
php artisan make:filament-resource ModuleName --generate
```

3. **Dil Dosyalarını Oluştur**
```bash
touch lang/tr/module_names.php
touch lang/en/module_names.php
```

4. **Template Dosyalarını Kopyala ve Düzenle**
- Model dosyasını template'e göre düzenle
- Migration dosyasını template'e göre düzenle
- Resource dosyasını template'e göre düzenle
- Page dosyalarını template'e göre düzenle
- Form ve Table dosyalarını template'e göre düzenle
- Dil dosyalarını template'e göre düzenle

5. **Test Et**
```bash
php artisan test
```

### 2. Özelleştirme

- **Form Alanları**: `ModuleNameForm.php` dosyasında form alanlarını ekle/çıkar
- **Tablo Sütunları**: `ModuleNamesTable.php` dosyasında sütunları ekle/çıkar
- **Validasyon**: Form alanlarında validation kuralları ekle
- **Filtreler**: Tablo filtrelerini ekle
- **İlişkiler**: Model'de ilişkileri tanımla

### 3. Best Practices

- ✅ **Naming**: Tutarlı isimlendirme kullan
- ✅ **Localization**: Tüm metinler için çeviri sağla
- ✅ **Validation**: Kapsamlı validation kuralları ekle
- ✅ **Testing**: Test dosyaları yaz
- ✅ **Documentation**: Dokümantasyonu güncel tut
- ❌ **Hardcoded**: Metinleri hardcode etme
- ❌ **Validation**: Validation'ı atlama
- ❌ **Testing**: Test yazmayı unutma

## Sonuç

Bu template yapısı, Citrus Platform'da tutarlı ve ölçeklenebilir modül geliştirme sağlar. Pages modülü, bu template'in uygulandığı örnek modüldür ve tüm yeni modüller için referans alınmalıdır.

### Önemli Noktalar:
1. **Tutarlılık**: Tüm modüller aynı yapıyı kullanmalı
2. **Localization**: Çoklu dil desteği sağlanmalı
3. **Validation**: Kapsamlı form doğrulama yapılmalı
4. **Testing**: Test coverage sağlanmalı
5. **Documentation**: Dokümantasyon güncel tutulmalı
