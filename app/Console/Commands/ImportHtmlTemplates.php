<?php

namespace App\Console\Commands;

use App\Models\FooterTemplate;
use App\Models\HeaderTemplate;
use App\Models\SectionTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use DOMDocument;
use DOMXPath;
use DOMElement;

class ImportHtmlTemplates extends Command
{
    protected $signature = 'theme:import-html {--force : Mevcut şablonları günceller}';
    protected $description = 'HTML şablonlarını analiz eder, gelişmiş placeholderları oluşturur ve veritabanına aktarır.';

    // Etiket -> Kategori/Prefix eşleşmesi
    protected $tagMappings = [
        'h1' => 'text.title',
        'h2' => 'text.title',
        'h3' => 'text.subtitle',
        'h4' => 'text.subtitle',
        'h5' => 'text.heading',
        'h6' => 'text.heading',
        'p' => 'text.description',
        'span' => 'text.content',
        'address' => 'text.address',
        'button' => 'text.button',
        'a' => 'url.link', 
        'li' => 'text.list_item',
        'label' => 'text.label',
    ];

    public function handle()
    {
        $path = public_path('html');
        
        if (!File::exists($path)) {
            $this->error("Klasör bulunamadı: $path");
            return;
        }

        $files = File::files($path);
        $this->info(count($files) . " adet HTML dosyası bulundu. İşlem başlıyor...");

        foreach ($files as $file) {
            if ($file->getExtension() !== 'html') continue;
            $this->processFile($file);
        }

        $this->info("Tüm işlemler başarıyla tamamlandı!");
    }

    protected function processFile($file)
    {
        $filename = $file->getFilenameWithoutExtension();
        $content = File::get($file->getPathname());
        
        // UTF-8 ve HTML Entity fix
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');

        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        // HTML5 tagleri için ayarlar
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        // 1. HEADER
        $headerNodes = $xpath->query('//header');
        if ($headerNodes->length > 0) {
            $this->createTemplate($filename, 'header', $headerNodes->item(0));
        }

        // 2. FOOTER
        $footerNodes = $xpath->query('//footer');
        if ($footerNodes->length > 0) {
            $this->createTemplate($filename, 'footer', $footerNodes->item(0));
        }

        // 3. SECTIONS
        $sections = $xpath->query('//section');
        foreach ($sections as $index => $section) {
            $sectionId = $section->getAttribute('id') ?: 'section-' . ($index + 1);
            if (strlen($section->textContent) < 10 && $section->getElementsByTagName('img')->length == 0) continue;
            
            $this->createTemplate($filename, 'section', $section, $sectionId);
        }
    }

    protected function createTemplate($source, $type, DOMElement $node, $sectionId = null)
    {
        $result = $this->processNodeAndExtractData($node, $type);

        $namePrefix = ucfirst($source);
        
        if ($type === 'header') {
            HeaderTemplate::updateOrCreate(
                ['title' => "$namePrefix Header"],
                [
                    'html_content' => $result['html'],
                    'default_data' => $result['data'],
                    'is_active' => true
                ]
            );
            $this->line("✓ Header eklendi: $source");
        } 
        elseif ($type === 'footer') {
            FooterTemplate::updateOrCreate(
                ['title' => "$namePrefix Footer"],
                [
                    'html_content' => $result['html'],
                    'default_data' => $result['data'],
                    'is_active' => true
                ]
            );
            $this->line("✓ Footer eklendi: $source");
        }
        elseif ($type === 'section') {
            $title = "$namePrefix - " . ucfirst(str_replace(['-', '_'], ' ', $sectionId));
            SectionTemplate::updateOrCreate(
                ['title' => $title],
                [
                    'html_content' => $result['html'],
                    'default_data' => $result['data'],
                    'is_active' => true
                ]
            );
            $this->line("✓ Section eklendi: $title");
        }
    }

    protected function processNodeAndExtractData(DOMElement $originalNode, $templateType)
    {
        $node = $originalNode->cloneNode(true);
        $xpath = new DOMXPath($node->ownerDocument);
        
        $data = [];
        $counts = [];

        // A. Header Özel Alanları
        if ($templateType === 'header') {
            // Navbar sınıfını kontrol et
            $navbar = $xpath->query('.//*[contains(@class, "navbar")]', $node)->item(0);
            $isNavbarLight = $navbar && str_contains($navbar->getAttribute('class'), 'navbar-light');
            $isNavbarDark = $navbar && str_contains($navbar->getAttribute('class'), 'navbar-dark');

            // Logo
            $brands = $xpath->query('.//*[contains(@class, "navbar-brand")]//img', $node);
            foreach ($brands as $img) {
                $src = $this->fixAssetPath($img->getAttribute('src'));
                $class = $img->getAttribute('class');

                $settingKey = 'setting.logo';

                if (str_contains($class, 'logo-dark')) {
                    $settingKey = 'setting.logo_dark';
                } elseif (str_contains($class, 'logo-light')) {
                    $settingKey = 'setting.logo_light';
                } elseif ($isNavbarLight) {
                    // Navbar light ise (açık zemin), koyu logo gerekir
                    $settingKey = 'setting.logo_dark';
                } elseif ($isNavbarDark) {
                    // Navbar dark ise (koyu zemin), açık logo gerekir
                    $settingKey = 'setting.logo_light';
                }

                $data[$settingKey] = $src;
                $img->setAttribute('src', '{' . $settingKey . '}');
            }

            // Menu ({custom.menu})
            $navs = $xpath->query('.//*[contains(@class, "navbar-nav")]', $node);
            foreach ($navs as $nav) {
                // Sadece ana menüyü hedefle (genellikle navbar-collapse içinde olur)
                // İçeriği tamamen temizle ve yerine placeholder koy
                $parent = $nav->parentNode;
                if ($parent) {
                    // Eğer parent offcanvas-body veya navbar-collapse ise
                    $textNode = $node->ownerDocument->createTextNode('___CUSTOM_MENU___');
                    $parent->replaceChild($textNode, $nav);
                }
            }

            // Navbar Other ({custom.navbar})
            $others = $xpath->query('.//*[contains(@class, "navbar-other")]', $node);
            foreach ($others as $other) {
                $parent = $other->parentNode;
                if ($parent) {
                    // Navbar other genellikle butonları içerir, bunu custom.navbar ile değiştiriyoruz
                    // Ancak dil seçici de bunun içinde olabilir.
                    // Kullanıcı örneğinde {custom.navbar} ve {custom.language-selector} yan yana.
                    // Biz şimdilik navbar-other'ı komple custom.navbar yapalım.
                    // Dil seçici için ayrıca bir mantık kuralım.
                    
                    // Dil seçiciyi kontrol et, eğer varsa onu çıkarıp yanına ekleyebiliriz ama
                    // genellikle navbar-other kapsayıcıdır.
                    
                    $textNode = $node->ownerDocument->createTextNode('___CUSTOM_NAVBAR___');
                    $parent->replaceChild($textNode, $other);
                    
                    // Hemen sonrasına language selector ekleyelim (varsayım)
                    // Veya kullanıcı manuel eklesin.
                    // Kullanıcının isteği: {custom.navbar} {custom.language-selector}
                    $langNode = $node->ownerDocument->createTextNode('___CUSTOM_LANGUAGE___');
                    $parent->appendChild($langNode);
                }
            }
            
            // Dil Seçici ({custom.language-selector}) - Eğer navbar-other dışında varsa
            $langs = $xpath->query('.//*[contains(@class, "language-select") or contains(@class, "dropdown-language")]', $node);
            foreach ($langs as $lang) {
                 $parent = $lang->parentNode;
                 if ($parent) {
                     $textNode = $node->ownerDocument->createTextNode('___CUSTOM_LANGUAGE___');
                     $parent->replaceChild($textNode, $lang);
                 }
            }
        }

        // B. Genel İşlemler
        // 1. Resimler
        $images = $xpath->query('.//img', $node);
        foreach ($images as $img) {
            $src = $img->getAttribute('src');
            if (str_starts_with($src, '{')) continue;
            if (empty($src)) continue;

            $fixedSrc = $this->fixAssetPath($src);
            $key = $this->generateKey('image.content', $counts);
            
            $data[$key] = $fixedSrc;
            $img->setAttribute('src', "{" . $key . "}");
            
            $alt = $img->getAttribute('alt');
            if (!empty($alt) && !str_starts_with($alt, '{')) {
                 $altKey = str_replace('image.content', 'text.alt', $key);
                 $data[$altKey] = $alt;
                 $img->setAttribute('alt', "{" . $altKey . "}");
            }
        }

        // 2. Linkler
        $links = $xpath->query('.//a', $node);
        foreach ($links as $link) {
            $href = $link->getAttribute('href');
            if (empty($href) || str_starts_with($href, '#') || str_starts_with($href, 'javascript:') || str_starts_with($href, 'mailto:') || str_starts_with($href, 'tel:') || str_starts_with($href, '{')) continue;

            $fixedHref = $this->fixAssetPath($href);
            if (str_ends_with($fixedHref, '.html')) {
                $fixedHref = str_replace('.html', '', $fixedHref);
                if($fixedHref == 'index') $fixedHref = '/';
            }

            $key = $this->generateKey('url.link', $counts);
            $data[$key] = $fixedHref;
            $link->setAttribute('href', "{" . $key . "}");
        }

        // 3. Metinler
        $textNodes = $xpath->query('.//text()[normalize-space()]', $node);
        foreach ($textNodes as $textNode) {
            $parent = $textNode->parentNode;
            if (in_array(strtolower($parent->nodeName), ['script', 'style', 'noscript', 'iframe'])) continue;
            
            $textContent = trim($textNode->textContent);
            // Özel tokenlarımızı atla (___SPECIAL_, ___SETTING_, ___CUSTOM_)
            if (str_contains($textContent, '___SPECIAL_') || str_contains($textContent, '___SETTING_') || str_contains($textContent, '___CUSTOM_')) continue;
            
            if (str_starts_with($textContent, '{') && str_ends_with($textContent, '}')) continue;
            if (mb_strlen($textContent) < 2) continue;

            $tagName = strtolower($parent->nodeName);
            $prefix = $this->tagMappings[$tagName] ?? 'text.content';

            $key = $this->generateKey($prefix, $counts);
            
            $data[$key] = $textContent;
            $textNode->nodeValue = "{" . $key . "}";
        }

        $html = $this->getInnerHtml($node);
        $html = $this->fixAssetPathInString($html);

        // ENCODE FIX: %7B -> {, %7D -> }
        // DOMDocument attribute değerlerini encode ettiği için bunları geri çeviriyoruz
        $html = str_replace(['%7B', '%7D'], ['{', '}'], $html);
        
        // SPECIAL TOKENS FIX - Replace placeholder tokens with actual template syntax
        $html = str_replace('___SPECIAL_MENU___', '{custom.menu}', $html);
        $html = str_replace('___CUSTOM_MENU___', '{custom.menu}', $html);
        $html = str_replace('___CUSTOM_NAVBAR___', '{custom.navbar}', $html);
        $html = str_replace('___CUSTOM_LANGUAGE___', '{custom.language-selector}', $html);
        $html = str_replace('___SETTING_LANGUAGES___', '{custom.language-selector}', $html);

        // Clean default_data from any leftover tokens
        foreach ($data as $key => $value) {
            if (is_string($value) && (
                str_contains($value, '___CUSTOM_') || 
                str_contains($value, '___SPECIAL_') || 
                str_contains($value, '___SETTING_')
            )) {
                unset($data[$key]);
            }
        }

        return ['html' => $html, 'data' => $data];
    }

    protected function generateKey($prefix, &$counts)
    {
        if (!isset($counts[$prefix])) {
            $counts[$prefix] = 1;
        } else {
            $counts[$prefix]++;
        }
        return $prefix . '_' . $counts[$prefix];
    }

    protected function fixAssetPath($path)
    {
        // Eğer URL ise elleme
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Assets klasöründeki dosyaları storage'a taşı
        if (str_starts_with($path, 'assets/')) {
            $sourcePath = public_path('html/' . $path);
            
            // Eğer html/assets altında yoksa, ana assets klasörüne bak
            if (!File::exists($sourcePath)) {
                $sourcePath = public_path($path);
            }
            
            if (File::exists($sourcePath)) {
                // Dosya adını ve klasörünü belirle
                $fileName = basename($path);
                // Çakışmayı önlemek için orijinal klasör yapısını korumaya çalışabiliriz
                // veya basitçe 'templates/imported' altına atabiliriz.
                
                // Storage hedef yolu: templates/imported/filename.ext
                $targetDir = 'templates/imported';
                $targetPath = $targetDir . '/' . $fileName;
                
                // Eğer storage'da bu dosya yoksa kopyala
                if (!Storage::disk('public')->exists($targetPath)) {
                    Storage::disk('public')->put($targetPath, File::get($sourcePath));
                }
                
                // Veritabanına kaydedilecek değer: templates/imported/filename.ext
                // Bu değer Filament FileUpload tarafından 'public' diskinde otomatik olarak bulunur.
                return $targetPath;
            }
            
            // Dosya bulunamadıysa eski usul devam et
            return '/' . $path;
        }
        
        return $path;
    }

    protected function fixAssetPathInString($html)
    {
        // HTML string içindeki asset pathlerini güncelle
        // Burada da aynı mantıkla storage pathlerine çevirebilirdik ama
        // string içindeki pathleri tek tek bulup kopyalamak zor ve performanssız olabilir.
        // Şimdilik sadece URL'leri düzeltiyoruz, import edilen resimler zaten processNode kısmında hallediliyor.
        // Background-image gibi CSS içindeki pathler için burası önemli.
        
        // CSS içindeki url('assets/...') kısımlarını yakalamak için daha genel bir yaklaşım
        // Ancak processNode zaten img taglerini hallettiği için burası sadece kalanlar için.
        
        $html = str_replace('src="assets/', 'src="/assets/', $html);
        $html = str_replace('href="assets/', 'href="/assets/', $html);
        $html = str_replace("src='assets/", "src='/assets/", $html);
        $html = str_replace("href='assets/", "href='/assets/", $html);
        $html = str_replace('url(assets/', 'url(/assets/', $html);
        $html = str_replace('url("assets/', 'url("/assets/', $html);
        $html = str_replace("url('assets/", "url('/assets/", $html);
        
        return $html;
    }

    protected function getInnerHtml($node)
    {
        $innerHTML = '';
        $children = $node->childNodes;
        foreach ($children as $child) {
            $innerHTML .= $node->ownerDocument->saveHTML($child);
        }
        return $innerHTML;
    }
}
