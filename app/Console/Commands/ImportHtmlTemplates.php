<?php

namespace App\Console\Commands;

use App\Models\FooterTemplate;
use App\Models\HeaderTemplate;
use App\Models\SectionTemplate;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use DOMDocument;
use DOMXPath;

class ImportHtmlTemplates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'theme:import-html {--force : Mevcut şablonları günceller}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'public/html klasöründeki HTML şablonlarını analiz eder ve veritabanına aktarır.';

    /**
     * Otomatik değiştirilecek metinler ve placeholder karşılıkları
     */
    protected $replacements = [
        'Truncgil Technology' => '{text.company_name}',
        'Trunçgil' => '{text.company_name}',
        'tel:+' => 'tel:{setting.phone}',
        'mailto:' => 'mailto:{setting.email}',
        '© 2025' => '© {date.year}',
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
        $this->line("İşleniyor: $filename");

        // HTML Parse İşlemi
        // Hataları gizle (HTML5 etiketlerinde bazen uyarı verebilir)
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        // UTF-8 karakter sorunu yaşamamak için hack
        // mb_convert_encoding ile içeriğin UTF-8 olduğundan emin oluyoruz
        $content = mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
        $dom->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $xpath = new DOMXPath($dom);

        // 1. HEADER ÇIKARTMA
        $headerNodes = $xpath->query('//header');
        if ($headerNodes->length > 0) {
            $headerHtml = $this->getInnerHtml($headerNodes->item(0));
            $this->createHeaderTemplate($filename, $headerHtml);
        }

        // 2. FOOTER ÇIKARTMA
        $footerNodes = $xpath->query('//footer');
        if ($footerNodes->length > 0) {
            $footerHtml = $this->getInnerHtml($footerNodes->item(0));
            $this->createFooterTemplate($filename, $footerHtml);
        }

        // 3. SECTIONS (BODY İÇİNDEKİLER)
        // Header ve Footer haricindeki sectionları bul
        $sections = $xpath->query('//section');
        foreach ($sections as $index => $section) {
            $sectionHtml = $this->getInnerHtml($section);
            
            // ID varsa al yoksa oluştur
            $sectionId = $section->getAttribute('id');
            if (empty($sectionId)) {
                $sectionId = 'section-' . ($index + 1);
            }
            
            // Eğer section çok kısaysa atla (boş sectionlar için)
            if (strlen(strip_tags($sectionHtml)) < 10) continue;

            $this->createSectionTemplate($filename, $sectionId, $sectionHtml);
        }
    }

    protected function createHeaderTemplate($source, $html)
    {
        $html = $this->processHtmlContent($html);
        
        HeaderTemplate::updateOrCreate(
            ['title' => ucfirst($source) . ' Header'],
            [
                'html_content' => $html,
                'is_active' => true,
                'default_data' => [] 
            ]
        );
    }

    protected function createFooterTemplate($source, $html)
    {
        $html = $this->processHtmlContent($html);

        FooterTemplate::updateOrCreate(
            ['title' => ucfirst($source) . ' Footer'],
            [
                'html_content' => $html,
                'is_active' => true,
                'default_data' => []
            ]
        );
    }

    protected function createSectionTemplate($source, $sectionId, $html)
    {
        $html = $this->processHtmlContent($html);
        $title = ucfirst($source) . ' - ' . ucfirst(str_replace(['-', '_'], ' ', $sectionId));

        SectionTemplate::updateOrCreate(
            ['title' => $title],
            [
                'html_content' => $html,
                'is_active' => true,
                'default_data' => []
            ]
        );
    }

    /**
     * HTML İçeriğini temizler, asset yollarını düzeltir ve placeholderları yerleştirir
     */
    protected function processHtmlContent($html)
    {
        // 1. Asset Yollarını Düzelt (assets/img -> /html/assets/img)
        // Public/html altında olduğu için absolute path veriyoruz
        $html = str_replace('src="assets/', 'src="/html/assets/', $html);
        $html = str_replace('href="assets/', 'href="/html/assets/', $html);
        $html = str_replace("src='assets/", "src='/html/assets/", $html);

        // 2. Linkleri Düzelt (index.html -> /)
        $html = str_replace('href="index.html"', 'href="/"', $html);
        
        // 3. Placeholder Değişimi (Basit string replace)
        foreach ($this->replacements as $search => $replace) {
            $html = str_replace($search, $replace, $html);
        }

        return $html;
    }

    /**
     * DOMNode'un HTML içeriğini string olarak alır
     */
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

