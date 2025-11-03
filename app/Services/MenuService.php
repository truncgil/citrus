<?php

namespace App\Services;

use App\Models\Page;
use Illuminate\Support\Facades\Cache;

class MenuService
{
    /**
     * Render menu structure as HTML
     * 
     * @param array|null $menuTemplate Optional menu template data
     * @return string Rendered menu HTML
     */
    public static function render(?array $menuTemplate = null): string
    {
        // Get menu items from Pages
        $menuItems = Cache::remember('menu_items', 3600, function () {
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
        });

        // If menu template is provided, use it to wrap the menu
        if ($menuTemplate && !empty($menuTemplate['html_content'])) {
            $html = $menuTemplate['html_content'];
            
            // Replace {menu} placeholder with rendered menu structure
            $renderedMenu = self::buildMenuStructure($menuItems);
            $html = str_replace('{menu}', $renderedMenu, $html);
            
            return $html;
        }

        // Otherwise, return default menu structure
        return self::buildMenuStructure($menuItems);
    }

    /**
     * Build menu structure HTML from menu items
     * 
     * @param \Illuminate\Support\Collection $menuItems
     * @return string HTML structure
     */
    protected static function buildMenuStructure($menuItems): string
    {
        if ($menuItems->isEmpty()) {
            return '';
        }

        $html = '<ul class="menu">';
        
        foreach ($menuItems as $item) {
            $hasChildren = $item->children->isNotEmpty();
            
            $html .= '<li class="menu-item">';
            $html .= '<a href="' . route('page.show', $item->slug) . '" class="menu-link">';
            $html .= e($item->title);
            $html .= '</a>';
            
            if ($hasChildren) {
                $html .= self::buildSubmenu($item->children);
            }
            
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }

    /**
     * Build submenu structure recursively
     * 
     * @param \Illuminate\Support\Collection $children
     * @return string Submenu HTML
     */
    protected static function buildSubmenu($children): string
    {
        $html = '<ul class="submenu">';
        
        foreach ($children as $child) {
            $hasChildren = $child->children->isNotEmpty();
            
            $html .= '<li class="submenu-item">';
            $html .= '<a href="' . route('page.show', $child->slug) . '" class="submenu-link">';
            $html .= e($child->title);
            $html .= '</a>';
            
            if ($hasChildren) {
                $html .= self::buildSubmenu($child->children);
            }
            
            $html .= '</li>';
        }
        
        $html .= '</ul>';
        
        return $html;
    }

    /**
     * Clear menu cache
     */
    public static function clearCache(): void
    {
        Cache::forget('menu_items');
    }
}

