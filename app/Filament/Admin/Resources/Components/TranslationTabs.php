<?php

namespace App\Filament\Admin\Resources\Components;

use App\Models\Language;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class TranslationTabs
{
    public static function make(array $fields = []): Tabs
    {
        $languages = Language::active()->ordered()->get();
        
        if ($languages->isEmpty()) {
            return Tabs::make('translations');
        }

        $tabs = [];

        foreach ($languages as $language) {
            // User permission kontrolü
            $canManage = auth()->user()?->canManageLanguage($language->code) ?? true;
            
            if (!$canManage) {
                continue;
            }

            $tabFields = [];

            foreach ($fields as $fieldName => $fieldConfig) {
                $fieldType = $fieldConfig['type'] ?? 'text';
                $label = $fieldConfig['label'] ?? ucfirst($fieldName);
                $required = $fieldConfig['required'] ?? false;
                $maxLength = $fieldConfig['maxLength'] ?? null;
                $rows = $fieldConfig['rows'] ?? 3;

                $fieldKey = "translations.{$language->code}.{$fieldName}";

                switch ($fieldType) {
                    case 'richtext':
                        $field = RichEditor::make($fieldKey)
                            ->label($label)
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('translations')
                            ->fileAttachmentsVisibility('public')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpanFull()
                            ->required($required);
                        break;

                    case 'textarea':
                        $field = Textarea::make($fieldKey)
                            ->label($label)
                            ->rows($rows)
                            ->columnSpanFull();
                        break;

                    case 'text':
                    default:
                        $field = TextInput::make($fieldKey)
                            ->label($label);
                        break;
                }

                if ($required) {
                    $field->required();
                }

                if ($maxLength) {
                    $field->maxLength($maxLength);
                }

                $tabFields[] = $field;
            }

            // Convert country code to flag emoji
            $code = strtoupper($language->code);
            $flag = '';
            for ($i = 0; $i < strlen($code); $i++) {
                $flag .= mb_chr(127397 + ord($code[$i]));
            }

            $tabs[] = Tab::make($language->name)
                ->label($flag . ' ' . $language->native_name)
                ->schema($tabFields)
                ->badge(fn ($record) => $record 
                    ? self::getTranslationBadge($record, $language->code) 
                    : null
                )
                ->badgeColor(fn ($record) => $record 
                    ? self::getTranslationBadgeColor($record, $language->code) 
                    : 'gray'
                );
        }

        return Tabs::make('translations')
            ->tabs($tabs)
            ->columnSpanFull()
            ->persistTabInQueryString();
    }

    protected static function getTranslationBadge($record, string $languageCode): ?string
    {
        if (!method_exists($record, 'getTranslationProgress')) {
            return null;
        }

        $progress = $record->getTranslationProgress();
        $percentage = $progress[$languageCode] ?? 0;

        if ($percentage === 100) {
            return '✓';
        } elseif ($percentage > 0) {
            return $percentage . '%';
        }

        return null;
    }

    protected static function getTranslationBadgeColor($record, string $languageCode): string
    {
        if (!method_exists($record, 'getTranslationProgress')) {
            return 'gray';
        }

        $progress = $record->getTranslationProgress();
        $percentage = $progress[$languageCode] ?? 0;

        if ($percentage === 100) {
            return 'success';
        } elseif ($percentage >= 50) {
            return 'warning';
        } elseif ($percentage > 0) {
            return 'danger';
        }

        return 'gray';
    }

    public static function fillFromRecord($record): array
    {
        $data = ['translations' => []];
        
        if (!method_exists($record, 'getTranslatableFields')) {
            return $data;
        }

        $languages = Language::active()->ordered()->get();
        $fields = $record->getTranslatableFields();

        foreach ($languages as $language) {
            $data['translations'][$language->code] = [];
            foreach ($fields as $field) {
                $translation = $record->getTranslation($field, $language->code, false);
                if ($translation) {
                    $data['translations'][$language->code][$field] = $translation->field_value;
                }
            }
        }

        return $data;
    }

    public static function saveTranslations($record, array $data): void
    {
        if (!method_exists($record, 'setTranslation')) {
            return;
        }

        $translations = $data['translations'] ?? [];

        \Log::info('Saving translations', ['data' => $translations]);

        foreach ($translations as $languageCode => $fields) {
            if (!is_array($fields)) {
                continue;
            }
            
            foreach ($fields as $fieldName => $value) {
                // Boş değerleri de kaydet (silme işlemi için)
                $record->setTranslation(
                    $fieldName,
                    $languageCode,
                    $value ?? '',
                    'published', // Default status
                    auth()->id()
                );
                
                \Log::info('Translation saved', [
                    'language' => $languageCode,
                    'field' => $fieldName,
                    'value' => substr($value ?? '', 0, 50)
                ]);
            }
        }
    }
}

