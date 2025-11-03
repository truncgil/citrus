<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class GuideService
{
    /**
     * Guide dosyalarının bulunduğu dizin
     */
    protected string $guidePath;

    public function __construct()
    {
        $this->guidePath = resource_path('views/guide');
    }

    /**
     * Tüm markdown dosyalarını son güncellenme tarihine göre sıralı olarak getir
     * 
     * @return array
     */
    public function getAllGuides(): array
    {
        if (!File::exists($this->guidePath)) {
            return [];
        }

        $files = File::glob($this->guidePath . '/*.md');
        
        $guides = [];
        
        foreach ($files as $file) {
            $filename = File::basename($file);
            $name = Str::before($filename, '.md');
            $modifiedTime = File::lastModified($file);
            
            $guides[] = [
                'filename' => $filename,
                'name' => $name,
                'slug' => Str::slug($name),
                'path' => $file,
                'modified_time' => $modifiedTime,
                'modified_date' => date('Y-m-d H:i:s', $modifiedTime),
            ];
        }

        // Son güncellenenden ilk güncellenene göre sırala
        usort($guides, function ($a, $b) {
            return $b['modified_time'] <=> $a['modified_time'];
        });

        return $guides;
    }

    /**
     * Belirli bir guide dosyasını getir
     * 
     * @param string $slug
     * @return array|null
     */
    public function getGuide(string $slug): ?array
    {
        $guides = $this->getAllGuides();
        
        foreach ($guides as $guide) {
            if ($guide['slug'] === $slug) {
                $guide['content'] = File::get($guide['path']);
                return $guide;
            }
        }

        return null;
    }

    /**
     * İlk guide'ı getir (varsayılan olarak gösterilecek)
     * 
     * @return array|null
     */
    public function getFirstGuide(): ?array
    {
        $guides = $this->getAllGuides();
        
        if (empty($guides)) {
            return null;
        }

        $firstGuide = $guides[0];
        $firstGuide['content'] = File::get($firstGuide['path']);
        
        return $firstGuide;
    }

    /**
     * Guide dosyasının var olup olmadığını kontrol et
     * 
     * @param string $slug
     * @return bool
     */
    public function guideExists(string $slug): bool
    {
        return $this->getGuide($slug) !== null;
    }
}

