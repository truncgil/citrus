<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslations;

class ProductCategory extends Model
{
    use HasFactory, SoftDeletes, HasTranslations;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'sort_order',
        'is_active',
    ];

    protected $translatable = [
        'title',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'title' => 'array',
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
                    // Önce varsayılan dildeki çeviriye bak
                    if (!empty($translations[$defaultLocale]['title'])) {
                        $model->title = $translations[$defaultLocale]['title'];
                    } 
                    // Yoksa ilk bulduğu dolu çeviriyi al
                    else {
                        foreach ($translations as $locale => $fields) {
                            if (!empty($fields['title'])) {
                                $model->title = $fields['title'];
                                break;
                            }
                        }
                    }
                }
                
                // Hala boşsa boş bir array veya string ata (veritabanı hatasını önlemek için)
                if (empty($model->title)) {
                    $model->title = []; 
                }
            }
        });
    }

    public function parent()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
