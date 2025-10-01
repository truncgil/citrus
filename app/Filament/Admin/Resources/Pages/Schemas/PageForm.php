<?php

namespace App\Filament\Admin\Resources\Pages\Schemas;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
