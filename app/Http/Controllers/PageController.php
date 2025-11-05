<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage or a specific page
     */
    public function index()
    {
        // 1) is_homepage işaretli ve published (en son güncellenen)
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
        if ($page->headerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $page->headerTemplate->default_data ?? [];
            $pageData = $page->header_data ?? [];
            $mergedHeaderData = array_merge($templateDefaults, $pageData);
            
            $renderedHeader = TemplateService::replacePlaceholders(
                $page->headerTemplate->html_content,
                $mergedHeaderData,
                $page
            );
        }

        // Render Footer Template
        $renderedFooter = null;
        if ($page->footerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $page->footerTemplate->default_data ?? [];
            $pageData = $page->footer_data ?? [];
            $mergedFooterData = array_merge($templateDefaults, $pageData);
            
            $renderedFooter = TemplateService::replacePlaceholders(
                $page->footerTemplate->html_content,
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
        if ($page->headerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $page->headerTemplate->default_data ?? [];
            $pageData = $page->header_data ?? [];
            $mergedHeaderData = array_merge($templateDefaults, $pageData);
            
            $renderedHeader = TemplateService::replacePlaceholders(
                $page->headerTemplate->html_content,
                $mergedHeaderData,
                $page
            );
        }

        // Render Footer Template
        $renderedFooter = null;
        if ($page->footerTemplate) {
            // Merge template defaults with page data (page data overrides defaults)
            $templateDefaults = $page->footerTemplate->default_data ?? [];
            $pageData = $page->footer_data ?? [];
            $mergedFooterData = array_merge($templateDefaults, $pageData);
            
            $renderedFooter = TemplateService::replacePlaceholders(
                $page->footerTemplate->html_content,
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



