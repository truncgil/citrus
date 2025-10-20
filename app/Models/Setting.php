<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'is_public',
        'is_active',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Get setting by key
     */
    public static function get(string $key, $default = null)
    {
        $setting = static::where('key', $key)
            ->where('is_active', true)
            ->first();
            
        if (!$setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    /**
     * Set setting value
     */
    public static function set(string $key, $value, string $type = 'string'): void
    {
        static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'is_active' => true,
            ]
        );
    }

    /**
     * Cast value based on type
     */
    protected static function castValue($value, string $type)
    {
        return match($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'integer' => (int) $value,
            'float' => (float) $value,
            'array', 'json' => json_decode($value, true),
            default => $value,
        };
    }

    /**
     * Get all settings by group
     */
    public static function getGroup(string $group): array
    {
        return static::where('group', $group)
            ->where('is_active', true)
            ->pluck('value', 'key')
            ->map(function ($value, $key) use ($group) {
                $setting = static::where('key', $key)->first();
                return static::castValue($value, $setting->type);
            })
            ->toArray();
    }
}
