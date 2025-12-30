<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hash',
        'key',
        'translations',
    ];

    protected $casts = [
        'translations' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->hash)) {
                $model->hash = md5($model->key);
            }
        });
        
        static::updating(function ($model) {
            // Key değiştiyse hash'i güncelle
             if ($model->isDirty('key')) {
                $model->hash = md5($model->key);
            }
        });

        static::saved(function ($model) {
            Cache::forget("site_translation_{$model->hash}");
        });
    }

    /**
     * Get translation for a specific key
     */
    public static function getTranslation(string $key): string
    {
        $hash = md5($key);
        $locale = app()->getLocale();

        // Cache'ten veya DB'den al
        // Cache süresi: 24 saat
        $translation = Cache::remember("site_translation_{$hash}", 60 * 60 * 24, function () use ($hash, $key) {
            return static::firstOrCreate(
                ['hash' => $hash],
                ['key' => $key]
            );
        });

        // Eğer kayıt yeni oluşturulduysa ve key eksikse (concurrency nedeniyle), key'i set et
        if ($translation->wasRecentlyCreated && empty($translation->translations)) {
            // Yeni oluşturuldu, henüz çeviri yok.
            // Varsayılan olarak key'i döndür.
            return $key;
        }

        $translations = $translation->translations ?? [];

        if (isset($translations[$locale]) && !empty($translations[$locale])) {
            return $translations[$locale];
        }

        return $key;
    }
}
