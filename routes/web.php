<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\TemplatePreviewController;
use App\Models\Page;

// Debug Route - Veritabanı kontrolü
Route::get('/debug-homepage', function () {
    $page = Page::with(['headerTemplate', 'footerTemplate'])
        ->where('is_homepage', true)
        ->where('status', 'published')
        ->latest('updated_at')
        ->first();
    
    if (!$page) {
        return response()->json([
            'error' => 'Homepage bulunamadı!',
            'all_pages' => Page::select('id', 'title', 'slug', 'is_homepage', 'status')->get(),
        ]);
    }
    
    return response()->json([
        'page' => [
            'id' => $page->id,
            'title' => $page->title,
            'slug' => $page->slug,
            'is_homepage' => $page->is_homepage,
            'status' => $page->status,
        ],
        'header_template' => [
            'id' => $page->header_template_id,
            'exists' => $page->headerTemplate ? true : false,
            'title' => $page->headerTemplate?->title,
            'data_filled' => !empty($page->header_data),
            'data' => $page->header_data,
        ],
        'footer_template' => [
            'id' => $page->footer_template_id,
            'exists' => $page->footerTemplate ? true : false,
            'title' => $page->footerTemplate?->title,
            'data_filled' => !empty($page->footer_data),
            'data' => $page->footer_data,
        ],
        'sections' => [
            'count' => is_array($page->sections) ? count($page->sections) : 0,
            'data' => $page->sections,
        ],
        'sections_data' => [
            'count' => is_array($page->sections_data) ? count($page->sections_data) : 0,
            'data' => $page->sections_data,
        ],
    ]);
});

// Language Switch
Route::get('/lang/{locale}', function ($locale) {
    if (function_exists('switch_language')) {
        switch_language($locale);
    } else {
        $language = \App\Models\Language::findByCode($locale);
        if ($language && $language->is_active) {
            app()->setLocale($locale);
            session(['locale' => $locale]);
        }
    }
    return redirect()->back();
})->name('language.switch');

// Homepage -> admin panelinde "is_homepage" olarak işaretli sayfa dinamik olarak gösterilir
Route::get('/', [PageController::class, 'index'])->name('homepage');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{slug}/comment', [BlogController::class, 'storeComment'])->name('blog.comment.store');

// Template Preview (admin panel için)
Route::any('/admin/template-preview', [TemplatePreviewController::class, 'preview'])
    ->middleware(['auth'])
    ->name('template.preview');

// Pages (en sonda olmalı - catch-all)
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');
