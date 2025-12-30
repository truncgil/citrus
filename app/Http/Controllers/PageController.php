<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use App\Models\HeaderTemplate;
use App\Models\FooterTemplate;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage or a specific page
     */
    public function index()
    {
        // 1. Statik "home" Template Kontrolü
        if (view()->exists('templates.home')) {
            $page = Page::with(['headerTemplate', 'footerTemplate'])
                ->where('is_homepage', true)
                ->where('status', 'published')
                ->latest('updated_at')
                ->first();

            $settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;

            $renderedHeader = null;
            $renderedFooter = null;
            $metaTitle = null;
            $metaDescription = null;

            if ($page) {
                // Meta bilgileri
                $metaTitle = method_exists($page, 'translate')
                    ? ($page->translate('meta_title') ?: $page->translate('title'))
                    : ($page->meta_title ?? $page->title ?? null);

                $metaDescription = method_exists($page, 'translate')
                    ? ($page->translate('meta_description') ?: ($page->excerpt ?? null))
                    : ($page->meta_description ?? $page->excerpt ?? null);

                // Header Render
                $headerTemplate = $page->headerTemplate;
                if (!$headerTemplate) {
                    $headerTemplate = HeaderTemplate::where('is_active', true)->latest('updated_at')->first();
                }
                
                if ($headerTemplate) {
                    $templateDefaults = $headerTemplate->default_data ?? [];
                    $pageData = $page->header_data ?? [];
                    $mergedHeaderData = array_merge($templateDefaults, $pageData);
                    $renderedHeader = TemplateService::replacePlaceholders($headerTemplate->html_content, $mergedHeaderData, $page);
                }

                // Footer Render
                $footerTemplate = $page->footerTemplate;
                if (!$footerTemplate) {
                    $footerTemplate = FooterTemplate::where('is_active', true)->latest('updated_at')->first();
                }
                
                if ($footerTemplate) {
                    $templateDefaults = $footerTemplate->default_data ?? [];
                    $pageData = $page->footer_data ?? [];
                    $mergedFooterData = array_merge($templateDefaults, $pageData);
                    $renderedFooter = TemplateService::replacePlaceholders($footerTemplate->html_content, $mergedFooterData, $page);
                }
            }

            return view('templates.home', [
                'page' => $page,
                'settings' => $settings,
                'sections' => $page ? ($page->sections ?? []) : [],
                'templatedSections' => $page ? ($page->templated_sections ?? collect([])) : collect([]),
                'renderedHeader' => $renderedHeader,
                'renderedFooter' => $renderedFooter,
                'meta' => [
                    'title' => $metaTitle ?: ($settings->default_meta_title ?? config('app.name')),
                    'description' => $metaDescription ?: ($settings->default_meta_description ?? null),
                    'image' => $settings->default_meta_image ?? null,
                ],
            ]);
        }

        // 2. Normal Dinamik Akış (Mevcut kod devam eder)
        $page = Page::with(['headerTemplate', 'footerTemplate'])
            ->where('is_homepage', true)
            ->where('status', 'published')
            ->latest('updated_at')
            ->first();
  

       

        $settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;

        // Hiç sayfa yoksa: direkt home template'inin statik fallback'i ile render et
        if (!$page) {
            return view('templates.home', [
                'page' => null,
                'settings' => $settings,
                'meta' => [
                    'title' => $settings->default_meta_title ?? config('app.name'),
                    'description' => $settings->default_meta_description ?? null,
                    'image' => $settings->default_meta_image ?? null,
                ],
            ]);
        }

        $metaTitle = method_exists($page, 'translate')
            ? ($page->translate('meta_title') ?: $page->translate('title'))
            : ($page->meta_title ?? $page->title ?? null);

        $metaDescription = method_exists($page, 'translate')
            ? ($page->translate('meta_description') ?: ($page->excerpt ?? null))
            : ($page->meta_description ?? $page->excerpt ?? null);

        // Section verisini al - Hem eski hem yeni sistemi destekle
        $sections = $page->sections ?? $page->data ?? [];
        
        // Yeni dinamik template sistemi için sections_data varsa onu da al
        $templatedSections = $page->templated_sections ?? collect([]);
        
        // Template belirleme mantığı:
        // 1. Kullanıcı template seçmişse, onu kullan
        // 2. Template seçilmemişse ve homepage ise, 'home' kullan
        // 3. Hiçbiri yoksa, 'generic' kullan
        $template = $page->template 
            ?? (($page->slug === 'home' || ($page->is_homepage ?? false)) ? 'home' : 'generic');
        
        $view = view()->exists("templates.$template")
            ? "templates.$template"
            : 'templates.generic';
        
        // Render Header Template
        $renderedHeader = null;
        $headerTemplate = $page->headerTemplate;
        
        // Eğer sayfa için header seçilmemişse, en son aktif header template'i kullan
        if (!$headerTemplate) {
            $headerTemplate = HeaderTemplate::where('is_active', true)
                ->latest('updated_at')
                ->first();
        }
        
        if ($headerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $headerTemplate->default_data ?? [];
            $pageData = $page->header_data ?? [];
            $mergedHeaderData = array_merge($templateDefaults, $pageData);
            
            $renderedHeader = TemplateService::replacePlaceholders(
                $headerTemplate->html_content,
                $mergedHeaderData,
                $page
            );
        }

        // Render Footer Template
        $renderedFooter = null;
        $footerTemplate = $page->footerTemplate;
        
        // Eğer sayfa için footer seçilmemişse, en son aktif footer template'i kullan
        if (!$footerTemplate) {
            $footerTemplate = FooterTemplate::where('is_active', true)
                ->latest('updated_at')
                ->first();
        }
        
        if ($footerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $footerTemplate->default_data ?? [];
            $pageData = $page->footer_data ?? [];
            $mergedFooterData = array_merge($templateDefaults, $pageData);
            
            $renderedFooter = TemplateService::replacePlaceholders(
                $footerTemplate->html_content,
                $mergedFooterData,
                $page
            );
        }

        return view($view, [
            'page' => $page,
            'settings' => $settings,
            'sections' => $sections,
            'templatedSections' => $templatedSections,
            'renderedHeader' => $renderedHeader,
            'renderedFooter' => $renderedFooter,
            'meta' => [
                'title' => $metaTitle ?: ($settings->default_meta_title ?? config('app.name')),
                'description' => $metaDescription ?: ($settings->default_meta_description ?? null),
                'image' => $settings->default_meta_image ?? null,
            ],
        ]);
    }

    /**
     * Display a specific page by slug
     */
    public function show($slug)
    {
        // 1. Statik View Kontrolü
        // Eğer templates/{slug}.blade.php varsa, veritabanında kayıt olsun veya olmasın bu dosyayı render et.
        if (view()->exists("templates.$slug")) {
            $page = Page::with(['headerTemplate', 'footerTemplate'])
                ->where('slug', $slug)
                ->where('status', 'published')
                ->first();

            $settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;

            // Meta verilerini hazırla
            $metaTitle = null;
            $metaDescription = null;

            if ($page) {
                $metaTitle = method_exists($page, 'translate')
                    ? ($page->translate('meta_title') ?: $page->translate('title'))
                    : ($page->meta_title ?? $page->title ?? null);

                $metaDescription = method_exists($page, 'translate')
                    ? ($page->translate('meta_description') ?: ($page->excerpt ?? null))
                    : ($page->meta_description ?? $page->excerpt ?? null);
            }

            // Statik sayfa için header/footer render işlemleri (Eğer page varsa)
            $renderedHeader = null;
            $renderedFooter = null;

            if ($page) {
                // Render Header Template
                $headerTemplate = $page->headerTemplate;
                if (!$headerTemplate) {
                    $headerTemplate = HeaderTemplate::where('is_active', true)->latest('updated_at')->first();
                }
                
                if ($headerTemplate) {
                    $templateDefaults = $headerTemplate->default_data ?? [];
                    $pageData = $page->header_data ?? [];
                    $mergedHeaderData = array_merge($templateDefaults, $pageData);
                    $renderedHeader = TemplateService::replacePlaceholders($headerTemplate->html_content, $mergedHeaderData, $page);
                }

                // Render Footer Template
                $footerTemplate = $page->footerTemplate;
                if (!$footerTemplate) {
                    $footerTemplate = FooterTemplate::where('is_active', true)->latest('updated_at')->first();
                }
                
                if ($footerTemplate) {
                    $templateDefaults = $footerTemplate->default_data ?? [];
                    $pageData = $page->footer_data ?? [];
                    $mergedFooterData = array_merge($templateDefaults, $pageData);
                    $renderedFooter = TemplateService::replacePlaceholders($footerTemplate->html_content, $mergedFooterData, $page);
                }
            }

            return view("templates.$slug", [
                'page' => $page,
                'settings' => $settings,
                'sections' => $page->sections ?? [],
                'templatedSections' => $page->templated_sections ?? collect([]),
                'renderedHeader' => $renderedHeader,
                'renderedFooter' => $renderedFooter,
                'meta' => [
                    'title' => $metaTitle ?: ($settings->default_meta_title ?? config('app.name')),
                    'description' => $metaDescription ?: ($settings->default_meta_description ?? null),
                    'image' => $settings->default_meta_image ?? null,
                ],
            ]);
        }

        // 2. Normal Dinamik Akış (DB Kaydı Zorunlu)
        $page = Page::with(['headerTemplate', 'footerTemplate'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;

        $metaTitle = method_exists($page, 'translate')
            ? ($page->translate('meta_title') ?: $page->translate('title'))
            : ($page->meta_title ?? $page->title ?? null);

        $metaDescription = method_exists($page, 'translate')
            ? ($page->translate('meta_description') ?: ($page->excerpt ?? null))
            : ($page->meta_description ?? $page->excerpt ?? null);

        // Use parsed_sections for easier template usage (key-value format)
        $sections = $page->parsed_sections ?? $page->sections ?? $page->data ?? [];
        
        // Yeni dinamik template sistemi için sections_data varsa onu da al
        $templatedSections = $page->templated_sections ?? collect([]);
        
        // Template belirleme mantığı:
        // 1. Kullanıcı template seçmişse, onu kullan
        // 2. Template seçilmemişse ve homepage ise, 'home' kullan
        // 3. Hiçbiri yoksa, 'generic' kullan
        $template = $page->template 
            ?? (($slug === 'home' || ($page->is_homepage ?? false)) ? 'home' : 'generic');
        
        $view = view()->exists("templates.$template")
            ? "templates.$template"
            : 'templates.generic';

        // Render Header Template
        $renderedHeader = null;
        $headerTemplate = $page->headerTemplate;
        
        // Eğer sayfa için header seçilmemişse, en son aktif header template'i kullan
        if (!$headerTemplate) {
            $headerTemplate = HeaderTemplate::where('is_active', true)
                ->latest('updated_at')
                ->first();
        }
        
        if ($headerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $headerTemplate->default_data ?? [];
            $pageData = $page->header_data ?? [];
            $mergedHeaderData = array_merge($templateDefaults, $pageData);
            
            $renderedHeader = TemplateService::replacePlaceholders(
                $headerTemplate->html_content,
                $mergedHeaderData,
                $page
            );
        }

        // Render Footer Template
        $renderedFooter = null;
        $footerTemplate = $page->footerTemplate;
        
        // Eğer sayfa için footer seçilmemişse, en son aktif footer template'i kullan
        if (!$footerTemplate) {
            $footerTemplate = FooterTemplate::where('is_active', true)
                ->latest('updated_at')
                ->first();
        }
        
        if ($footerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $footerTemplate->default_data ?? [];
            $pageData = $page->footer_data ?? [];
            $mergedFooterData = array_merge($templateDefaults, $pageData);
            
            $renderedFooter = TemplateService::replacePlaceholders(
                $footerTemplate->html_content,
                $mergedFooterData,
                $page
            );
        }

        return view($view, [
            'page' => $page,
            'settings' => $settings,
            'sections' => $sections,
            'templatedSections' => $templatedSections,
            'renderedHeader' => $renderedHeader,
            'renderedFooter' => $renderedFooter,
            'meta' => [
                'title' => $metaTitle ?: ($settings->default_meta_title ?? config('app.name')),
                'description' => $metaDescription ?: ($settings->default_meta_description ?? null),
                'image' => $settings->default_meta_image ?? null,
            ],
        ]);
    }

    /**
     * Get menu items for navigation
     */
    private function getMenuItems()
    {
        return Page::with(['children' => function ($query) {
                $query->where('status', 'published')
                    ->where('show_in_menu', true)
                    ->orderBy('sort_order', 'asc')
                    ->orderBy('title', 'asc');
            }])
            ->whereNull('parent_id')
            ->where('status', 'published')
            ->where('show_in_menu', true)
            ->orderBy('sort_order', 'asc')
            ->orderBy('title', 'asc')
            ->get();
    }
}



