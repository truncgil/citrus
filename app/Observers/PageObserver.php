<?php

namespace App\Observers;

use App\Models\Page;

class PageObserver
{
    /**
     * Handle the Page "saving" event.
     * 
     * Bir sayfa homepage olarak işaretlendiğinde,
     * diğer tüm sayfaların homepage işaretini kaldır.
     */
    public function saving(Page $page): void
    {
        // Eğer bu sayfa homepage olarak işaretleniyorsa
        if ($page->is_homepage) {
            // Diğer tüm sayfaların homepage işaretini kaldır
            Page::where('id', '!=', $page->id)
                ->where('is_homepage', true)
                ->update(['is_homepage' => false]);
        }
    }
}

