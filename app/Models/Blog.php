<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
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
        'category_id',
        'tags',
        'view_count',
        'is_featured',
        'allow_comments',
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
        'tags' => 'array',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'view_count' => 'integer',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class);
    }

    // Route key için id kullan (Filament için gerekli)
    // public function getRouteKeyName()
    // {
    //     return 'slug';
    // }

    public function getUrlAttribute()
    {
        return '/blog/' . $this->slug;
    }

    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        
        return null;
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutesToRead = round($wordCount / 200); // Ortalama 200 kelime/dakika
        
        return max(1, $minutesToRead);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->where(function($q) {
                        $q->whereNull('published_at')
                          ->orWhere('published_at', '<=', now());
                    });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }
}
