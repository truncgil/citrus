# Blok Tabanlı Sayfa Oluşturma Sistemi

## Genel Bakış

Sistemde 9 adet hazır blok bileşeni bulunmaktadır. Bu bloklar admin panelinden seçilip veri girilerek sayfa oluşturulabilir.

## Mevcut Bloklar

### 1. Hero (Ana Başlık)
**Kullanım:** Sayfa başlığı, açıklama, butonlar ve görsel
**Dosya:** `resources/views/components/blocks/hero.blade.php`

**Örnek Veri:**
```json
{
  "type": "hero",
  "data": {
    "background_image": "assets/img/photos/blurry.png",
    "badge": "YENİ SÜRÜM",
    "title": "Modern ve Çok Amaçlı <span class='text-[#e31e24]'>Web Çözümleri</span>",
    "subtitle": "Yenilikçi teknoloji çözümleri ile geleceği şekillendiriyoruz",
    "primary_button_text": "Hemen Başla",
    "primary_button_url": "#",
    "secondary_button_text": "Daha Fazla Bilgi",
    "secondary_button_url": "#about",
    "hero_image": "assets/img/demos/f1.png"
  }
}
```

---

### 2. Features (Özellikler Grid)
**Kullanım:** İkon + başlık + açıklama kartları
**Dosya:** `resources/views/components/blocks/features.blade.php`

**Örnek Veri:**
```json
{
  "type": "features",
  "data": {
    "bg_class": "!bg-[#f0f0f8]",
    "section_badge": "ÖZELLİKLER",
    "section_title": "Neden Bizi Tercih Etmelisiniz?",
    "section_subtitle": "Modern teknolojiler ve uzman ekibimizle projelerinizi hayata geçiriyoruz",
    "column_class": "md:w-6/12 lg:w-4/12",
    "features": [
      {
        "icon": "assets/img/icons/fast.svg",
        "title": "Hızlı Çözümler",
        "description": "Modern teknolojiler kullanarak projelerinizi hızlı ve verimli bir şekilde hayata geçiriyoruz."
      },
      {
        "icon": "assets/img/icons/secure.svg",
        "title": "Güvenli Altyapı",
        "description": "En son güvenlik standartlarını kullanarak verilerinizi koruma altına alıyoruz."
      },
      {
        "icon": "assets/img/icons/team.svg",
        "title": "Uzman Ekip",
        "description": "Deneyimli ve uzman ekibimiz ile her zaman yanınızdayız."
      }
    ]
  }
}
```

---

### 3. Stats (İstatistikler/Sayaçlar)
**Kullanım:** Sayı + açıklama istatistikleri
**Dosya:** `resources/views/components/blocks/stats.blade.php`

**Örnek Veri:**
```json
{
  "type": "stats",
  "data": {
    "bg_class": "!bg-[#ffffff]",
    "column_class": "md:w-6/12 lg:w-3/12",
    "stats": [
      {
        "icon": "assets/img/icons/project.svg",
        "number": "500+",
        "label": "Tamamlanan Proje"
      },
      {
        "icon": "assets/img/icons/client.svg",
        "number": "300+",
        "label": "Mutlu Müşteri"
      },
      {
        "icon": "assets/img/icons/award.svg",
        "number": "50+",
        "label": "Kazanılan Ödül"
      },
      {
        "icon": "assets/img/icons/team-stat.svg",
        "number": "25+",
        "label": "Ekip Üyesi"
      }
    ]
  }
}
```

---

### 4. Testimonials (Referanslar/Yorumlar)
**Kullanım:** Müşteri yorumları
**Dosya:** `resources/views/components/blocks/testimonials.blade.php`

**Örnek Veri:**
```json
{
  "type": "testimonials",
  "data": {
    "bg_class": "!bg-[#f0f0f8]",
    "section_badge": "REFERANSLAR",
    "section_title": "Müşterilerimiz Ne Diyor?",
    "section_subtitle": "Binlerce mutlu müşterimizden bazılarının görüşleri",
    "column_class": "md:w-6/12 lg:w-4/12",
    "testimonials": [
      {
        "rating": 5,
        "quote": "Harika bir ekip! Projemizi zamanında ve beklentilerimizin üzerinde teslim ettiler.",
        "avatar": "assets/img/avatars/te1.jpg",
        "name": "Ahmet Yılmaz",
        "position": "CEO, ABC Tech"
      },
      {
        "rating": 5,
        "quote": "Profesyonel yaklaşım ve mükemmel sonuç. Kesinlikle tavsiye ediyorum!",
        "avatar": "assets/img/avatars/te2.jpg",
        "name": "Ayşe Demir",
        "position": "Kurucu, XYZ Startup"
      }
    ]
  }
}
```

---

### 5. Pricing (Fiyatlandırma Tabloları)
**Kullanım:** Fiyat paketleri
**Dosya:** `resources/views/components/blocks/pricing.blade.php`

**Örnek Veri:**
```json
{
  "type": "pricing",
  "data": {
    "bg_class": "!bg-[#ffffff]",
    "section_badge": "FİYATLANDIRMA",
    "section_title": "Size Uygun Paketi Seçin",
    "section_subtitle": "Tüm paketler 30 gün para iade garantisi ile geliyor",
    "column_class": "md:w-6/12 lg:w-4/12",
    "featured_label": "Önerilen",
    "plans": [
      {
        "name": "Başlangıç",
        "currency": "₺",
        "price": "999",
        "period": "ay",
        "features": [
          "5 Sayfa",
          "Mobil Uyumlu",
          "SEO Optimizasyonu",
          "7/24 Destek"
        ],
        "button_text": "Başla",
        "button_url": "#"
      },
      {
        "name": "Profesyonel",
        "currency": "₺",
        "price": "2499",
        "period": "ay",
        "featured": true,
        "features": [
          "15 Sayfa",
          "Mobil Uyumlu",
          "SEO Optimizasyonu",
          "Yönetim Paneli",
          "7/24 Öncelikli Destek"
        ],
        "button_text": "Başla",
        "button_url": "#"
      },
      {
        "name": "Kurumsal",
        "currency": "₺",
        "price": "4999",
        "period": "ay",
        "features": [
          "Sınırsız Sayfa",
          "Mobil Uyumlu",
          "SEO Optimizasyonu",
          "Gelişmiş Yönetim Paneli",
          "Özel Entegrasyonlar",
          "7/24 Öncelikli Destek"
        ],
        "button_text": "Başla",
        "button_url": "#"
      }
    ]
  }
}
```

---

### 6. CTA (Call To Action)
**Kullanım:** Dikkat çekici aksiyon çağrısı
**Dosya:** `resources/views/components/blocks/cta.blade.php`

**Örnek Veri:**
```json
{
  "type": "cta",
  "data": {
    "bg_class": "overflow-hidden",
    "background_image": "assets/img/photos/blurry.png",
    "icon": "assets/img/demos/icon-grape.png",
    "title": "Benzersiz düşünün ve <span class='text-[#e31e24]'>fark yaratın</span>",
    "subtitle": "Binlerce müşterimiz tarafından güveniliyoruz. Siz de katılın ve kısa sürede çarpıcı web sitenizi kolayca oluşturun.",
    "button_text": "Hemen Başla",
    "button_url": "#",
    "button_icon": "uil uil-arrow-up-right",
    "cta_image": "assets/img/demos/f1.png"
  }
}
```

---

### 7. Gallery (Galeri/Portfolio)
**Kullanım:** Proje galerisi veya portfolio
**Dosya:** `resources/views/components/blocks/gallery.blade.php`

**Örnek Veri:**
```json
{
  "type": "gallery",
  "data": {
    "bg_class": "!bg-[#f0f0f8]",
    "section_badge": "PORTFOLİO",
    "section_title": "Projelerimiz",
    "section_subtitle": "Son dönemde tamamladığımız bazı projeler",
    "column_class": "md:w-6/12 lg:w-4/12",
    "items": [
      {
        "image": "assets/img/portfolio/p1.jpg",
        "category": "Web Tasarım",
        "title": "E-Ticaret Sitesi",
        "description": "Modern ve kullanıcı dostu e-ticaret platformu",
        "link": "#"
      },
      {
        "image": "assets/img/portfolio/p2.jpg",
        "category": "Mobil Uygulama",
        "title": "Fitness Uygulaması",
        "description": "iOS ve Android için fitness takip uygulaması",
        "link": "#"
      }
    ]
  }
}
```

---

### 8. Team (Ekip Üyeleri)
**Kullanım:** Ekip üyeleri tanıtımı
**Dosya:** `resources/views/components/blocks/team.blade.php`

**Örnek Veri:**
```json
{
  "type": "team",
  "data": {
    "bg_class": "!bg-[#ffffff]",
    "section_badge": "EKİBİMİZ",
    "section_title": "Arkasındaki İnsanlar",
    "section_subtitle": "Profesyonel ve deneyimli ekibimizle tanışın",
    "column_class": "md:w-6/12 lg:w-3/12",
    "members": [
      {
        "photo": "assets/img/team/t1.jpg",
        "name": "Mehmet Kaya",
        "position": "CEO & Kurucu",
        "bio": "15 yıllık teknoloji tecrübesi",
        "social": {
          "twitter": "https://twitter.com/",
          "linkedin": "https://linkedin.com/",
          "facebook": "https://facebook.com/"
        }
      },
      {
        "photo": "assets/img/team/t2.jpg",
        "name": "Zeynep Şahin",
        "position": "CTO",
        "bio": "Yazılım mimarisi uzmanı",
        "social": {
          "twitter": "https://twitter.com/",
          "linkedin": "https://linkedin.com/"
        }
      }
    ]
  }
}
```

---

### 9. Contact (İletişim Formu)
**Kullanım:** İletişim formu ve bilgileri
**Dosya:** `resources/views/components/blocks/contact.blade.php`

**Örnek Veri:**
```json
{
  "type": "contact",
  "data": {
    "bg_class": "!bg-[#f0f0f8]",
    "section_badge": "İLETİŞİM",
    "title": "Bizimle İletişime Geçin",
    "subtitle": "Projeleriniz hakkında konuşmak için bize ulaşın",
    "info": {
      "address": "Merkez Mah. Teknoloji Cad. No:123 İstanbul",
      "phone": "+90 (212) 555 1234",
      "email": "info@truncgil.com"
    },
    "form_action": "/contact/submit",
    "button_text": "Gönder"
  }
}
```

---

## Admin Panelinde Kullanım

### Page Modelinde `sections` Alanı

Admin panelinde sayfa oluştururken `sections` JSON alanına yukarıdaki blokları ekleyebilirsiniz:

```json
[
  {
    "type": "hero",
    "data": { ... }
  },
  {
    "type": "features",
    "data": { ... }
  },
  {
    "type": "pricing",
    "data": { ... }
  },
  {
    "type": "cta",
    "data": { ... }
  }
]
```

### Filament Resource'da Repeater Kullanımı

```php
Repeater::make('sections')
    ->schema([
        Select::make('type')
            ->options([
                'hero' => 'Hero (Ana Başlık)',
                'features' => 'Features (Özellikler)',
                'stats' => 'Stats (İstatistikler)',
                'testimonials' => 'Testimonials (Yorumlar)',
                'pricing' => 'Pricing (Fiyatlandırma)',
                'cta' => 'CTA (Aksiyon Çağrısı)',
                'gallery' => 'Gallery (Galeri)',
                'team' => 'Team (Ekip)',
                'contact' => 'Contact (İletişim)',
            ])
            ->required()
            ->reactive(),
        
        KeyValue::make('data')
            ->label('Blok Verileri')
            ->addActionLabel('Alan Ekle')
    ])
    ->collapsible()
    ->itemLabel(fn (array $state): ?string => $state['type'] ?? null)
```

---

## Özelleştirme

Her blok için `bg_class`, `column_class` gibi parametrelerle Tailwind CSS sınıfları özelleştirilebilir.

**Örnek:**
```json
{
  "bg_class": "!bg-gradient-to-br from-[#e31e24] to-[#ff6b6b]",
  "column_class": "md:w-4/12 lg:w-3/12"
}
```

---

## Yeni Blok Ekleme

1. `resources/views/components/blocks/` altında yeni blade dosyası oluşturun
2. `@props(['data' => []])` ile veri alın
3. HTML yapısını oluşturun
4. Admin repeater select'ine yeni tipi ekleyin

---

**Son Güncelleme:** {{ now()->format('d.m.Y') }}

