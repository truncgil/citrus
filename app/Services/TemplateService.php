<?php

namespace App\Services;

use App\Models\HeaderTemplate;
use App\Models\SectionTemplate;
use App\Models\FooterTemplate;
use Filament\Forms\Components\{
    TextInput, Textarea, Select, Checkbox, CheckboxList,
    Radio, Toggle, ToggleButtons, DateTimePicker, DatePicker,
    TimePicker, FileUpload, RichEditor, MarkdownEditor, 
    ColorPicker, TagsInput, KeyValue, CodeEditor, Hidden, Slider
};

class TemplateService
{
    /**
     * Generate dynamic form fields based on template placeholders
     * For default data (template forms), use dataKey = 'default_data'
     * For page data (page forms), use dataKey = 'header_data' or 'footer_data'
     */
    public static function generateDynamicFields($template, string $dataKey, ?array $existingData = null): array
    {
        if (!$template) {
            return [];
        }
        
        $placeholders = self::parsePlaceholders($template->html_content);
        $fields = [];
        
        foreach ($placeholders as $placeholder) {
            $parts = explode('.', $placeholder);
            
            if (count($parts) !== 2) {
                continue; // Skip invalid placeholders
            }
            
            [$type, $name] = $parts;
            
            $label = str($name)->title()->replace('_', ' ')->toString();
            
            // Get existing value from existingData if provided
            $existingValue = $existingData[$placeholder] ?? null;
            
            $field = match($type) {
                // Text Input Variants
                'text' => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->maxLength(255),
                
                'email' => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->email()
                    ->maxLength(255),
                
                'url' => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->url()
                    ->maxLength(500),
                
                'tel' => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->tel()
                    ->maxLength(20),
                
                'number' => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->numeric(),
                
                'password' => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->password()
                    ->dehydrated(fn ($state) => filled($state))
                    ->maxLength(255),
                
                // Text Area & Editors
                'textarea' => Textarea::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->rows(4)
                    ->maxLength(5000),
                
                'richtext' => RichEditor::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'link',
                        'bulletList', 'orderedList', 'h2', 'h3',
                    ])
                    ->maxLength(50000),
                
                'markdown' => MarkdownEditor::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->toolbarButtons([
                        'bold', 'italic', 'strike', 'link',
                        'heading', 'bulletList', 'orderedList', 'codeBlock',
                    ])
                    ->maxLength(50000),
                
                'code' => CodeEditor::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    //->lineNumbers()
                    ->maxLength(50000),
                
                // Date & Time
                'date' => DatePicker::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->native(false),
                
                'datetime' => DateTimePicker::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->native(false)
                    ->seconds(false),
                
                'time' => TimePicker::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->native(false)
                    ->seconds(false),
                
                // File Uploads
                'image' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->image()
                    ->disk('public')
                    ->directory('templates/images')
                    ->imageEditor()
                    ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1'])
                    ->maxSize(5120),
                
                'images' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->image()
                    ->disk('public')
                    ->directory('templates/images')
                    ->multiple()
                    ->imageEditor()
                    ->maxSize(5120)
                    ->maxFiles(10),
                
                'file' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->disk('public')
                    ->directory('templates/files')
                    ->maxSize(10240),
                
                'files' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->disk('public')
                    ->directory('templates/files')
                    ->multiple()
                    ->maxSize(10240)
                    ->maxFiles(10),
                
                // Selection & Options
                'select' => Select::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->options(self::getSelectOptions($name))
                    ->searchable(),
                
                'multiselect' => Select::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->multiple()
                    ->options(self::getSelectOptions($name))
                    ->searchable(),
                
                'checkbox' => Checkbox::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->inline(false),
                
                'checkboxlist' => CheckboxList::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->options(self::getSelectOptions($name))
                    ->columns(2),
                
                'radio' => Radio::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->options(self::getSelectOptions($name))
                    ->inline()
                    ->inlineLabel(false),
                
                'toggle' => Toggle::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->inline(false),
                
                'togglebuttons' => ToggleButtons::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->options(self::getSelectOptions($name))
                    ->inline()
                    ->grouped(),
                
                // Color & Visual
                'color' => ColorPicker::make("{$dataKey}.{$placeholder}")
                    ->label($label),
                
                // Structured Data
                'tags' => TagsInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->separator(','),
                
                'keyvalue' => KeyValue::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->keyLabel('Key')
                    ->valueLabel('Value')
                    ->reorderable(),
                
                // Advanced
                'slider' => Slider::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(1),
                
                'hidden' => Hidden::make("{$dataKey}.{$placeholder}"),
                
                // Default
                default => TextInput::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->maxLength(255)
                    ->helperText("Unknown type: {$type}"),
            };
            
            // Set default value if existingValue is provided
            if ($existingValue !== null) {
                $field->default($existingValue);
            }
            
            $fields[] = $field;
        }
        
        return $fields;
    }

    /**
     * Parse placeholders from HTML content
     * Format: {type.field_name}
     */
    public static function parsePlaceholders(string $html): array
    {
        preg_match_all('/\{([a-z]+\.[a-z_]+)\}/i', $html, $matches);
        return array_unique($matches[1] ?? []);
    }

    /**
     * Get select options for a field
     * Can be extended to load from database or config
     */
    protected static function getSelectOptions(string $fieldName): array
    {
        return config("template-options.{$fieldName}", [
            'option_1' => __('Option 1'),
            'option_2' => __('Option 2'),
            'option_3' => __('Option 3'),
        ]);
    }

    /**
     * Replace placeholders in HTML with actual data
     * Supports both {text.title} and {{text.title}} formats
     */
    public static function replacePlaceholders(string $html, array $data): string
    {
        // First, parse all placeholders in the format {type.field_name}
        preg_match_all('/\{([a-z]+\.[a-z_]+)\}/i', $html, $matches);
        $placeholders = array_unique($matches[1] ?? []);
        
        // Replace each placeholder
        foreach ($placeholders as $placeholder) {
            // Try to find the value in data with various key formats
            $value = null;
            
            // 1. Try exact match (text.title)
            if (isset($data[$placeholder])) {
                $value = $data[$placeholder];
            }
            // 2. Try with section_data prefix (section_data.text.title)
            elseif (isset($data["section_data.{$placeholder}"])) {
                $value = $data["section_data.{$placeholder}"];
            }
            // 3. Try nested array access (data['section_data']['text.title'] or data['text']['title'])
            else {
                $parts = explode('.', $placeholder);
                if (count($parts) === 2) {
                    [$type, $field] = $parts;
                    // Try nested: data['section_data'][$type][$field]
                    if (isset($data['section_data'][$type][$field])) {
                        $value = $data['section_data'][$type][$field];
                    }
                    // Try nested: data[$type][$field]
                    elseif (isset($data[$type][$field])) {
                        $value = $data[$type][$field];
                    }
                }
            }
            
            // Extract type from placeholder to determine if it's a file/image
            $parts = explode('.', $placeholder);
            $type = $parts[0] ?? null;
            
            // Handle different value types
            if (is_array($value)) {
                // Handle arrays (e.g., multiple images)
                $value = array_map(function($item) use ($type) {
                    return self::formatFileUrl($item, $type);
                }, $value);
                $value = implode(', ', $value);
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            } elseif ($value === null) {
                $value = '';
            } else {
                // Format file/image URLs
                $value = self::formatFileUrl($value, $type);
            }
            
            // Replace both {text.title} and {{text.title}} formats
            $html = str_replace(
                ["{{$placeholder}}", "{{{$placeholder}}}"],
                [$value, $value],
                $html
            );
        }
        
        return $html;
    }
    
    /**
     * Format file URL based on type
     * Converts storage paths to public URLs
     */
    protected static function formatFileUrl($value, $type): string
    {
        // If it's already a full URL, return as is
        if (is_string($value) && (str_starts_with($value, 'http://') || str_starts_with($value, 'https://'))) {
            return $value;
        }
        
        // Only process image and file types
        if (!in_array($type, ['image', 'images', 'file', 'files'])) {
            return (string) $value;
        }
        
        // If value is empty, return empty string
        if (empty($value) || !is_string($value)) {
            return '';
        }
        
        // Check if the path starts with storage/ (already formatted)
        if (str_starts_with($value, 'storage/')) {
            return asset($value);
        }
        
        // Remove private/ prefix if exists (old format from private disk)
        if (str_starts_with($value, 'private/')) {
            $value = str_replace('private/', '', $value);
        }
        
        // Check if the path is a relative path that should be in storage
        // Templates are stored in templates/images or templates/files
        if (str_starts_with($value, 'templates/')) {
            return asset('storage/' . $value);
        }
        
        // If it's already using asset() or Storage::url(), assume it's already formatted
        // Otherwise, prepend storage/ if it looks like a storage path
        if (!str_starts_with($value, '/')) {
            return asset('storage/' . $value);
        }
        
        return $value;
    }
}

