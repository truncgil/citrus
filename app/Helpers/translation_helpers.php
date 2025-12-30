<?php

use App\Models\Language;
use App\Models\Translation;
use App\Models\SiteTranslation;
use Illuminate\Support\Collection;

if (!function_exists('current_language')) {
    /**
     * Get current active language
     */
    function current_language(): ?Language
    {
        return Language::findByCode(app()->getLocale());
    }
}

if (!function_exists('current_language_code')) {
    /**
     * Get current language code
     */
    function current_language_code(): string
    {
        return app()->getLocale();
    }
}

if (!function_exists('default_language')) {
    /**
     * Get default language
     */
    function default_language(): ?Language
    {
        return Language::getDefault();
    }
}

if (!function_exists('default_language_code')) {
    /**
     * Get default language code
     */
    function default_language_code(): string
    {
        $defaultLanguage = Language::getDefault();
        return $defaultLanguage ? $defaultLanguage->code : config('app.locale');
    }
}

if (!function_exists('available_languages')) {
    /**
     * Get all active languages
     */
    function available_languages(): Collection
    {
        return Language::getActive();
    }
}

if (!function_exists('available_language_codes')) {
    /**
     * Get all active language codes
     */
    function available_language_codes(): array
    {
        return Language::active()->pluck('code')->toArray();
    }
}

if (!function_exists('translate_model')) {
    /**
     * Get translated value for a model field
     * 
     * @param mixed $model Model instance
     * @param string $field Field name to translate
     * @param string|null $languageCode Language code (null for current)
     * @param bool $fallback Use fallback to default language
     * @return mixed
     */
    function translate_model($model, string $field, ?string $languageCode = null, bool $fallback = true): mixed
    {
        if (!method_exists($model, 'translate')) {
            return $model->{$field} ?? null;
        }

        return $model->translate($field, $languageCode, $fallback);
    }
}

if (!function_exists('has_translation')) {
    /**
     * Check if model has translation for field and language
     */
    function has_translation($model, string $field, ?string $languageCode = null): bool
    {
        if (!method_exists($model, 'hasTranslation')) {
            return false;
        }

        $languageCode = $languageCode ?? current_language_code();
        return $model->hasTranslation($field, $languageCode);
    }
}

if (!function_exists('translation_progress')) {
    /**
     * Get translation progress for a model
     */
    function translation_progress($model, ?string $languageCode = null): int
    {
        if (!method_exists($model, 'getTranslationProgress')) {
            return 0;
        }

        $progress = $model->getTranslationProgress();
        
        if ($languageCode) {
            return $progress[$languageCode] ?? 0;
        }

        return $progress;
    }
}

if (!function_exists('user_can_manage_language')) {
    /**
     * Check if current user can manage a language
     */
    function user_can_manage_language(string $languageCode): bool
    {
        $user = auth()->user();
        
        if (!$user || !method_exists($user, 'canManageLanguage')) {
            return false;
        }

        return $user->canManageLanguage($languageCode);
    }
}

if (!function_exists('user_managed_languages')) {
    /**
     * Get languages that current user can manage
     */
    function user_managed_languages(): Collection
    {
        $user = auth()->user();
        
        if (!$user || !method_exists($user, 'getManagedLanguages')) {
            return collect();
        }

        return $user->getManagedLanguages();
    }
}

if (!function_exists('user_managed_language_codes')) {
    /**
     * Get language codes that current user can manage
     */
    function user_managed_language_codes(): array
    {
        $user = auth()->user();
        
        if (!$user || !method_exists($user, 'getManagedLanguageCodes')) {
            return [];
        }

        return $user->getManagedLanguageCodes();
    }
}

if (!function_exists('switch_language')) {
    /**
     * Switch application language
     */
    function switch_language(string $languageCode): bool
    {
        $language = Language::findByCode($languageCode);
        
        if (!$language || !$language->is_active) {
            return false;
        }

        app()->setLocale($languageCode);
        session(['locale' => $languageCode]);

        return true;
    }
}

if (!function_exists('get_translation_status_badge')) {
    /**
     * Get translation status badge HTML
     */
    function get_translation_status_badge(string $status): string
    {
        $badges = [
            'draft' => '<span class="badge badge-secondary">Draft</span>',
            'review' => '<span class="badge badge-warning">Review</span>',
            'approved' => '<span class="badge badge-success">Approved</span>',
            'published' => '<span class="badge badge-primary">Published</span>',
        ];

        return $badges[$status] ?? $badges['draft'];
    }
}

if (!function_exists('get_translation_status_color')) {
    /**
     * Get translation status color
     */
    function get_translation_status_color(string $status): string
    {
        $colors = [
            'draft' => 'gray',
            'review' => 'warning',
            'approved' => 'success',
            'published' => 'primary',
        ];

        return $colors[$status] ?? 'gray';
    }
}

if (!function_exists('get_language_flag')) {
    /**
     * Get language flag emoji or icon
     */
    function get_language_flag(string $languageCode): string
    {
        $language = Language::findByCode($languageCode);
        return $language ? ($language->flag ?? '🌐') : '🌐';
    }
}

if (!function_exists('format_language_name')) {
    /**
     * Format language name with native name
     */
    function format_language_name(string $languageCode): string
    {
        $language = Language::findByCode($languageCode);
        
        if (!$language) {
            return $languageCode;
        }

        return "{$language->name} ({$language->native_name})";
    }
}

if (!function_exists('translation_exists')) {
    /**
     * Check if a translation exists in database
     */
    function translation_exists(string $modelClass, int $modelId, string $field, string $languageCode): bool
    {
        return Translation::forModel($modelClass, $modelId)
            ->forField($field)
            ->forLanguage($languageCode)
            ->exists();
    }
}

if (!function_exists('get_translation_value')) {
    /**
     * Get translation value directly from Translation model
     */
    function get_translation_value(string $modelClass, int $modelId, string $field, ?string $languageCode = null): ?string
    {
        $languageCode = $languageCode ?? current_language_code();
        
        $translation = Translation::forModel($modelClass, $modelId)
            ->forField($field)
            ->forLanguage($languageCode)
            ->published()
            ->first();

        return $translation ? $translation->field_value : null;
    }
}

if (!function_exists('t')) {
    /**
     * Get site translation for a given key.
     *
     * @param string $key
     * @return string
     */
    function t(string $key): string
    {
        if (empty($key)) {
            return '';
        }
        return SiteTranslation::getTranslation($key);
    }
}

