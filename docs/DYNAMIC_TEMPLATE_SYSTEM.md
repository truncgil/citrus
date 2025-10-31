# Dynamic Template System (Dinamik Şablon Sistemi)

## Genel Bakış

Bu sistem, sayfalara dinamik header, section ve footer şablonları ekleyerek içerik yönetimini tamamen özelleştirilebilir hale getirir.

## Mimari

### 1. Template Modülleri

#### 1.1 Header Template
- **Tablo:** `header_templates`
- **Alanlar:**
  - `id` (bigint, PK)
  - `title` (string, 255) - Şablon başlığı
  - `html_content` (longtext) - HTML içerik + placeholder'lar ✅ **4GB kapasiteli**
  - `is_active` (boolean) - Aktif/Pasif
  - `created_at`, `updated_at`, `deleted_at`

#### 1.2 Section Template
- **Tablo:** `section_templates`
- **Alanlar:**
  - `id` (bigint, PK)
  - `title` (string, 255) - Şablon başlığı
  - `html_content` (longtext) - HTML içerik + placeholder'lar ✅ **4GB kapasiteli**
  - `is_active` (boolean) - Aktif/Pasif
  - `created_at`, `updated_at`, `deleted_at`

#### 1.3 Footer Template
- **Tablo:** `footer_templates`
- **Alanlar:**
  - `id` (bigint, PK)
  - `title` (string, 255) - Şablon başlığı
  - `html_content` (longtext) - HTML içerik + placeholder'lar ✅ **4GB kapasiteli**
  - `is_active` (boolean) - Aktif/Pasif
  - `created_at`, `updated_at`, `deleted_at`

**Not:** `longtext` veri tipi MySQL'de **4,294,967,295 karakter** (4GB) kapasiteye sahiptir. Bu, en karmaşık HTML template'ler ve zengin içerikler için fazlasıyla yeterlidir.

### 2. Placeholder Sistemi

#### 2.1 Placeholder Formatı
```
{form_type.field_name}
```

**Desteklenen Form Tipleri:**

#### Text Input Variants:
- `text` → TextInput (basic text)
- `email` → TextInput (email validation)
- `url` → TextInput (URL validation)
- `tel` → TextInput (telephone)
- `number` → TextInput (numeric)
- `password` → TextInput (password)

#### Text Area & Editors:
- `textarea` → Textarea (multi-line text)
- `richtext` → RichEditor (WYSIWYG HTML editor)
- `markdown` → MarkdownEditor (Markdown editor with preview)
- `code` → CodeEditor (syntax highlighted code)

#### Date & Time:
- `date` → DatePicker (date only)
- `datetime` → DateTimePicker (date + time)
- `time` → TimePicker (time only)

#### File Uploads:
- `image` → FileUpload (image only, with preview)
- `file` → FileUpload (any file type)
- `files` → FileUpload (multiple files)
- `images` → FileUpload (multiple images)

#### Selection & Options:
- `select` → Select (dropdown selection)
- `multiselect` → Select (multiple selection)
- `checkbox` → Checkbox (single checkbox)
- `checkboxlist` → CheckboxList (multiple checkboxes)
- `radio` → Radio (radio buttons)
- `toggle` → Toggle (switch button)
- `togglebuttons` → ToggleButtons (button group)

#### Color & Visual:
- `color` → ColorPicker (color picker)

#### Structured Data:
- `tags` → TagsInput (tag input)
- `keyvalue` → KeyValue (key-value pairs)
- `repeater` → Repeater (repeatable fields - not recommended in template)
- `builder` → Builder (block builder - not recommended in template)

#### Advanced:
- `slider` → Slider (range slider)
- `hidden` → Hidden (hidden field for calculations)

**Toplam: 30+ Form Tipi Desteği**

#### Form Tipi Referans Tablosu

| Placeholder Type | Filament Component | Örnek Kullanım | Veri Tipi | Max Boyut |
|-----------------|-------------------|----------------|-----------|-----------|
| `{text.name}` | TextInput | Kısa metinler | string | 255 char |
| `{email.address}` | TextInput (email) | E-posta adresleri | string | 255 char |
| `{url.link}` | TextInput (url) | Web adresleri | string | 500 char |
| `{tel.phone}` | TextInput (tel) | Telefon numaraları | string | 20 char |
| `{number.count}` | TextInput (numeric) | Sayısal değerler | integer/float | - |
| `{password.pass}` | TextInput (password) | Şifreler | string (hashed) | 255 char |
| `{textarea.desc}` | Textarea | Çok satırlı metin | string | 5000 char |
| `{richtext.content}` | RichEditor | HTML içerik | longtext | 50000 char |
| `{markdown.post}` | MarkdownEditor | Markdown içerik | longtext | 50000 char |
| `{code.snippet}` | CodeEditor | Kod blokları | longtext | 50000 char |
| `{date.birthday}` | DatePicker | Tarih seçimi | date | - |
| `{datetime.event}` | DateTimePicker | Tarih + saat | datetime | - |
| `{time.opening}` | TimePicker | Saat seçimi | time | - |
| `{image.banner}` | FileUpload | Tek resim | string (path) | 5MB |
| `{images.gallery}` | FileUpload (multiple) | Çoklu resim | json (paths) | 10x5MB |
| `{file.document}` | FileUpload | Tek dosya | string (path) | 10MB |
| `{files.attachments}` | FileUpload (multiple) | Çoklu dosya | json (paths) | 10x10MB |
| `{select.category}` | Select | Tekli seçim | string/int | - |
| `{multiselect.tags}` | Select (multiple) | Çoklu seçim | json (array) | - |
| `{checkbox.agree}` | Checkbox | Tekli checkbox | boolean | - |
| `{checkboxlist.options}` | CheckboxList | Checkbox listesi | json (array) | - |
| `{radio.gender}` | Radio | Radio button | string/int | - |
| `{toggle.active}` | Toggle | Açık/Kapalı | boolean | - |
| `{togglebuttons.size}` | ToggleButtons | Buton grubu | string | - |
| `{color.theme}` | ColorPicker | Renk seçici | string (hex) | 7 char |
| `{tags.keywords}` | TagsInput | Etiket girişi | json (array) | - |
| `{keyvalue.meta}` | KeyValue | Anahtar-değer | json (object) | - |
| `{slider.volume}` | Slider | Kaydırıcı | integer | - |
| `{hidden.calc}` | Hidden | Gizli alan | mixed | - |

#### 2.2 Örnek Template (Comprehensive)
```html
<header class="site-header" style="background-color: {color.header_bg};">
    <div class="container">
        <!-- Logo Section -->
        <div class="logo">
            <img src="{image.logo}" alt="{text.company_name}">
            <span class="tagline">{textarea.tagline}</span>
        </div>
        
        <!-- Navigation -->
        <nav class="main-nav">
            {richtext.menu_html}
        </nav>
        
        <!-- Contact Info -->
        <div class="contact-info">
            <a href="mailto:{email.contact_email}">{email.contact_email}</a>
            <a href="tel:{tel.phone}">{tel.phone}</a>
        </div>
        
        <!-- Social Links -->
        <div class="social-links">
            <a href="{url.facebook_link}" target="_blank">Facebook</a>
            <a href="{url.twitter_link}" target="_blank">Twitter</a>
            <a href="{url.linkedin_link}" target="_blank">LinkedIn</a>
        </div>
        
        <!-- Toggle Features -->
        <div class="features">
            {toggle.show_search}
            {toggle.show_cart}
        </div>
    </div>
</header>

<!-- CSS Snippet -->
<style>
    .site-header {
        padding: {number.padding}px;
        opacity: {slider.opacity}%;
    }
</style>
```

**Bu template şu form alanlarını oluşturur:**
- Logo (FileUpload - image)
- Company Name (TextInput)
- Tagline (Textarea)
- Menu HTML (RichEditor)
- Contact Email (TextInput - email)
- Phone (TextInput - tel)
- Facebook Link (TextInput - url)
- Twitter Link (TextInput - url)
- LinkedIn Link (TextInput - url)
- Show Search (Toggle)
- Show Cart (Toggle)
- Header BG (ColorPicker)
- Padding (TextInput - number)
- Opacity (Slider)

### 3. Pages Modülü Entegrasyonu

#### 3.1 Pages Tablo Güncellemesi
```php
// Migration: add_template_fields_to_pages_table
Schema::table('pages', function (Blueprint $table) {
    $table->foreignId('header_template_id')->nullable()->constrained('header_templates')->nullOnDelete();
    $table->json('header_data')->nullable(); // Header placeholder değerleri
    
    $table->foreignId('footer_template_id')->nullable()->constrained('footer_templates')->nullOnDelete();
    $table->json('footer_data')->nullable(); // Footer placeholder değerleri
    
    // sections_data -> Repeater ile sections (eski page_sections yerine)
    // Format: [
    //   {
    //     'section_template_id': 1,
    //     'section_data': { 'text.title': 'Başlık', 'image.banner': 'path/to/image.jpg' }
    //   },
    //   ...
    // ]
    $table->json('sections_data')->nullable();
});
```

**Veri Tipi Notları:**
- `json` column tipi: MySQL 5.7.8+ ve PostgreSQL 9.4+ destekli
- JSON alanlar Laravel tarafından otomatik encode/decode edilir
- `longtext` alternatifi: Tüm veritabanlarıyla uyumlu (Laravel JSON cast ile)
- Her iki durumda da Laravel'in `$casts = ['header_data' => 'array']` özelliği kullanılır

#### 3.2 Page Model İlişkileri
```php
class Page extends Model
{
    public function headerTemplate()
    {
        return $this->belongsTo(HeaderTemplate::class);
    }
    
    public function footerTemplate()
    {
        return $this->belongsTo(FooterTemplate::class);
    }
    
    // sections_data JSON içinde section_template_id'ler var
    public function getSectionsAttribute()
    {
        $sectionsData = $this->sections_data ?? [];
        return collect($sectionsData)->map(function ($section) {
            return [
                'template' => SectionTemplate::find($section['section_template_id']),
                'data' => $section['section_data'] ?? [],
            ];
        });
    }
}
```

### 4. Filament Form Yapısı

#### 4.1 Page Form (PageForm.php)
```php
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;

Tabs::make('PageTabs')
    ->tabs([
        Tab::make('Genel Bilgiler')
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('slug')->required(),
                // ... diğer genel alanlar
            ]),
        
        Tab::make('Header Template')
            ->schema([
                Select::make('header_template_id')
                    ->label('Header Template')
                    ->options(HeaderTemplate::where('is_active', true)->pluck('title', 'id'))
                    ->live()
                    ->afterStateUpdated(fn ($state, Set $set) => $set('header_data', [])),
                
                // Dinamik header alanları
                Group::make()
                    ->schema(fn (Get $get) => self::generateDynamicFields(
                        HeaderTemplate::find($get('header_template_id')),
                        'header_data'
                    ))
                    ->visible(fn (Get $get) => filled($get('header_template_id'))),
            ]),
        
        Tab::make('Sections')
            ->schema([
                Repeater::make('sections_data')
                    ->schema([
                        Select::make('section_template_id')
                            ->label('Section Template')
                            ->options(SectionTemplate::where('is_active', true)->pluck('title', 'id'))
                            ->live()
                            ->required(),
                        
                        // Dinamik section alanları
                        Group::make()
                            ->schema(fn (Get $get, $record) => self::generateDynamicFields(
                                SectionTemplate::find($get('section_template_id')),
                                'section_data'
                            ))
                            ->visible(fn (Get $get) => filled($get('section_template_id'))),
                    ])
                    ->itemLabel(fn (array $state): ?string => 
                        SectionTemplate::find($state['section_template_id'] ?? null)?->title ?? 'Section'
                    )
                    ->collapsible()
                    ->reorderable()
                    ->addActionLabel(__('pages.add_section')),
            ]),
        
        Tab::make('Footer Template')
            ->schema([
                Select::make('footer_template_id')
                    ->label('Footer Template')
                    ->options(FooterTemplate::where('is_active', true)->pluck('title', 'id'))
                    ->live()
                    ->afterStateUpdated(fn ($state, Set $set) => $set('footer_data', [])),
                
                // Dinamik footer alanları
                Group::make()
                    ->schema(fn (Get $get) => self::generateDynamicFields(
                        FooterTemplate::find($get('footer_template_id')),
                        'footer_data'
                    ))
                    ->visible(fn (Get $get) => filled($get('footer_template_id'))),
            ]),
    ]);
```

#### 4.2 Dinamik Form Generator
```php
use Filament\Forms\Components\{
    TextInput, Textarea, Select, Checkbox, CheckboxList,
    Radio, Toggle, ToggleButtons, DateTimePicker, DatePicker,
    TimePicker, FileUpload, RichEditor, MarkdownEditor, 
    ColorPicker, TagsInput, KeyValue, CodeEditor, Hidden, Slider
};

protected static function generateDynamicFields($template, string $dataKey): array
{
    if (!$template) return [];
    
    $placeholders = self::parsePlaceholders($template->html_content);
    $fields = [];
    
    foreach ($placeholders as $placeholder) {
        [$type, $name] = explode('.', $placeholder);
        
        $label = str($name)->title()->replace('_', ' ')->toString();
        
        $field = match($type) {
            // Text Input Variants
            'text' => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->maxLength(255),
            
            'email' => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->email()
                ->maxLength(255),
            
            'url' => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->url()
                ->maxLength(500),
            
            'tel' => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->tel()
                ->maxLength(20),
            
            'number' => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->numeric(),
            
            'password' => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->password()
                ->dehydrated(fn ($state) => filled($state))
                ->maxLength(255),
            
            // Text Area & Editors
            'textarea' => Textarea::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->rows(4)
                ->maxLength(5000),
            
            'richtext' => RichEditor::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->toolbarButtons([
                    'bold', 'italic', 'underline', 'link',
                    'bulletList', 'orderedList', 'h2', 'h3',
                ])
                ->maxLength(50000),
            
            'markdown' => MarkdownEditor::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->toolbarButtons([
                    'bold', 'italic', 'strike', 'link',
                    'heading', 'bulletList', 'orderedList', 'codeBlock',
                ])
                ->maxLength(50000),
            
            'code' => CodeEditor::make("{$dataKey}.{$placeholder}")
                ->label($label)
                //->lineNumbers()
                ->maxLength(50000),
            
            // Date & Time
            'date' => DatePicker::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->native(false),
            
            'datetime' => DateTimePicker::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->native(false)
                ->seconds(false),
            
            'time' => TimePicker::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->native(false)
                ->seconds(false),
            
            // File Uploads
            'image' => FileUpload::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatios([
                    null,
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->directory('templates/images')
                ->maxSize(5120),
            
            'images' => FileUpload::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->image()
                ->multiple()
                ->imageEditor()
                ->directory('templates/images')
                ->maxSize(5120)
                ->maxFiles(10),
            
            'file' => FileUpload::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->directory('templates/files')
                ->maxSize(10240),
            
            'files' => FileUpload::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->multiple()
                ->directory('templates/files')
                ->maxSize(10240)
                ->maxFiles(10),
            
            // Selection & Options
            'select' => Select::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->options(self::getSelectOptions($name))
                ->searchable(),
            
            'multiselect' => Select::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->multiple()
                ->options(self::getSelectOptions($name))
                ->searchable(),
            
            'checkbox' => Checkbox::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->inline(false),
            
            'checkboxlist' => CheckboxList::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->options(self::getSelectOptions($name))
                ->columns(2),
            
            'radio' => Radio::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->options(self::getSelectOptions($name))
                ->inline()
                ->inlineLabel(false),
            
            'toggle' => Toggle::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->inline(false),
            
            'togglebuttons' => ToggleButtons::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->options(self::getSelectOptions($name))
                ->inline()
                ->grouped(),
            
            // Color & Visual
            'color' => ColorPicker::make("{$dataKey}.{$placeholder}")
                ->label($label),
            
            // Structured Data
            'tags' => TagsInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->separator(','),
            
            'keyvalue' => KeyValue::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->keyLabel('Key')
                ->valueLabel('Value')
                ->reorderable(),
            
            // Advanced
            'slider' => Slider::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->minValue(0)
                ->maxValue(100)
                ->step(1),
            
            'hidden' => Hidden::make("{$dataKey}.{$placeholder}"),
            
            // Default
            default => TextInput::make("{$dataKey}.{$placeholder}")
                ->label($label)
                ->maxLength(255)
                ->helperText("Unknown type: {$type}"),
        };
        
        $fields[] = $field;
    }
    
    return $fields;
}

/**
 * Select, MultiSelect, CheckboxList, Radio, ToggleButtons için
 * dinamik options yükler. Gerçek uygulamada config veya database'den
 * okunabilir.
 */
protected static function getSelectOptions(string $fieldName): array
{
    // Örnek: config/template-options.php dosyasından okuyabilirsiniz
    return config("template-options.{$fieldName}", [
        'option_1' => 'Option 1',
        'option_2' => 'Option 2',
        'option_3' => 'Option 3',
    ]);
}

/**
 * Template HTML içeriğindeki placeholder'ları parse eder
 * Desteklenen format: {type.field_name}
 */
protected static function parsePlaceholders(string $html): array
{
    // Regex: {word.word_with_underscores}
    preg_match_all('/\{([a-z]+\.[a-z_]+)\}/i', $html, $matches);
    return array_unique($matches[1] ?? []);
}
```

### 5. Frontend Rendering

#### 5.1 Blade Component (PageRenderer)
```php
// app/View/Components/PageRenderer.php
class PageRenderer extends Component
{
    public function __construct(public Page $page) {}
    
    public function render()
    {
        return view('components.page-renderer');
    }
    
    public function renderHeader()
    {
        if (!$this->page->headerTemplate) return '';
        
        return $this->replaceePlaceholders(
            $this->page->headerTemplate->html_content,
            $this->page->header_data ?? []
        );
    }
    
    public function renderSections()
    {
        return collect($this->page->sections)->map(function ($section) {
            return $this->replacePlaceholders(
                $section['template']->html_content,
                $section['data']
            );
        })->implode('');
    }
    
    public function renderFooter()
    {
        if (!$this->page->footerTemplate) return '';
        
        return $this->replacePlaceholders(
            $this->page->footerTemplate->html_content,
            $this->page->footer_data ?? []
        );
    }
    
    protected function replacePlaceholders(string $html, array $data): string
    {
        foreach ($data as $placeholder => $value) {
            // {text.name} → value
            $html = str_replace("{{$placeholder}}", $value, $html);
        }
        return $html;
    }
}
```

#### 5.2 Blade View
```blade
<!-- resources/views/components/page-renderer.blade.php -->
<div class="page-wrapper">
    {!! $renderHeader() !!}
    
    <main class="page-content">
        {!! $renderSections() !!}
    </main>
    
    {!! $renderFooter() !!}
</div>
```

### 6. Navigasyon Yapısı

```php
// Filament Panel Provider
->navigationGroups([
    'Template' => [
        'icon' => 'heroicon-o-document-duplicate',
        'order' => 3,
    ],
])

// Her Resource'da
public static function getNavigationGroup(): string
{
    return 'Template';
}
```

## Dosya Yapısı

```
app/
├── Models/
│   ├── HeaderTemplate.php
│   ├── SectionTemplate.php
│   └── FooterTemplate.php
├── Filament/Admin/Resources/
│   ├── HeaderTemplates/
│   │   ├── HeaderTemplateResource.php
│   │   ├── Pages/
│   │   ├── Schemas/
│   │   └── Tables/
│   ├── SectionTemplates/
│   │   ├── SectionTemplateResource.php
│   │   ├── Pages/
│   │   ├── Schemas/
│   │   └── Tables/
│   └── FooterTemplates/
│       ├── FooterTemplateResource.php
│       ├── Pages/
│       ├── Schemas/
│       └── Tables/
├── View/Components/
│   └── PageRenderer.php
└── Services/
    └── TemplateService.php (helper methods)

database/migrations/
├── create_header_templates_table.php
├── create_section_templates_table.php
├── create_footer_templates_table.php
└── add_template_fields_to_pages_table.php

lang/
├── tr/
│   ├── header-templates.php
│   ├── section-templates.php
│   └── footer-templates.php
└── en/
    ├── header-templates.php
    ├── section-templates.php
    └── footer-templates.php

resources/views/
└── components/
    └── page-renderer.blade.php
```

## Örnek Kullanım Senaryosu

### 1. Template Tanımlama
**Header Template:**
```html
<header>
    <img src="{image.logo}" alt="{text.site_name}">
    <nav>{richtext.menu_html}</nav>
    <a href="mailto:{email.contact}">{email.contact}</a>
</header>
```

### 2. Page'de Template Seçimi
- Header Template: "Ana Header" seçildi
- Dinamik alanlar açıldı:
  - Logo (FileUpload)
  - Site Name (TextInput)
  - Menu HTML (RichEditor)
  - Contact Email (TextInput)
- Values dolduruldu ve kaydedildi

### 3. Frontend'de Görüntüleme
```blade
<x-page-renderer :page="$page" />
```

Output:
```html
<header>
    <img src="/storage/uploads/logo.png" alt="My Company">
    <nav><ul><li><a href="/">Home</a></li></ul></nav>
    <a href="mailto:info@company.com">info@company.com</a>
</header>
```

## Avantajlar

1. ✅ **Tamamen Dinamik**: Kod değişikliği olmadan yeni template'ler eklenebilir
2. ✅ **Yeniden Kullanılabilir**: Aynı template birden fazla sayfada kullanılabilir
3. ✅ **Kolay Yönetim**: Admin panel üzerinden HTML düzenlenebilir
4. ✅ **Tip Güvenli**: Placeholder'lar form tipini belirler
5. ✅ **Ölçeklenebilir**: Yeni form tipleri kolayca eklenebilir
6. ✅ **SEO Dostu**: Her sayfa kendi içeriğine sahip
7. ✅ **Performanslı**: Sadece seçili template'ler yüklenir
8. ✅ **30+ Form Tipi**: Filament 4.x'in tüm form component'leri destekleniyor
9. ✅ **Zengin İçerik**: HTML, Markdown, Code editor desteği
10. ✅ **Büyük Veri**: longtext ile 4GB kapasiteli template'ler

## Veri Tipi Özeti

### HTML Content (Template'ler için)
```sql
html_content LONGTEXT
-- Kapasite: 4,294,967,295 karakter (4GB)
-- Kullanım: Template HTML + placeholder'lar
-- Avantaj: En karmaşık template'ler için bile yeterli
```

### JSON Data (Page verisi için)
```sql
header_data JSON
footer_data JSON
sections_data JSON
-- MySQL 5.7.8+ ve PostgreSQL 9.4+ native JSON desteği
-- Alternatif: LONGTEXT + Laravel JSON cast
-- Laravel otomatik encode/decode yapar
```

### Model Cast Kullanımı
```php
protected $casts = [
    'header_data' => 'array',
    'footer_data' => 'array',
    'sections_data' => 'array',
];
```

## Git Branch

```bash
feature/dynamic-template-system
```

## İmplement Adımları

1. ✅ Migrations oluştur (4 adet)
2. ✅ Model'ler oluştur (3 adet)
3. ✅ Filament Resources oluştur (3 adet)
4. ✅ TemplateService helper oluştur
5. ✅ PageForm'u güncelle (template tabs ekle)
6. ✅ PageRenderer component oluştur
7. ✅ Lang dosyaları oluştur (6 adet)
8. ✅ Frontend route ve controller güncelle
9. ✅ Test

---

**Not:** Bu sistem mevcut `page_sections` sisteminin yerini alacak ve çok daha güçlü bir alternatif sunacaktır.

