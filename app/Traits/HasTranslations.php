<?php

namespace App\Traits;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait HasTranslations
{
    /**
     * Get all translations for this model
     */
    public function translations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    /**
     * Get translation for a specific field and language
     */
    public function getTranslation(string $fieldName, ?string $languageCode = null, bool $published = true): ?Translation
    {
        $languageCode = $languageCode ?? $this->getCurrentLanguageCode();

        $query = $this->translations()
            ->where('field_name', $fieldName)
            ->where('language_code', $languageCode);

        if ($published) {
            $query->where('status', 'published');
        }

        return $query->first();
    }

    /**
     * Get translation value for a specific field and language
     */
    public function translate(string $fieldName, ?string $languageCode = null, bool $fallback = true): mixed
    {
        $languageCode = $languageCode ?? $this->getCurrentLanguageCode();
        
        $translation = $this->getTranslation($fieldName, $languageCode);

        if ($translation) {
            return $translation->field_value;
        }

        // Fallback to default language
        if ($fallback && $languageCode !== $this->getDefaultLanguageCode()) {
            $defaultTranslation = $this->getTranslation($fieldName, $this->getDefaultLanguageCode());
            if ($defaultTranslation) {
                return $defaultTranslation->field_value;
            }
        }

        // Fallback to original field value
        return $this->{$fieldName} ?? null;
    }

    /**
     * Set translation for a specific field and language
     */
    public function setTranslation(
        string $fieldName, 
        string $languageCode, 
        mixed $value, 
        string $status = 'draft',
        ?int $userId = null
    ): Translation {
        $userId = $userId ?? auth()->id();

        return $this->translations()->updateOrCreate(
            [
                'field_name' => $fieldName,
                'language_code' => $languageCode,
            ],
            [
                'field_value' => $value,
                'status' => $status,
                'created_by' => $userId,
                'updated_by' => $userId,
            ]
        );
    }

    /**
     * Get all translations for a specific field
     */
    public function getTranslations(string $fieldName, bool $published = true): Collection
    {
        $query = $this->translations()
            ->where('field_name', $fieldName);

        if ($published) {
            $query->where('status', 'published');
        }

        return $query->get()->keyBy('language_code');
    }

    /**
     * Get all translations for a specific language
     */
    public function getTranslationsForLanguage(string $languageCode, bool $published = true): Collection
    {
        $query = $this->translations()
            ->where('language_code', $languageCode);

        if ($published) {
            $query->where('status', 'published');
        }

        return $query->get()->keyBy('field_name');
    }

    /**
     * Check if translation exists for a field and language
     */
    public function hasTranslation(string $fieldName, string $languageCode, bool $published = true): bool
    {
        $query = $this->translations()
            ->where('field_name', $fieldName)
            ->where('language_code', $languageCode);

        if ($published) {
            $query->where('status', 'published');
        }

        return $query->exists();
    }

    /**
     * Get translation progress for all languages
     */
    public function getTranslationProgress(): array
    {
        $languages = Language::active()->get();
        $translatableFields = $this->getTranslatableFields();
        $totalFields = count($translatableFields);

        $progress = [];

        foreach ($languages as $language) {
            $translatedCount = $this->translations()
                ->where('language_code', $language->code)
                ->where('status', 'published')
                ->whereIn('field_name', $translatableFields)
                ->count();

            $progress[$language->code] = $totalFields > 0 
                ? round(($translatedCount / $totalFields) * 100) 
                : 0;
        }

        return $progress;
    }

    /**
     * Get missing translations for a specific language
     */
    public function getMissingTranslations(string $languageCode): array
    {
        $translatableFields = $this->getTranslatableFields();
        
        $existingTranslations = $this->translations()
            ->where('language_code', $languageCode)
            ->where('status', 'published')
            ->pluck('field_name')
            ->toArray();

        return array_diff($translatableFields, $existingTranslations);
    }

    /**
     * Duplicate translation from one language to another
     */
    public function duplicateTranslation(string $fromLanguage, string $toLanguage, ?int $userId = null): int
    {
        $userId = $userId ?? auth()->id();
        $count = 0;

        $sourceTranslations = $this->getTranslationsForLanguage($fromLanguage, false);

        foreach ($sourceTranslations as $fieldName => $translation) {
            $this->setTranslation(
                $fieldName,
                $toLanguage,
                $translation->field_value,
                'draft',
                $userId
            );
            $count++;
        }

        return $count;
    }

    /**
     * Get translation status for a language
     */
    public function getTranslationStatus(string $languageCode): string
    {
        $progress = $this->getTranslationProgress();
        $percentage = $progress[$languageCode] ?? 0;

        if ($percentage === 100) {
            return 'complete';
        } elseif ($percentage > 0) {
            return 'partial';
        } else {
            return 'missing';
        }
    }

    /**
     * Sync translations for all translatable fields
     */
    public function syncTranslations(array $languageCodes, ?int $userId = null): void
    {
        $userId = $userId ?? auth()->id();
        $translatableFields = $this->getTranslatableFields();

        foreach ($languageCodes as $languageCode) {
            foreach ($translatableFields as $field) {
                if (!$this->hasTranslation($field, $languageCode, false)) {
                    $this->setTranslation(
                        $field,
                        $languageCode,
                        $this->{$field} ?? '',
                        'draft',
                        $userId
                    );
                }
            }
        }
    }

    /**
     * Get translatable fields for this model
     */
    public function getTranslatableFields(): array
    {
        return $this->translatable ?? [];
    }

    /**
     * Get current language code
     */
    protected function getCurrentLanguageCode(): string
    {
        return app()->getLocale();
    }

    /**
     * Get default language code
     */
    protected function getDefaultLanguageCode(): string
    {
        $defaultLanguage = Language::where('is_default', true)->first();
        return $defaultLanguage ? $defaultLanguage->code : config('app.locale');
    }

    /**
     * Scope: Filter by language
     */
    public function scopeWhereHasTranslation($query, string $languageCode, bool $published = true)
    {
        return $query->whereHas('translations', function ($q) use ($languageCode, $published) {
            $q->where('language_code', $languageCode);
            if ($published) {
                $q->where('status', 'published');
            }
        });
    }

    /**
     * Scope: Filter by user's languages
     */
    public function scopeWhereHasTranslationForUser($query, $user)
    {
        $languageCodes = $user->userLanguages()->pluck('language_code')->toArray();

        return $query->whereHas('translations', function ($q) use ($languageCodes) {
            $q->whereIn('language_code', $languageCodes);
        });
    }

    /**
     * Get translated model for current language
     */
    public function translated(?string $languageCode = null): self
    {
        $languageCode = $languageCode ?? $this->getCurrentLanguageCode();
        
        $translations = $this->getTranslationsForLanguage($languageCode);

        foreach ($translations as $fieldName => $translation) {
            if (in_array($fieldName, $this->getTranslatableFields())) {
                $this->{$fieldName} = $translation->field_value;
            }
        }

        return $this;
    }
}

