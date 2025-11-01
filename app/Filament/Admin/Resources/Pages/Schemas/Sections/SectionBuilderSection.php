<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CodeEditor;
use Filament\Forms\Components\CodeEditor\Enums\Language;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

class SectionBuilderSection
{
    public static function make(): Section
    {
        return Section::make(__('pages.form_section_sections'))
            ->schema([
                Repeater::make('sections')
                    ->label(__('pages.sections_field'))
                    ->helperText(__('pages.sections_helper_text'))
                    ->schema([
                        Select::make('type')
                            ->label(__('pages.section_type'))
                            ->helperText(__('pages.section_type_helper'))
                            ->required()
                            ->options([
                                'hero' => __('pages.section_type_hero'),
                                'features' => __('pages.section_type_features'),
                                'stats' => __('pages.section_type_stats'),
                                'cta' => __('pages.section_type_cta'),
                                'content' => __('pages.section_type_content'),
                                'gallery' => __('pages.section_type_gallery'),
                                'testimonials' => __('pages.section_type_testimonials'),
                                'team' => __('pages.section_type_team'),
                                'pricing' => __('pages.section_type_pricing'),
                                'faq' => __('pages.section_type_faq'),
                                'contact' => __('pages.section_type_contact'),
                                'custom' => __('pages.section_type_custom'),
                            ])
                            ->live()
                            ->columnSpanFull(),
                        
                        Repeater::make('data')
                            ->label(__('pages.section_data'))
                            ->helperText(__('pages.section_data_helper'))
                            ->schema([
                                TextInput::make('key')
                                    ->label(__('pages.section_data_key'))
                                    ->helperText(__('pages.section_data_key_helper'))
                                    ->required()
                                    ->placeholder('title, subtitle, image, button_text, ...')
                                    ->columnSpan(1),
                                
                                Select::make('type')
                                    ->label(__('pages.section_data_value_type'))
                                    ->required()
                                    ->options([
                                        'text' => __('pages.value_type_text'),
                                        'textarea' => __('pages.value_type_textarea'),
                                        'html' => __('pages.value_type_html'),
                                        'markdown' => __('pages.value_type_markdown'),
                                        'richtext' => __('pages.value_type_richtext'),
                                        'image' => __('pages.value_type_image'),
                                        'file' => __('pages.value_type_file'),
                                        'url' => __('pages.value_type_url'),
                                        'email' => __('pages.value_type_email'),
                                        'phone' => __('pages.value_type_phone'),
                                        'number' => __('pages.value_type_number'),
                                        'boolean' => __('pages.value_type_boolean'),
                                        'color' => __('pages.value_type_color'),
                                        'date' => __('pages.value_type_date'),
                                        'datetime' => __('pages.value_type_datetime'),
                                        'array' => __('pages.value_type_array'),
                                        'json' => __('pages.value_type_json'),
                                    ])
                                    ->live()
                                    ->columnSpan(1),
                                
                                // Single Hidden Field to store the actual value
                                Hidden::make('value'),
                                
                                // Text Input
                                TextInput::make('_value_text')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => in_array($get('type'), ['text', 'url', 'email', 'phone', 'number']))
                                    ->numeric(fn (Get $get) => $get('type') === 'number')
                                    ->placeholder('Değer girin...')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if (!in_array($get('type'), ['text', 'url', 'email', 'phone', 'number'])) {
                                            return;
                                        }
                                        $value = $get('value');
                                        if ($value !== null) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Textarea
                                Textarea::make('_value_textarea')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'textarea')
                                    ->rows(4)
                                    ->placeholder('Metin girin...')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'textarea') {
                                            return;
                                        }
                                        $value = $get('value');
                                        if ($value !== null) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // HTML Code Editor
                                CodeEditor::make('_value_html')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'html')
                                    ->language(Language::Html)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'html') {
                                            return;
                                        }
                                        $value = $get('value');
                                        if ($value !== null) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // JSON Code Editor
                                CodeEditor::make('_value_json')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'json')
                                    ->language(Language::Json)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'json') {
                                            return;
                                        }
                                        $value = $get('value');
                                        if ($value !== null) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Rich Text Editor
                                RichEditor::make('_value_richtext')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'richtext')
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('pages/sections')
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'link',
                                        'bulletList',
                                        'orderedList',
                                    ])
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'richtext') {
                                            return;
                                        }
                                        
                                        $value = $get('value');
                                        
                                        if ($value === null || $value === '' || $value === []) {
                                            return;
                                        }
                                        
                                        if (is_array($value) && isset($value['type']) && $value['type'] === 'doc') {
                                            $component->state($value);
                                        } elseif (is_string($value)) {
                                            try {
                                                $decoded = json_decode($value, true);
                                                if (is_array($decoded) && isset($decoded['type']) && $decoded['type'] === 'doc') {
                                                    $component->state($decoded);
                                                }
                                            } catch (\Exception $e) {
                                                // Invalid JSON, skip
                                            }
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Markdown Editor
                                MarkdownEditor::make('_value_markdown')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'markdown')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'markdown') return;
                                        $value = $get('value');
                                        if ($value !== null && is_string($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Image Upload
                                FileUpload::make('_value_image')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'image')
                                    ->image()
                                    ->disk('public')
                                    ->directory('pages/sections')
                                    ->imageEditor()
                                    ->live()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'image') return;
                                        $value = $get('value');
                                        if ($value !== null && is_string($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // File Upload
                                FileUpload::make('_value_file')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'file')
                                    ->disk('public')
                                    ->directory('pages/sections')
                                    ->live()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'file') return;
                                        $value = $get('value');
                                        if ($value !== null && is_string($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Boolean Toggle
                                Toggle::make('_value_boolean')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'boolean')
                                    ->live()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'boolean') return;
                                        $value = $get('value');
                                        if ($value !== null && is_bool($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Color Picker
                                ColorPicker::make('_value_color')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'color')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'color') return;
                                        $value = $get('value');
                                        if ($value !== null && is_string($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Date Picker
                                DatePicker::make('_value_date')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'date')
                                    ->displayFormat('d/m/Y')
                                    ->live()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'date') return;
                                        $value = $get('value');
                                        if ($value !== null && is_string($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // DateTime Picker
                                DateTimePicker::make('_value_datetime')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'datetime')
                                    ->displayFormat('d/m/Y H:i')
                                    ->seconds(false)
                                    ->live()
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'datetime') return;
                                        $value = $get('value');
                                        if ($value !== null && is_string($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                                
                                // Array Repeater
                                Repeater::make('_value_array')
                                    ->label(__('pages.section_data_value'))
                                    ->visible(fn (Get $get) => $get('type') === 'array')
                                    ->simple(
                                        TextInput::make('item')
                                            ->label('Öğe')
                                            ->required()
                                    )
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                    ->afterStateHydrated(function ($component, $state, Get $get) {
                                        if ($get('type') !== 'array') return;
                                        $value = $get('value');
                                        if ($value !== null && is_array($value)) {
                                            $component->state($value);
                                        }
                                    })
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                            ])
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel(__('pages.section_data_add_field'))
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => isset($state['key']) ? $state['key'] . ' (' . ($state['type'] ?? 'text') . ')' : null)
                            ->columnSpanFull(),
                    ])
                    ->defaultItems(0)
                    ->addActionLabel(__('pages.section_add'))
                    ->reorderable()
                    ->collapsible()
                    ->collapsed()
                    ->itemLabel(fn (array $state): ?string => isset($state['type']) ? __('pages.section_type_' . $state['type']) : 'Bölüm')
                    ->columnSpanFull(),
            ])
            ->columnSpanFull()
            ->collapsible(true)
            ->collapsed(true);
    }
}

