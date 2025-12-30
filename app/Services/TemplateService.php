<?php

namespace App\Services;

use App\Models\HeaderTemplate;
use App\Models\SectionTemplate;
use App\Models\FooterTemplate;
use Illuminate\Database\Eloquent\Model;
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
     * 
     * @param array|null $defaultData Template's default_data array
     */
    public static function generateDynamicFields($template, string $dataKey, ?array $existingData = null, ?array $defaultData = null): array
    {
        if (!$template) {
            return [];
        }
        
        $placeholders = self::parsePlaceholders($template->html_content);
        $fields = [];
        
        foreach ($placeholders as $placeholder) {
            // Handle special.* prefix - remove it for processing
            $normalizedPlaceholder = $placeholder;
            if (str_starts_with($placeholder, 'special.')) {
                $normalizedPlaceholder = substr($placeholder, 8); // Remove 'special.' prefix
            }
            
            $parts = explode('.', $normalizedPlaceholder);
            
            if (count($parts) < 2) {
                continue; // Skip invalid placeholders
            }
            
            $type = $parts[0];
            
            // Skip special.* placeholders - they are special placeholders (page.*, menu, staticMenu), not form fields
            if (str_starts_with($placeholder, 'special.')) {
                continue;
            }

            // Skip setting.* placeholders - they are global settings managed via Settings module
            if ($type === 'setting') {
                continue;
            }
            
            // Skip custom.* placeholders - they are blade components, not form fields
            if ($type === 'custom') {
                continue;
            }
            
            // Skip page.* placeholders - they are special placeholders, not form fields
            if ($type === 'page') {
                continue;
            }
            
            // Skip menu and staticMenu placeholders - they are special placeholders, not form fields
            if ($normalizedPlaceholder === 'menu' || $normalizedPlaceholder === 'staticMenu') {
                continue;
            }
            
            // For form fields, we expect type.field format (2 parts)
            if (count($parts) !== 2) {
                continue; // Skip invalid placeholders
            }
            
            [$type, $name] = $parts;
            
            $label = str($name)->title()->replace('_', ' ')->toString();
            
            // Get existing value from existingData if provided
            $existingValue = $existingData[$placeholder] ?? null;
            
            // Get default value from template's default_data
            $defaultValue = $defaultData[$placeholder] ?? null;
            
            // If existing value is empty (null, empty string, empty array), use default
            $isValueEmpty = $existingValue === null 
                || $existingValue === '' 
                || (is_array($existingValue) && empty($existingValue));
            
            // Use default if existing value is empty
            $finalValue = $isValueEmpty && $defaultValue !== null ? $defaultValue : $existingValue;
            
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
                    // ->url() // Allow #, mailto, tel, relative paths
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
            
            // Set default value: use finalValue (which falls back to default if existing is empty)
            if ($finalValue !== null) {
                $field->default($finalValue);
            }
            
            $fields[] = $field;
        }
        
        return $fields;
    }

    /**
     * Parse placeholders from HTML content
     * Format: {type.field_name} or {type.field-name} or {special.type.field}
     */
    public static function parsePlaceholders(string $html): array
    {
        // Pattern: {type.field} or {special.type.field} or {type.field.field2} etc.
        preg_match_all('/\{([a-z]+(?:\.[a-z][a-z0-9_-]*)+)\}/i', $html, $matches);
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
     * Also supports {menu} and {staticMenu} placeholders for menu rendering
     * Also supports {custom.component_name} for custom blade components
     * Also supports {page.content}, {page.title}, {page.excerpt} for page data
     * 
     * @param string $html HTML content with placeholders
     * @param array $data Data array for placeholders
     * @param Model|null $model Optional model instance (Page, Blog, etc.) for dynamic data
     * @param array $defaultData Optional default data for fallback
     */
    public static function replacePlaceholders(string $html, array $data, ?Model $model = null, array $defaultData = []): string
    {
        // Legacy/Import artifact fix: Replace ___CUSTOM_...___ tokens if they exist in DB
        // These tokens might be leftover from import process if str_replace didn't catch them
        $html = str_replace('___SPECIAL_MENU___', '{custom.menu}', $html);
        $html = str_replace('___CUSTOM_MENU___', '{custom.menu}', $html);
        $html = str_replace('___CUSTOM_NAVBAR___', '{custom.navbar}', $html);
        $html = str_replace('___CUSTOM_LANGUAGE___', '{custom.language-selector}', $html);
        $html = str_replace('___SETTING_LANGUAGES___', '{custom.language-selector}', $html);

        // Handle special {page.content} placeholder - Sayfa/model içeriğini gösterir
        if (str_contains($html, '{page.content}')) {
            $pageContent = '';
            if ($model) {
                // Translation desteği varsa çeviriyi kullan
                if (method_exists($model, 'translate')) {
                    $pageContent = $model->translate('content') ?: ($model->content ?? '');
                } else {
                    $pageContent = $model->content ?? '';
                }
            }
            $html = str_replace('{page.content}', $pageContent ?? '', $html);
        }
        
        // Handle special {page.title} placeholder - Sayfa/model başlığını gösterir
        if (str_contains($html, '{page.title}')) {
            $pageTitle = '';
            if ($model) {
                if (method_exists($model, 'translate')) {
                    $pageTitle = $model->translate('title') ?: ($model->title ?? '');
                } else {
                    $pageTitle = $model->title ?? '';
                }
            }
            $html = str_replace('{page.title}', $pageTitle ?? '', $html);
        }
        
        // Handle special {page.excerpt} placeholder - Sayfa/model özetini gösterir
        if (str_contains($html, '{page.excerpt}')) {
            $pageExcerpt = '';
            if ($model) {
                if (method_exists($model, 'translate')) {
                    $pageExcerpt = $model->translate('excerpt') ?: ($model->excerpt ?? '');
                } else {
                    $pageExcerpt = $model->excerpt ?? '';
                }
            }
            $html = str_replace('{page.excerpt}', $pageExcerpt ?? '', $html);
        }
        
        // Handle special {menu} placeholder first
        if (str_contains($html, '{menu}')) {
            $renderedMenu = \App\Services\MenuService::render();
            $html = str_replace('{menu}', $renderedMenu, $html);
        }
        
        // Handle special {staticMenu} placeholder
        if (str_contains($html, '{staticMenu}')) {
            $renderedStaticMenu = view('components.static-menu')->render();
            $html = str_replace('{staticMenu}', $renderedStaticMenu, $html);
        }

        // Handle custom blade components: {custom.component_name} or {custom.component-name}
        preg_match_all('/\{custom\.([a-z][a-z_-]*)\}/i', $html, $customMatches);
        if (!empty($customMatches[0])) {
            foreach ($customMatches[0] as $index => $fullMatch) {
                $componentName = $customMatches[1][$index] ?? null;
                if ($componentName) {
                    // Normalize component name to lowercase for consistent file system access
                    $componentName = strtolower($componentName);
                    $viewPath = "components.custom.{$componentName}";
                    if (view()->exists($viewPath)) {
                        try {
                            $renderedComponent = view($viewPath)->render();
                            // Ensure rendered component is properly formatted
                            $renderedComponent = trim($renderedComponent);
                            $html = str_replace($fullMatch, $renderedComponent, $html);
                        } catch (\Exception $e) {
                            // Log the error for debugging
                            \Log::error("Custom component render error: {$viewPath}", [
                                'error' => $e->getMessage(),
                                'trace' => $e->getTraceAsString()
                            ]);
                            
                            // Show error message in preview (visible in development)
                            $errorMessage = htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                            $errorHtml = "<div style='padding: 10px; background: #fee; border: 1px solid #fcc; color: #c00; margin: 5px 0; border-radius: 4px;'>" .
                                       "<strong>Custom Component Error:</strong> {$viewPath}<br>" .
                                       "<small>{$errorMessage}</small>" .
                                       "</div>";
                            $html = str_replace($fullMatch, $errorHtml, $html);
                        }
                    } else {
                        // Component doesn't exist - show notice in preview
                        $noticeHtml = "<div style='padding: 10px; background: #fff3cd; border: 1px solid #ffc107; color: #856404; margin: 5px 0; border-radius: 4px;'>" .
                                    "<strong>Custom Component Not Found:</strong> {$viewPath}<br>" .
                                    "<small>Create the file at: resources/views/components/custom/{$componentName}.blade.php</small>" .
                                    "</div>";
                        $html = str_replace($fullMatch, $noticeHtml, $html);
                    }
                }
            }
        }

        // First, parse all placeholders in the format {type.field_name} or {type.field-name}
        // Also supports {special.page.title} format (special.* prefix)
        // Exclude custom.* from this regex to avoid double processing
        // Pattern: {type.field} or {special.type.field} or {type.field.field2} etc.
        preg_match_all('/\{([a-z]+(?:\.[a-z][a-z0-9_-]*)+)\}/i', $html, $matches);
        $placeholders = array_unique($matches[1] ?? []);
        
        // Filter out custom.* placeholders as they're already handled above
        $placeholders = array_filter($placeholders, function($placeholder) {
            return !str_starts_with($placeholder, 'custom.');
        });
        
        // Replace each placeholder
        foreach ($placeholders as $placeholder) {
            // Handle special.* prefix - remove it and process as normal placeholder
            // e.g., {special.page.title} -> {page.title}, {special.menu} -> {menu}
            $originalPlaceholder = $placeholder;
            if (str_starts_with($placeholder, 'special.')) {
                $placeholder = substr($placeholder, 8); // Remove 'special.' prefix (8 characters)
            }
            
            // Extract type from placeholder
            $parts = explode('.', $placeholder);
            $type = $parts[0] ?? null;
            $field = $parts[1] ?? null;
            
            // Handle special placeholders that were prefixed with special.*
            // These are page data placeholders: page.content, page.title, page.excerpt
            if ($type === 'page') {
                if ($field === 'content' && str_contains($html, '{' . $originalPlaceholder . '}')) {
                    $pageContent = '';
                    if ($model) {
                        if (method_exists($model, 'translate')) {
                            $pageContent = $model->translate('content') ?: $model->content;
                        } else {
                            $pageContent = $model->content;
                        }
                    }
                    $html = str_replace('{' . $originalPlaceholder . '}', $pageContent ?? '', $html);
                    continue;
                }
                
                if ($field === 'title' && str_contains($html, '{' . $originalPlaceholder . '}')) {
                    $pageTitle = '';
                    if ($model) {
                        if (method_exists($model, 'translate')) {
                            $pageTitle = $model->translate('title') ?: $model->title;
                        } else {
                            $pageTitle = $model->title;
                        }
                    }
                    $html = str_replace('{' . $originalPlaceholder . '}', $pageTitle ?? '', $html);
                    continue;
                }
                
                if ($field === 'excerpt' && str_contains($html, '{' . $originalPlaceholder . '}')) {
                    $pageExcerpt = '';
                    if ($model) {
                        if (method_exists($model, 'translate')) {
                            $pageExcerpt = $model->translate('excerpt') ?: $model->excerpt;
                        } else {
                            $pageExcerpt = $model->excerpt;
                        }
                    }
                    $html = str_replace('{' . $originalPlaceholder . '}', $pageExcerpt ?? '', $html);
                    continue;
                }
            }
            
            // Handle special menu placeholders that were prefixed with special.*
            if ($placeholder === 'menu' && str_contains($html, '{' . $originalPlaceholder . '}')) {
                $renderedMenu = \App\Services\MenuService::render();
                $html = str_replace('{' . $originalPlaceholder . '}', $renderedMenu, $html);
                continue;
            }
            
            if ($placeholder === 'staticMenu' && str_contains($html, '{' . $originalPlaceholder . '}')) {
                $renderedStaticMenu = view('components.static-menu')->render();
                $html = str_replace('{' . $originalPlaceholder . '}', $renderedStaticMenu, $html);
                continue;
            }
            
            // Handle setting.* placeholders - get value from Setting model
            if ($type === 'setting' && $field) {
                $value = setting($field, '');
                
                // Get setting type to determine if it's a file/image
                $settingModel = \App\Models\Setting::where('key', $field)->where('is_active', true)->first();
                if ($settingModel && in_array($settingModel->type, ['file', 'image'])) {
                    // For file/image settings, use file type for formatting
                    $type = 'file';
                }
            } else {
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
                
                // 4. If value not found in data and model is provided, try to get from model attributes/accessors
                if ($value === null && $model && count($parts) === 2) {
                    [$type, $field] = $parts;
                    
                    // First, try to get accessor with _url suffix for image/file fields (e.g., featured_image_url)
                    if (in_array($type, ['image', 'images', 'file', 'files'])) {
                        $accessorField = $field . '_url';
                        try {
                            // Laravel accessors are called as properties
                            if (isset($model->{$accessorField})) {
                                $value = $model->{$accessorField};
                            }
                        } catch (\Exception $e) {
                            // Accessor doesn't exist, continue to try attribute
                        }
                    }
                    
                    // Try to get from model attribute (e.g., featured_image, title, content)
                    if ($value === null) {
                        try {
                            // Try as property first (may trigger accessor)
                            if (isset($model->{$field})) {
                                $value = $model->{$field};
                            } else {
                                // Try getAttribute directly
                                $value = $model->getAttribute($field);
                            }
                        } catch (\Exception $e) {
                            // Attribute doesn't exist, value stays null
                        }
                    }
                }
            }
            
            // 5. Fallback to default data
            if (($value === null || $value === '') && isset($defaultData[$placeholder])) {
                $value = $defaultData[$placeholder];
            }
            
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
            // Also replace original placeholder if it was prefixed with special.*
            $replacements = [
                "{{$placeholder}}",
                "{{{$placeholder}}}"
            ];
            
            if ($originalPlaceholder !== $placeholder) {
                // Original placeholder had special.* prefix, replace it too
                $replacements[] = "{{$originalPlaceholder}}";
                $replacements[] = "{{{$originalPlaceholder}}}";
            }
            
            $html = str_replace($replacements, array_fill(0, count($replacements), $value), $html);
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

        // Support for old assets/ path (if import not run)
        if (str_starts_with($value, 'assets/')) {
            return asset($value);
        }
        
        // If it's already using asset() or Storage::url(), assume it's already formatted
        // Otherwise, prepend storage/ if it looks like a storage path
        if (!str_starts_with($value, '/')) {
            return asset('storage/' . $value);
        }
        
        return $value;
    }
}

