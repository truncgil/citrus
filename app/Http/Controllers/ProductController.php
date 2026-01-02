<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Setting;
use App\Models\HeaderTemplate;
use App\Models\FooterTemplate;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();
            
        // Get Settings
        $settings = new \stdClass();
        $allSettings = Setting::where('is_active', true)->get();
        foreach ($allSettings as $setting) {
            $settings->{$setting->key} = $setting->value;
        }

        // --- Header Logic ---
        $renderedHeader = null;
        $defaultHeaderId = $settings->default_header ?? null;
        
        if ($defaultHeaderId) {
            $headerTemplate = HeaderTemplate::find($defaultHeaderId);
            if ($headerTemplate) {
                $templateDefaults = $headerTemplate->default_data ?? [];
                $productData = []; // Ürünlere özel header datası eklenebilir
                $mergedHeaderData = array_merge($templateDefaults, $productData);
                
                $renderedHeader = TemplateService::replacePlaceholders(
                    $headerTemplate->html_content,
                    $mergedHeaderData,
                    $product // Model context
                );
            }
        }

        // --- Footer Logic ---
        $renderedFooter = null;
        $defaultFooterId = $settings->default_footer ?? null;
        
        if ($defaultFooterId) {
            $footerTemplate = FooterTemplate::find($defaultFooterId);
            if ($footerTemplate) {
                $templateDefaults = $footerTemplate->default_data ?? [];
                $productData = []; // Ürünlere özel footer datası eklenebilir
                $mergedFooterData = array_merge($templateDefaults, $productData);
                
                $renderedFooter = TemplateService::replacePlaceholders(
                    $footerTemplate->html_content,
                    $mergedFooterData,
                    $product // Model context
                );
            }
        }
        
        $meta = [
            'title' => $product->translate('title'),
            'description' => \Str::limit(strip_tags($product->translate('content')), 160),
        ];

        // Use custom view template if specified
        if ($product->view_template && view()->exists($product->view_template)) {
            return view($product->view_template, compact('product', 'settings', 'renderedHeader', 'renderedFooter', 'meta'));
        }

        // Use landing page template if landing_page_data exists and product type is 'product'
        if ($product->type === 'product' && !empty($product->landing_page_data)) {
            return view('front.products.landing', compact('product', 'settings', 'renderedHeader', 'renderedFooter', 'meta'));
        }

        // Default view
        return view('front.products.show', compact('product', 'settings', 'renderedHeader', 'renderedFooter', 'meta'));
    }
}
