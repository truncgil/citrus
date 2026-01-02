<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'product_category_id',
        'hero_image',
        'content',
        'view_template',
        'sort_order',
        'is_active',
        'landing_page_data',
    ];

    protected $translatable = [
        'title',
        'content',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'title' => 'array',
        'content' => 'array',
        'landing_page_data' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            // Eğer title boşsa ve translations içinden bir title geliyorsa onu ata
            if (empty($model->title)) {
                $translations = request()->input('translations');
                $defaultLocale = app()->getLocale();
                
                if (is_array($translations)) {
                    if (!empty($translations[$defaultLocale]['title'])) {
                        $model->title = $translations[$defaultLocale]['title'];
                    } else {
                        foreach ($translations as $locale => $fields) {
                            if (!empty($fields['title'])) {
                                $model->title = $fields['title'];
                                break;
                            }
                        }
                    }
                }
                
                if (empty($model->title)) {
                    $model->title = [];
                }
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }
}
