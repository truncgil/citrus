<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists('setting')) {
    /**
     * Get setting value by key
     * 
     * @param string $key Setting key
     * @param mixed $default Default value if setting not found
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        // Cache settings to avoid database queries on every call
        // Cache will store the full setting object to access type info
        $setting = Cache::remember("app_setting_{$key}", 60 * 60 * 24, function () use ($key) {
            return Setting::where('key', $key)
                ->where('is_active', true)
                ->first();
        });

        if (!$setting) {
            return $default;
        }

        $value = $setting->value;

        // Handle file/image types
        if (in_array($setting->type, ['file', 'image']) || $key === 'home_hero') {
            if (empty($value)) {
                return $default;
            }
            
            // If value is already a URL, return it
            if (filter_var($value, FILTER_VALIDATE_URL)) {
                return $value;
            }
            
            // Return storage URL
            return Storage::url($value);
        }

        return $value;
    }
}
