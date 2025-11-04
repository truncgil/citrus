# Page Section Builder - Kullanım Kılavuzu

## 📋 Genel Bakış

Page Section Builder, Filament Admin panelinden sayfalarınıza dinamik bölümler (sections) eklemenizi sağlayan güçlü bir modüldür. Settings modülünden esinlenerek geliştirilmiş olup, esnek bir key-value-type sistemi kullanır.

## ✨ Özellikler

- **Dinamik Section Tipleri**: Hero, Features, Stats, CTA, Gallery, Testimonials ve daha fazlası
- **Esnek Data Yönetimi**: Her section için sınırsız key-value çifti
- **Çoklu Value Tipleri**: Text, Image, HTML, Rich Text, Markdown, Color, Date, Array ve daha fazlası
- **Sürükle-Bırak Sıralama**: Sections ve data fields'ları yeniden sıralayabilme
- **Kolay Entegrasyon**: Mevcut sayfalarda sorunsuz çalışır

## 🎯 Section Tipleri

Aşağıdaki section tipleri mevcuttur:

| Tip | Açıklama | Kullanım Alanı |
|-----|----------|----------------|
| `hero` | Hero (Ana Banner) | Sayfa başlığı, büyük görsel banner |
| `features` | Özellikler | Ürün/hizmet özellikleri listesi |
| `stats` | İstatistikler | Sayısal veriler, başarı metrikleri |
| `cta` | Harekete Geçirme | Kullanıcıyı yönlendirme butonları |
| `content` | İçerik | Genel içerik blokları |
| `gallery` | Galeri | Görsel galeri |
| `testimonials` | Referanslar | Müşteri yorumları |
| `team` | Ekip | Ekip üyeleri |
| `pricing` | Fiyatlandırma | Fiyat tabloları |
| `faq` | SSS | Sık sorulan sorular |
| `contact` | İletişim | İletişim formu |
| `custom` | Özel | Özel içerik |

## 📝 Value Tipleri

Her data field'ı için aşağıdaki value tipleri kullanılabilir:

### Metin Tipleri
- **Text**: Kısa tek satırlık metin (başlık, URL, e-posta, telefon)
- **Textarea**: Uzun metin
- **HTML**: Ham HTML kodu
- **Markdown**: Markdown formatı
- **Rich Text**: WYSIWYG zengin metin editörü

### Medya Tipleri
- **Image**: Görsel yükleme (otomatik image editor ile)
- **File**: Dosya yükleme
- **Color**: Renk seçici

### Veri Tipleri
- **Number**: Sayısal değer
- **Boolean**: Evet/Hayır (Toggle)
- **Date**: Tarih seçici
- **DateTime**: Tarih & saat seçici
- **Array**: Dizi (repeater)
- **JSON**: JSON formatı

## 🔧 Admin Panelinde Kullanım

### 1. Yeni Section Ekleme

1. **Pages** modülünden bir sayfa açın veya yeni sayfa oluşturun
2. **Sayfa Bölümleri** (Page Sections) sekmesine gidin
3. **Yeni Bölüm Ekle** butonuna tıklayın
4. Section tipini seçin (örn: Hero, Features)
5. **Yeni Alan Ekle** ile section data'larını ekleyin

### 2. Data Field Ekleme

Her section için data field'ları eklerken:

1. **Key (Anahtar)**: Data'nın anahtarı (örn: `title`, `subtitle`, `image`)
2. **Type (Değer Tipi)**: Değerin tipini seçin (örn: Text, Image, HTML)
3. **Value (Değer)**: Seçilen tipe göre değeri girin

### 3. Örnek: Hero Section Oluşturma

```
Section Type: Hero (Ana Banner)

Data Fields:
┌─────────────────────────────────────────┐
│ Key: background_image                   │
│ Type: Image                             │
│ Value: [Upload Image]                   │
├─────────────────────────────────────────┤
│ Key: badge                              │
│ Type: Text                              │
│ Value: "YENİ PLATFORM"                  │
├─────────────────────────────────────────┤
│ Key: title                              │
│ Type: HTML                              │
│ Value: "Modern <span>Web</span>"        │
├─────────────────────────────────────────┤
│ Key: subtitle                           │
│ Type: Textarea                          │
│ Value: "Açıklama metni..."              │
├─────────────────────────────────────────┤
│ Key: button_text                        │
│ Type: Text                              │
│ Value: "Hemen Başla"                    │
├─────────────────────────────────────────┤
│ Key: button_url                         │
│ Type: URL                               │
│ Value: "#features"                      │
└─────────────────────────────────────────┘
```

## 💻 Kod Kullanımı

### Page Model'de Sections Kullanımı

```php
// Bir sayfayı al
$page = Page::find(1);

// Tüm parsed sections'ları al (key-value formatında)
$sections = $page->parsed_sections;

// Örnek çıktı:
[
    [
        'type' => 'hero',
        'data' => [
            'background_image' => 'path/to/image.jpg',
            'badge' => 'YENİ PLATFORM',
            'title' => 'Modern <span>Web</span>',
            'subtitle' => 'Açıklama metni...',
            'button_text' => 'Hemen Başla',
            'button_url' => '#features',
        ]
    ],
    [
        'type' => 'features',
        'data' => [...]
    ]
]

// Belirli bir section tipinin data'sını al
$heroData = $page->getSectionData('hero'); // İlk hero section
$secondHero = $page->getSectionData('hero', 1); // İkinci hero section
```

### Controller'da Kullanım

```php
public function show($slug)
{
    $page = Page::where('slug', $slug)->firstOrFail();
    
    // Parsed sections otomatik olarak view'e gönderilir
    $sections = $page->parsed_sections;
    
    return view('templates.home', compact('page', 'sections'));
}
```

### Blade Template'de Kullanım

```blade
@foreach($sections as $section)
    @if($section['type'] === 'hero')
        <x-blocks.hero :data="$section['data']" />
    
    @elseif($section['type'] === 'features')
        <x-blocks.features :data="$section['data']" />
    
    @elseif($section['type'] === 'stats')
        <x-blocks.stats :data="$section['data']" />
    
    @endif
@endforeach
```

### Component'te Data Kullanımı

```blade
{{-- resources/views/components/blocks/hero.blade.php --}}

@props(['data'])

<section style="background-image: url({{ asset($data['background_image'] ?? '') }})">
    <div class="container">
        @if(isset($data['badge']))
            <span class="badge">{{ $data['badge'] }}</span>
        @endif
        
        @if(isset($data['title']))
            <h1>{!! $data['title'] !!}</h1>
        @endif
        
        @if(isset($data['subtitle']))
            <p>{{ $data['subtitle'] }}</p>
        @endif
        
        @if(isset($data['button_text']) && isset($data['button_url']))
            <a href="{{ $data['button_url'] }}" class="btn">
                {{ $data['button_text'] }}
            </a>
        @endif
    </div>
</section>
```

## 🎨 Best Practices

### 1. Key Naming (Anahtar İsimlendirme)

Tutarlı ve açıklayıcı key isimleri kullanın:

```
✅ İYİ:
- title
- subtitle
- background_image
- primary_button_text
- primary_button_url

❌ KÖTÜ:
- baslik
- resim1
- text
- btn
```

### 2. Value Type Seçimi

Doğru value tipini seçin:

```
✅ title → Text (kısa başlık)
✅ description → Textarea (uzun açıklama)
✅ content → Rich Text (formatlanmış içerik)
✅ banner → Image (görsel)
✅ is_active → Boolean (aktif/pasif)
```

### 3. Section Organization

Benzer section'ları gruplandırın:

```
1. Hero (Giriş)
2. Features (Özellikler)
3. Stats (İstatistikler)
4. CTA (Harekete Geçirme)
5. Contact (İletişim)
```

## 🔄 Mevcut Data Migrasyon

Eğer eski formatınız varsa (örn: PageSeeder'daki gibi), parse edilmiş format otomatik olarak çalışır:

```php
// ESKİ FORMAT (PageSeeder'dan)
'sections' => [
    [
        'type' => 'hero',
        'data' => [
            'title' => 'Başlık',
            'subtitle' => 'Alt başlık'
        ]
    ]
]

// YENİ FORMAT (Admin'den girilince)
'sections' => [
    [
        'type' => 'hero',
        'data' => [
            ['key' => 'title', 'type' => 'text', 'value' => 'Başlık'],
            ['key' => 'subtitle', 'type' => 'text', 'value' => 'Alt başlık']
        ]
    ]
]

// parsed_sections attribute her ikisini de doğru parse eder!
```

## 🚀 İleri Seviye Özellikler

### Nested Arrays (İç İçe Diziler)

`Array` value tipi ile iç içe veri yapıları oluşturabilirsiniz:

```
Section Type: Features

Data Field:
Key: features
Type: Array
Value: [
    { item: "Hızlı Çözümler" },
    { item: "Güvenli Altyapı" },
    { item: "Uzman Ekip" }
]
```

### JSON Data

Kompleks veri yapıları için JSON kullanabilirsiniz:

```
Key: configuration
Type: JSON
Value: {"layout": "grid", "columns": 3, "gap": 20}
```

### Conditional Rendering

```blade
@foreach($sections as $section)
    @php
        $data = $section['data'];
        $bgClass = $data['bg_class'] ?? '';
    @endphp
    
    <section class="{{ $bgClass }}">
        @includeIf("components.blocks.{$section['type']}", compact('data'))
    </section>
@endforeach
```

## 📚 Dosya Yapısı

```
app/
├── Models/
│   └── Page.php (getParsedSectionsAttribute, getSectionData)
├── Http/Controllers/
│   └── PageController.php (parsed_sections kullanımı)
└── Filament/Admin/Resources/Pages/
    └── Schemas/
        └── PageForm.php (Section Builder UI)

lang/
├── tr/
│   └── pages.php (Türkçe çeviriler)
└── en/
    └── pages.php (İngilizce çeviriler)

resources/views/
├── components/blocks/
│   ├── hero.blade.php
│   ├── features.blade.php
│   ├── stats.blade.php
│   └── cta.blade.php
└── templates/
    └── home.blade.php (sections render)
```

## 🐛 Troubleshooting

### Section görünmüyor?

1. `$page->parsed_sections` döndüğünden emin olun
2. Section type'ının doğru yazıldığını kontrol edin
3. Blade component'in var olduğunu doğrulayın

### Data değerleri boş?

1. Admin'de data field'larının key değerlerini kontrol edin
2. Value tipinin doğru seçildiğini doğrulayın
3. Değerlerin kaydedildiğini kontrol edin

### Image görünmüyor?

1. `storage` link'inin oluşturulduğunu kontrol edin: `php artisan storage:link`
2. Image path'inin doğru olduğunu doğrulayın
3. Disk ayarlarını kontrol edin (`config/filesystems.php`)

## 🎓 Örnekler

Daha fazla örnek için:
- `database/seeders/PageSeeder.php` - Mevcut section örnekleri
- `resources/views/components/blocks/` - Component örnekleri
- `resources/views/templates/home.blade.php` - Template örneği

## 📞 Destek

Sorunlarınız için:
1. Bu dokümantasyonu kontrol edin
2. `docs/CURSOR_RULES.md` dosyasına bakın
3. Loglara göz atın: `storage/logs/laravel.log`

---

**Not:** Bu sistem Settings modülünden esinlenerek geliştirilmiş olup, aynı esneklik ve güçle çalışır. Her türlü dinamik sayfa içeriği için kullanılabilir.

