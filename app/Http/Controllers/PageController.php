<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display the homepage or a specific page
     */
    public function index()
    {
        // Homepage'i bul
        $page = Page::where('is_homepage', true)
            ->where('status', 'published')
            ->first();

        if (!$page) {
            // Homepage yoksa, view'e boş geçelim
            return view('home', [
                'page' => null,
                'menuItems' => $this->getMenuItems()
            ]);
        }

        return view('home', [
            'page' => $page,
            'menuItems' => $this->getMenuItems()
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

        return view('page', [
            'page' => $page,
            'menuItems' => $this->getMenuItems()
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



