<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'native_name',
        'flag',
        'direction',
        'is_active',
        'is_default',
        'sort_order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Boot method
     */
    protected static function boot(): void
    {
        parent::boot();

        // Only one default language allowed
        static::saving(function ($language) {
            if ($language->is_default) {
                static::where('id', '!=', $language->id)->update(['is_default' => false]);
            }
        });
    }

    /**
     * Relationships
     */
    public function translations(): HasMany
    {
        return $this->hasMany(Translation::class, 'language_code', 'code');
    }

    public function userLanguages(): HasMany
    {
        return $this->hasMany(UserLanguage::class, 'language_code', 'code');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Helpers
     */
    public static function getDefault(): ?self
    {
        return static::where('is_default', true)->first();
    }

    public static function getActive(): \Illuminate\Database\Eloquent\Collection
    {
        return static::active()->ordered()->get();
    }

    public static function findByCode(string $code): ?self
    {
        return static::where('code', $code)->first();
    }

    public function activate(): bool
    {
        $this->is_active = true;
        return $this->save();
    }

    public function deactivate(): bool
    {
        if ($this->is_default) {
            return false; // Cannot deactivate default language
        }
        $this->is_active = false;
        return $this->save();
    }

    public function setAsDefault(): bool
    {
        $this->is_default = true;
        $this->is_active = true;
        return $this->save();
    }
}
