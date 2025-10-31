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
     */
    public static function generateDynamicFields($template, string $dataKey): array
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
                    ->lineNumbers()
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
                    ->imageEditor()
                    ->imageEditorAspectRatios([null, '16:9', '4:3', '1:1'])
                    ->directory('templates/images')
                    ->maxSize(5120),
                
                'images' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->image()
                    ->multiple()
                    ->imageEditor()
                    ->directory('templates/images')
                    ->maxSize(5120)
                    ->maxFiles(10),
                
                'file' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->directory('templates/files')
                    ->maxSize(10240),
                
                'files' => FileUpload::make("{$dataKey}.{$placeholder}")
                    ->label($label)
                    ->multiple()
                    ->directory('templates/files')
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
     */
    public static function replacePlaceholders(string $html, array $data): string
    {
        foreach ($data as $placeholder => $value) {
            // Handle different value types
            if (is_array($value)) {
                $value = implode(', ', $value);
            } elseif (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            }
            
            $html = str_replace("{{$placeholder}}", $value ?? '', $html);
        }
        
        return $html;
    }
}

