<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Models\HeaderTemplate;
use App\Models\SectionTemplate;
use App\Models\FooterTemplate;
use App\Services\TemplateService;
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
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                // Sol kolon - Ana içerik (2 sütun genişliğinde)
                Section::make(__('pages.form_section_content'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('pages.title_field'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', \Str::slug($state));
                            }),
                        
                        TextInput::make('slug')
                            ->label(__('pages.slug_field'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText(__('pages.slug_helper_text')),
                        
                        RichEditor::make('content')
                            ->label(__('pages.content_field'))
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('pages')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull(),
                        
                        Textarea::make('excerpt')
                            ->label(__('pages.excerpt_field'))
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText(__('pages.excerpt_helper_text'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2)
                    ->collapsible(false),
                
                // Sağ kolon - Metadata ve öne çıkan görsel (1 sütun genişliğinde)
                Section::make(__('pages.form_section_page_settings'))
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label(__('pages.featured_image_field'))
                            ->image()
                            ->disk('public')
                            ->directory('pages/featured')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText(__('pages.featured_image_helper_text'))
                            ->columnSpanFull(),
                        
                        Select::make('author_id')
                            ->label(__('pages.author_field'))
                            ->relationship('author', 'name')
                            ->default(auth()->id())
                            ->required()
                            ->columnSpanFull(),
                        
                        DateTimePicker::make('published_at')
                            ->label(__('pages.published_at_field'))
                            ->displayFormat('d.m.Y H:i')
                            ->helperText(__('pages.published_at_helper_text'))
                            ->columnSpanFull(),
                        
                        Select::make('status')
                            ->label(__('pages.status_field'))
                            ->options([
                                'draft' => __('pages.status_draft'),
                                'published' => __('pages.status_published'),
                                'archived' => __('pages.status_archived'),
                            ])
                            ->default('draft')
                            ->required()
                            ->columnSpanFull(),
                        
                        Select::make('parent_id')
                            ->label(__('pages.parent_field'))
                            ->relationship('parent', 'title')
                            ->searchable()
                            ->preload()
                            ->helperText(__('pages.parent_helper_text'))
                            ->columnSpanFull(),
                        
                        Select::make('template')
                            ->label(__('pages.template_field'))
                            ->options([
                                'default' => __('pages.template_default'),
                                'landing' => __('pages.template_landing'),
                                'blog' => __('pages.template_blog'),
                                'contact' => __('pages.template_contact'),
                            ])
                            ->default('default')
                            ->columnSpanFull(),
                        
                        TextInput::make('sort_order')
                            ->label(__('pages.sort_order_field'))
                            ->numeric()
                            ->default(0)
                            ->helperText(__('pages.sort_order_helper_text'))
                            ->columnSpanFull(),
                        
                        Checkbox::make('is_homepage')
                            ->label(__('pages.is_homepage_field'))
                            ->helperText(__('pages.is_homepage_helper_text'))
                            ->columnSpanFull(),
                        
                        Checkbox::make('show_in_menu')
                            ->label(__('pages.show_in_menu_field'))
                            ->default(true)
                            ->helperText(__('pages.show_in_menu_helper_text'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1)
                    ->collapsible(false),
                
                // Alt kısım - SEO ayarları (tam genişlik)
                Section::make(__('pages.form_section_seo_settings'))
                    ->schema([
                        TextInput::make('meta_title')
                            ->label(__('pages.meta_title_field'))
                            ->maxLength(60)
                            ->helperText(__('pages.meta_title_helper_text')),
                        
                        Textarea::make('meta_description')
                            ->label(__('pages.meta_description_field'))
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText(__('pages.meta_description_helper_text'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(true),
                
                // Sayfa Bölümleri (Section Builder)
                Section::make(__('pages.form_section_sections'))
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
                                        
                                        // Text Input (displays and updates 'value' field)
                                        TextInput::make('_value_text')
                                            ->label(__('pages.section_data_value'))
                                            ->visible(fn (Get $get) => in_array($get('type'), ['text', 'url', 'email', 'phone', 'number']))
                                            ->numeric(fn (Get $get) => $get('type') === 'number')
                                            ->placeholder('Değer girin...')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                            ->afterStateHydrated(function ($component, $state, Get $get) {
                                                // Only hydrate if this field type is active
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
                                        
                                        // Textarea (displays and updates 'value' field)
                                        Textarea::make('_value_textarea')
                                            ->label(__('pages.section_data_value'))
                                            ->visible(fn (Get $get) => $get('type') === 'textarea')
                                            ->rows(4)
                                            ->placeholder('Metin girin...')
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                            ->afterStateHydrated(function ($component, $state, Get $get) {
                                                // Only hydrate if this field type is active
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
                                        
                                        // HTML Code Editor (displays and updates 'value' field)
                                        CodeEditor::make('_value_html')
                                            ->label(__('pages.section_data_value'))
                                            ->visible(fn (Get $get) => $get('type') === 'html')
                                            ->language(Language::Html)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                            ->afterStateHydrated(function ($component, $state, Get $get) {
                                                // Only hydrate if this field type is html
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
                                        
                                        // JSON Code Editor (displays and updates 'value' field)
                                        CodeEditor::make('_value_json')
                                            ->label(__('pages.section_data_value'))
                                            ->visible(fn (Get $get) => $get('type') === 'json')
                                            ->language(Language::Json)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => $set('value', $state))
                                            ->afterStateHydrated(function ($component, $state, Get $get) {
                                                // Only hydrate if this field type is json
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
                                        
                                        // Rich Text Editor (displays and updates 'value' field)
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
                                                // Only hydrate if this field type is richtext
                                                if ($get('type') !== 'richtext') {
                                                    return;
                                                }
                                                
                                                $value = $get('value');
                                                
                                                // Skip if null or empty
                                                if ($value === null || $value === '' || $value === []) {
                                                    return;
                                                }
                                                
                                                // Only set if it's valid TipTap JSON format
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
                                        
                                        // Markdown Editor (displays and updates 'value' field)
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
                                        
                                        // Image Upload (displays and updates 'value' field)
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
                                        
                                        // File Upload (displays and updates 'value' field)
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
                                        
                                        // Boolean Toggle (displays and updates 'value' field)
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
                                        
                                        // Color Picker (displays and updates 'value' field)
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
                                        
                                        // Date Picker (displays and updates 'value' field)
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
                                        
                                        // DateTime Picker (displays and updates 'value' field)
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
                                        
                                        // Array Repeater (displays and updates 'value' field)
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
                            ->itemLabel(fn (array $state): ?string => isset($state['type']) ? __('pages.section_type_' . $state['type']) : 'Bölüm')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(false),
                
                // Dynamic Template System
                Section::make(__('pages.form_section_header_template'))
                    ->description(__('pages.form_section_header_template_desc'))
                    ->schema([
                        Select::make('header_template_id')
                            ->label(__('pages.header_template_field'))
                            ->options(HeaderTemplate::where('is_active', true)->pluck('title', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, $state, $record) {
                                $template = HeaderTemplate::find($state);
                                if ($template && $template->default_data) {
                                    // If page doesn't have header_data or it's empty, load defaults
                                    $currentData = $record ? ($record->header_data ?? []) : ($get('header_data') ?? []);
                                    if (empty($currentData)) {
                                        $set('header_data', $template->default_data);
                                    }
                                } else {
                                    // If no template selected or no defaults, clear data
                                    if (!$record || empty($record->header_data)) {
                                        $set('header_data', []);
                                    }
                                }
                            })
                            ->columnSpanFull(),
                        
                        Group::make()
                            ->schema(function (Get $get, $record): array {
                                $template = HeaderTemplate::find($get('header_template_id'));
                                if (!$template) {
                                    return [];
                                }
                                
                                // Get page's header_data or template's default_data
                                $pageData = $record ? ($record->header_data ?? []) : ($get('header_data') ?? []);
                                $templateDefaults = $template->default_data ?? [];
                                
                                // Merge: page data overrides template defaults
                                $mergedData = array_merge($templateDefaults, $pageData);
                                
                                return TemplateService::generateDynamicFields(
                                    $template,
                                    'header_data',
                                    $mergedData
                                );
                            })
                            ->visible(fn (Get $get): bool => filled($get('header_template_id')))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(true),
                
                Section::make(__('pages.form_section_template_sections'))
                    ->description(__('pages.form_section_template_sections_desc'))
                    ->schema([
                        Repeater::make('sections_data')
                            ->label(__('pages.template_sections_field'))
                            ->schema([
                                Select::make('section_template_id')
                                    ->label(__('pages.section_template_field'))
                                    ->options(SectionTemplate::where('is_active', true)->pluck('title', 'id'))
                                    ->searchable()
                                    ->live()
                                    ->required()
                                    ->afterStateUpdated(function (Set $set, Get $get, $state, $record) {
                                        $template = SectionTemplate::find($state);
                                        if ($template && $template->default_data) {
                                            // If section doesn't have section_data or it's empty, load defaults
                                            $currentData = $get('section_data') ?? [];
                                            if (empty($currentData)) {
                                                $set('section_data', $template->default_data);
                                            }
                                        }
                                    })
                                    ->columnSpanFull(),
                                
                                Group::make()
                                    ->schema(function (Get $get): array {
                                        $template = SectionTemplate::find($get('section_template_id'));
                                        if (!$template) {
                                            return [];
                                        }
                                        
                                        // Get section's data or template's default_data
                                        $sectionData = $get('section_data') ?? [];
                                        $templateDefaults = $template->default_data ?? [];
                                        
                                        // Merge: section data overrides template defaults
                                        $mergedData = array_merge($templateDefaults, $sectionData);
                                        
                                        return TemplateService::generateDynamicFields(
                                            $template,
                                            'section_data',
                                            $mergedData
                                        );
                                    })
                                    ->visible(fn (Get $get): bool => filled($get('section_template_id')))
                                    ->columnSpanFull(),
                            ])
                            ->defaultItems(0)
                            ->addActionLabel(__('pages.add_template_section'))
                            ->reorderable()
                            ->collapsible()
                            ->itemLabel(fn (array $state): ?string => 
                                SectionTemplate::find($state['section_template_id'] ?? null)?->title ?? __('pages.template_section')
                            )
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(true),
                
                Section::make(__('pages.form_section_footer_template'))
                    ->description(__('pages.form_section_footer_template_desc'))
                    ->schema([
                        Select::make('footer_template_id')
                            ->label(__('pages.footer_template_field'))
                            ->options(FooterTemplate::where('is_active', true)->pluck('title', 'id'))
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function (Set $set, Get $get, $state, $record) {
                                $template = FooterTemplate::find($state);
                                if ($template && $template->default_data) {
                                    // If page doesn't have footer_data or it's empty, load defaults
                                    $currentData = $record ? ($record->footer_data ?? []) : ($get('footer_data') ?? []);
                                    if (empty($currentData)) {
                                        $set('footer_data', $template->default_data);
                                    }
                                } else {
                                    // If no template selected or no defaults, clear data
                                    if (!$record || empty($record->footer_data)) {
                                        $set('footer_data', []);
                                    }
                                }
                            })
                            ->columnSpanFull(),
                        
                        Group::make()
                            ->schema(function (Get $get, $record): array {
                                $template = FooterTemplate::find($get('footer_template_id'));
                                if (!$template) {
                                    return [];
                                }
                                
                                // Get page's footer_data or template's default_data
                                $pageData = $record ? ($record->footer_data ?? []) : ($get('footer_data') ?? []);
                                $templateDefaults = $template->default_data ?? [];
                                
                                // Merge: page data overrides template defaults
                                $mergedData = array_merge($templateDefaults, $pageData);
                                
                                return TemplateService::generateDynamicFields(
                                    $template,
                                    'footer_data',
                                    $mergedData
                                );
                            })
                            ->visible(fn (Get $get): bool => filled($get('footer_template_id')))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(true),
                
                // Çeviri Sekmesi
                Section::make('🌍 ' . __('pages.translations_section'))
                    ->schema([
                        TranslationTabs::make([
                            'title' => [
                                'type' => 'text',
                                'label' => __('pages.title_field'),
                                'required' => false,
                                'maxLength' => 255,
                            ],
                            'content' => [
                                'type' => 'richtext',
                                'label' => __('pages.content_field'),
                                'required' => false,
                            ],
                            'excerpt' => [
                                'type' => 'textarea',
                                'label' => __('pages.excerpt_field'),
                                'required' => false,
                                'maxLength' => 500,
                                'rows' => 3,
                            ],
                            'meta_title' => [
                                'type' => 'text',
                                'label' => __('pages.meta_title_field'),
                                'required' => false,
                                'maxLength' => 60,
                            ],
                            'meta_description' => [
                                'type' => 'textarea',
                                'label' => __('pages.meta_description_field'),
                                'required' => false,
                                'maxLength' => 160,
                                'rows' => 3,
                            ],
                        ]),
                    ])
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(false),
            ]);
    }
}
