<?php

namespace App\Console\Commands;

use App\Models\FooterTemplate;
use App\Models\HeaderTemplate;
use App\Models\SectionTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
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
            // Logo
            $brands = $xpath->query('.//*[contains(@class, "navbar-brand")]//img', $node);
            foreach ($brands as $img) {
                $src = $this->fixAssetPath($img->getAttribute('src'));
                $class = $img->getAttribute('class');

                if (str_contains($class, 'logo-dark')) {
                    $data['setting.logo_dark'] = $src;
                    $img->setAttribute('src', '{setting.logo_dark}');
                } elseif (str_contains($class, 'logo-light')) {
                    $data['setting.logo_light'] = $src;
                    $img->setAttribute('src', '{setting.logo_light}');
                } else {
                    $data['setting.logo'] = $src;
                    $img->setAttribute('src', '{setting.logo}');
                }
            }

            // Menu
            $navs = $xpath->query('.//*[contains(@class, "navbar-nav")]', $node);
            foreach ($navs as $nav) {
                if (!$nav->parentNode) continue;
                // İçini temizle
                while ($nav->hasChildNodes()) {
                    $nav->removeChild($nav->firstChild);
                }
                // Placeholder metni ekle - Token olarak
                $nav->nodeValue = '___SPECIAL_MENU___'; 
            }
            
             // Dil Seçici
             $langs = $xpath->query('.//*[contains(@class, "language")]', $node);
             foreach ($langs as $lang) {
                 $lang->nodeValue = '___SETTING_LANGUAGES___';
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
            // Özel tokenlarımızı atla
            if (str_contains($textContent, '___SPECIAL_') || str_contains($textContent, '___SETTING_')) continue;
            
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
        
        // SPECIAL TOKENS FIX
        if ($templateType === 'header') {
            $html = str_replace('___SPECIAL_MENU___', '{special.menu}', $html);
            $html = str_replace('___SETTING_LANGUAGES___', '{setting.available_languages}', $html);
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
        if (str_starts_with($path, 'assets/')) {
            return '/html/' . $path;
        }
        return $path;
    }

    protected function fixAssetPathInString($html)
    {
        $html = str_replace('src="assets/', 'src="/html/assets/', $html);
        $html = str_replace('href="assets/', 'href="/html/assets/', $html);
        $html = str_replace("src='assets/", "src='/html/assets/", $html);
        $html = str_replace("href='assets/", "href='/html/assets/", $html);
        $html = str_replace('url(assets/', 'url(/html/assets/', $html);
        $html = str_replace('url("assets/', 'url("/html/assets/', $html);
        $html = str_replace("url('assets/", "url('/html/assets/", $html);
        
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
