<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage or a specific page
     */
    public function index()
    {
        // 1) is_homepage işaretli ve published
        $page = Page::where('is_homepage', true)
            ->where('status', 'published')
            ->first();

        // 2) yoksa 'home' slug'ı
        if (!$page) {
            $page = Page::where('slug', 'home')
                ->where('status', 'published')
                ->first();
        }

        // 3) yoksa ilk published sayfa (fallback)
        if (!$page) {
            $page = Page::where('status', 'published')->orderByDesc('published_at')->first();
        }

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

        $sections = $page->sections ?? $page->data ?? [];
        $template = ($page->slug === 'home' || ($page->is_homepage ?? false))
            ? 'home'
            : ($page->template ?? null);
        $view = $template && view()->exists("templates.$template")
            ? "templates.$template"
            : (($page->slug === 'home' || ($page->is_homepage ?? false)) ? 'templates.home' : 'templates.generic');

        return view($view, [
            'page' => $page,
            'settings' => $settings,
            'sections' => $sections,
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
        $page = Page::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $settings = class_exists(Setting::class) ? (Setting::query()->first()) : null;

        $metaTitle = method_exists($page, 'translate')
            ? ($page->translate('meta_title') ?: $page->translate('title'))
            : ($page->meta_title ?? $page->title ?? null);

        $metaDescription = method_exists($page, 'translate')
            ? ($page->translate('meta_description') ?: ($page->excerpt ?? null))
            : ($page->meta_description ?? $page->excerpt ?? null);

        $sections = $page->sections ?? $page->data ?? [];
        $template = ($slug === 'home' || ($page->is_homepage ?? false))
            ? 'home'
            : ($page->template ?? 'generic');
        $view = view()->exists("templates.$template") ? "templates.$template" : (($slug === 'home') ? 'templates.home' : 'templates.generic');

        return view($view, [
            'page' => $page,
            'settings' => $settings,
            'sections' => $sections,
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



