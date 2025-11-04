<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // İlk kullanıcıyı bul veya oluştur (author_id için gerekli)
        $author = \App\Models\User::first();
        if (!$author) {
            $author = \App\Models\User::create([
                'name' => 'Admin',
                'email' => 'admin@truncgil.com',
                'password' => bcrypt('password'),
            ]);
        }

        $pages = [
            // Home Page
            [
                'author_id' => $author->id,
                'title' => 'Anasayfa',
                'slug' => 'home',
                'excerpt' => 'Modern ve yenilikçi teknoloji çözümleri',
                'content' => null,
                'template' => 'home',
                'status' => 'published',
                'is_homepage' => true,
                'show_in_menu' => true,
                'sort_order' => 1,
                'published_at' => now(),
                'meta_title' => 'Truncgil Citrus - Modern Web Çözümleri',
                'meta_description' => 'Yenilikçi teknoloji çözümleri ile geleceği şekillendiriyoruz. Modern web uygulamaları ve dijital dönüşüm hizmetleri.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'background_image' => 'assets/img/photos/blurry.png',
                            'badge' => 'YENİ PLATFORM',
                            'title' => 'Modern ve Çok Amaçlı <span class="text-[#e31e24]">Web Çözümleri</span>',
                            'subtitle' => 'Yenilikçi teknoloji çözümleri ile geleceği şekillendiriyoruz. Projelerinizi en son teknolojilerle hayata geçiriyoruz.',
                            'primary_button_text' => 'Hemen Başla',
                            'primary_button_url' => '#features',
                            'secondary_button_text' => 'Daha Fazla Bilgi',
                            'secondary_button_url' => '/about',
                            'hero_image' => 'assets/img/demos/f1.png',
                        ],
                    ],
                    [
                        'type' => 'features',
                        'data' => [
                            'bg_class' => '!bg-[#f0f0f8]',
                            'section_badge' => 'ÖZELLİKLER',
                            'section_title' => 'Neden Truncgil Citrus?',
                            'section_subtitle' => 'Modern teknolojiler ve uzman ekibimizle projelerinizi hayata geçiriyoruz',
                            'column_class' => 'md:w-6/12 lg:w-4/12',
                            'features' => [
                                [
                                    'icon' => 'assets/img/demos/fi1.png',
                                    'title' => 'Hızlı Çözümler',
                                    'description' => 'Modern teknolojiler kullanarak projelerinizi hızlı ve verimli bir şekilde hayata geçiriyoruz.',
                                ],
                                [
                                    'icon' => 'assets/img/demos/fi2.png',
                                    'title' => 'Güvenli Altyapı',
                                    'description' => 'En son güvenlik standartlarını kullanarak verilerinizi koruma altına alıyoruz.',
                                ],
                                [
                                    'icon' => 'assets/img/demos/fi3.png',
                                    'title' => 'Uzman Ekip',
                                    'description' => 'Deneyimli ve uzman ekibimiz ile her zaman yanınızdayız.',
                                ],
                            ],
                        ],
                    ],
                    [
                        'type' => 'stats',
                        'data' => [
                            'bg_class' => '!bg-[#ffffff]',
                            'column_class' => 'md:w-6/12 lg:w-3/12',
                            'stats' => [
                                ['number' => '500+', 'label' => 'Tamamlanan Proje'],
                                ['number' => '300+', 'label' => 'Mutlu Müşteri'],
                                ['number' => '50+', 'label' => 'Kazanılan Ödül'],
                                ['number' => '25+', 'label' => 'Ekip Üyesi'],
                            ],
                        ],
                    ],
                    [
                        'type' => 'cta',
                        'data' => [
                            'bg_class' => 'overflow-hidden',
                            'background_image' => 'assets/img/photos/blurry.png',
                            'icon' => 'assets/img/demos/icon-grape.png',
                            'title' => 'Benzersiz düşünün ve <span class="text-[#e31e24]">fark yaratın</span>',
                            'subtitle' => 'Binlerce müşterimiz tarafından güveniliyoruz. Siz de katılın ve projelerinizi hayata geçirin.',
                            'button_text' => 'İletişime Geç',
                            'button_url' => '/contact',
                            'button_icon' => 'uil uil-arrow-up-right',
                        ],
                    ],
                ],
            ],

            // About Page
            [
                'author_id' => $author->id,
                'title' => 'Hakkımızda',
                'slug' => 'about',
                'excerpt' => 'Truncgil Citrus olarak yenilikçi teknoloji çözümleri sunuyoruz',
                'content' => null,
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 2,
                'published_at' => now(),
                'meta_title' => 'Hakkımızda - Truncgil Citrus',
                'meta_description' => 'Truncgil Citrus olarak yenilikçi teknoloji çözümleri sunuyor, dijital dönüşüm süreçlerinizde yanınızdayız.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'badge' => 'HAKKIMIZDA',
                            'title' => 'Yenilikçi Teknoloji <span class="text-[#e31e24]">Çözümleri</span>',
                            'subtitle' => '2010 yılından bu yana dijital dönüşüm süreçlerinde lider konumdayız',
                        ],
                    ],
                    [
                        'type' => 'features',
                        'data' => [
                            'bg_class' => '!bg-[#ffffff]',
                            'section_title' => 'Değerlerimiz',
                            'section_subtitle' => 'İş süreçlerimizi şekillendiren temel prensiplerimiz',
                            'column_class' => 'md:w-6/12 lg:w-3/12',
                            'features' => [
                                ['icon' => 'assets/img/demos/fi1.png', 'title' => 'İnovasyon', 'description' => 'Sürekli yenilik ve gelişim'],
                                ['icon' => 'assets/img/demos/fi2.png', 'title' => 'Kalite', 'description' => 'En yüksek standartlarda hizmet'],
                                ['icon' => 'assets/img/demos/fi3.png', 'title' => 'Güvenilirlik', 'description' => 'Zamanında ve eksiksiz teslimat'],
                                ['icon' => 'assets/img/demos/fi4.png', 'title' => 'Destek', 'description' => '7/24 müşteri desteği'],
                            ],
                        ],
                    ],
                ],
            ],

            // Services Page
            [
                'author_id' => $author->id,
                'title' => 'Hizmetlerimiz',
                'slug' => 'services',
                'excerpt' => 'Geniş yelpazede teknoloji hizmetleri sunuyoruz',
                'content' => null,
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 3,
                'published_at' => now(),
                'meta_title' => 'Hizmetlerimiz - Truncgil Citrus',
                'meta_description' => 'Web tasarım, mobil uygulama geliştirme, e-ticaret çözümleri ve dijital pazarlama hizmetlerimizi keşfedin.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'badge' => 'HİZMETLER',
                            'title' => 'Dijital Dönüşüm <span class="text-[#e31e24]">Çözümleri</span>',
                            'subtitle' => 'İşinizi bir üst seviyeye taşıyacak teknoloji hizmetlerimiz',
                        ],
                    ],
                    [
                        'type' => 'features',
                        'data' => [
                            'bg_class' => '!bg-[#f0f0f8]',
                            'section_title' => 'Sunduğumuz Hizmetler',
                            'column_class' => 'md:w-6/12 lg:w-4/12',
                            'features' => [
                                ['icon' => 'assets/img/demos/fi1.png', 'title' => 'Web Tasarım & Geliştirme', 'description' => 'Modern, responsive ve SEO uyumlu web siteleri'],
                                ['icon' => 'assets/img/demos/fi2.png', 'title' => 'Mobil Uygulama', 'description' => 'iOS ve Android için native ve cross-platform uygulamalar'],
                                ['icon' => 'assets/img/demos/fi3.png', 'title' => 'E-Ticaret Çözümleri', 'description' => 'Entegre ödeme sistemleri ile online satış platformları'],
                                ['icon' => 'assets/img/demos/fi4.png', 'title' => 'Dijital Pazarlama', 'description' => 'SEO, SEM ve sosyal medya yönetimi'],
                                ['icon' => 'assets/img/demos/fi1.png', 'title' => 'Kurumsal Yazılım', 'description' => 'İşletmenize özel CRM, ERP ve özel yazılım çözümleri'],
                                ['icon' => 'assets/img/demos/fi2.png', 'title' => 'Bulut Hizmetleri', 'description' => 'Güvenli ve ölçeklenebilir bulut altyapısı'],
                            ],
                        ],
                    ],
                ],
            ],

            // Contact Page
            [
                'author_id' => $author->id,
                'title' => 'İletişim',
                'slug' => 'contact',
                'excerpt' => 'Projeleriniz hakkında bizimle iletişime geçin',
                'content' => null,
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => true,
                'sort_order' => 4,
                'published_at' => now(),
                'meta_title' => 'İletişim - Truncgil Citrus',
                'meta_description' => 'Projeleriniz hakkında konuşmak için bizimle iletişime geçin. Uzman ekibimiz size yardımcı olmaktan mutluluk duyar.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'badge' => 'İLETİŞİM',
                            'title' => 'Projelerinizi <span class="text-[#e31e24]">Konuşalım</span>',
                            'subtitle' => 'Size özel çözümler geliştirmek için bizimle iletişime geçin',
                        ],
                    ],
                    [
                        'type' => 'contact',
                        'data' => [
                            'bg_class' => '!bg-[#f0f0f8]',
                            'title' => 'Bizimle İletişime Geçin',
                            'subtitle' => 'Projeleriniz hakkında konuşmak için bize ulaşın',
                            'info' => [
                                'address' => 'Merkez Mah. Teknoloji Cad. No:123 İstanbul',
                                'phone' => '+90 (212) 555 1234',
                                'email' => 'info@truncgil.com',
                            ],
                            'form_action' => '/contact/submit',
                            'button_text' => 'Gönder',
                        ],
                    ],
                ],
            ],

            // Pricing Page (örnek)
            [
                'author_id' => $author->id,
                'title' => 'Fiyatlandırma',
                'slug' => 'pricing',
                'excerpt' => 'Size uygun paketi seçin',
                'content' => null,
                'template' => 'generic',
                'status' => 'published',
                'is_homepage' => false,
                'show_in_menu' => false,
                'sort_order' => 5,
                'published_at' => now(),
                'meta_title' => 'Fiyatlandırma - Truncgil Citrus',
                'meta_description' => 'İhtiyaçlarınıza uygun web tasarım ve yazılım geliştirme paketlerimizi inceleyin.',
                'sections' => [
                    [
                        'type' => 'hero',
                        'data' => [
                            'badge' => 'FİYATLANDIRMA',
                            'title' => 'Size Uygun <span class="text-[#e31e24]">Paketi Seçin</span>',
                            'subtitle' => 'Tüm paketler 30 gün para iade garantisi ile geliyor',
                        ],
                    ],
                    [
                        'type' => 'pricing',
                        'data' => [
                            'bg_class' => '!bg-[#f0f0f8]',
                            'section_title' => 'Web Tasarım Paketleri',
                            'column_class' => 'md:w-6/12 lg:w-4/12',
                            'featured_label' => 'Önerilen',
                            'plans' => [
                                [
                                    'name' => 'Başlangıç',
                                    'currency' => '₺',
                                    'price' => '999',
                                    'period' => 'ay',
                                    'features' => ['5 Sayfa', 'Mobil Uyumlu', 'SEO Optimizasyonu', '7/24 Destek'],
                                    'button_text' => 'Başla',
                                    'button_url' => '/contact',
                                ],
                                [
                                    'name' => 'Profesyonel',
                                    'currency' => '₺',
                                    'price' => '2499',
                                    'period' => 'ay',
                                    'featured' => true,
                                    'features' => ['15 Sayfa', 'Mobil Uyumlu', 'SEO Optimizasyonu', 'Yönetim Paneli', '7/24 Öncelikli Destek'],
                                    'button_text' => 'Başla',
                                    'button_url' => '/contact',
                                ],
                                [
                                    'name' => 'Kurumsal',
                                    'currency' => '₺',
                                    'price' => '4999',
                                    'period' => 'ay',
                                    'features' => ['Sınırsız Sayfa', 'Mobil Uyumlu', 'SEO Optimizasyonu', 'Gelişmiş Yönetim Paneli', 'Özel Entegrasyonlar', '7/24 Öncelikli Destek'],
                                    'button_text' => 'Başla',
                                    'button_url' => '/contact',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(
                ['slug' => $pageData['slug']],
                $pageData
            );
        }

        $this->command->info('✅ ' . count($pages) . ' sayfa başarıyla oluşturuldu!');
    }
}
