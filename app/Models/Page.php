<?php

namespace App\Models;

use App\Models\SectionTemplate;
use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
        'status',
        'featured_image',
        'published_at',
        'author_id',
        'parent_id',
        'sort_order',
        'template',
        'is_homepage',
        'show_in_menu',
        'sections',
        'data',
        // Template System
        'header_template_id',
        'header_data',
        'footer_template_id',
        'footer_data',
        'sections_data',
    ];

    /**
     * Translatable fields
     */
    protected $translatable = [
        'title',
        'content',
        'excerpt',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_homepage' => 'boolean',
        'show_in_menu' => 'boolean',
        'sort_order' => 'integer',
        'sections' => 'array',
        'data' => 'array',
        // Template System
        'header_data' => 'array',
        'footer_data' => 'array',
        'sections_data' => 'array',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    /**
     * Get the header template for the page.
     */
    public function headerTemplate()
    {
        return $this->belongsTo(HeaderTemplate::class, 'header_template_id');
    }

    /**
     * Get the footer template for the page.
     */
    public function footerTemplate()
    {
        return $this->belongsTo(FooterTemplate::class, 'footer_template_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getUrlAttribute()
    {
        if ($this->is_homepage) {
            return '/';
        }
        
        return '/' . $this->slug;
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        
        return null;
    }
    
    /**
     * Get sections with parsed data as associative array
     */
    public function getParsedSectionsAttribute()
    {
        if (!$this->sections || !is_array($this->sections)) {
            return [];
        }
        
        return collect($this->sections)->map(function ($section) {
            if (!isset($section['data']) || !is_array($section['data'])) {
                return $section;
            }
            
            // Convert key-value-type array to associative array
            $parsedData = collect($section['data'])->pluck('value', 'key')->toArray();
            
            return [
                'type' => $section['type'] ?? null,
                'data' => $parsedData,
            ];
        })->toArray();
    }
    
    /**
     * Get a specific section's data by type
     */
    public function getSectionData(string $type, int $index = 0): ?array
    {
        $sections = $this->parsed_sections;
        $matchingSections = array_filter($sections, fn($s) => ($s['type'] ?? null) === $type);
        $matchingSections = array_values($matchingSections);
        
        return $matchingSections[$index] ?? null;
    }

    /**
     * Get templated sections with their templates loaded.
     * Used for new dynamic template system.
     */
    public function getTemplatedSectionsAttribute()
    {
        if (!$this->sections_data || !is_array($this->sections_data)) {
            return collect([]);
        }

        return collect($this->sections_data)->map(function ($section) {
            $templateId = $section['section_template_id'] ?? null;
            $template = $templateId ? SectionTemplate::find($templateId) : null;

            return [
                'template' => $template,
                'data' => $section['section_data'] ?? [],
            ];
        })->filter(fn($section) => $section['template'] !== null);
    }
}
