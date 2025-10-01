<?php

namespace App\Filament\Admin\Resources\Blogs\Schemas;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                // Sol kolon - Ana içerik (2 sütun genişliğinde)
                Section::make(__('blog.content_section'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('blog.title_field'))
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
                            ->label(__('blog.slug_field'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText(__('blog.slug_helper')),
                        
                        RichEditor::make('content')
                            ->label(__('blog.content_field'))
                            ->required()
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('blogs')
                            ->fileAttachmentsVisibility('public')
                            ->columnSpanFull(),
                        
                        Textarea::make('excerpt')
                            ->label(__('blog.excerpt_field'))
                            ->rows(3)
                            ->maxLength(500)
                            ->helperText(__('blog.excerpt_helper'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(2)
                    ->collapsible(false),
                
                // Sağ kolon - Metadata ve öne çıkan görsel (1 sütun genişliğinde)
                Section::make(__('blog.settings_section'))
                    ->schema([
                        FileUpload::make('featured_image')
                            ->label(__('blog.featured_image_field'))
                            ->image()
                            ->disk('public')
                            ->directory('blogs/featured')
                            ->visibility('public')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                            ->helperText(__('blog.featured_image_helper'))
                            ->columnSpanFull(),
                        
                        Select::make('author_id')
                            ->label(__('blog.author_field'))
                            ->relationship('author', 'name')
                            ->default(auth()->id())
                            ->required()
                            ->columnSpanFull(),
                        
                        Select::make('category_id')
                            ->label(__('blog.category_field'))
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->helperText(__('blog.category_helper'))
                            ->columnSpanFull(),
                        
                        TagsInput::make('tags')
                            ->label(__('blog.tags_field'))
                            ->helperText(__('blog.tags_helper'))
                            ->columnSpanFull(),
                        
                        DateTimePicker::make('published_at')
                            ->label(__('blog.published_at_field'))
                            ->displayFormat('d.m.Y H:i')
                            ->helperText(__('blog.published_at_helper'))
                            ->columnSpanFull(),
                        
                        Select::make('status')
                            ->label(__('blog.status_field'))
                            ->options([
                                'draft' => __('blog.status_draft'),
                                'published' => __('blog.status_published'),
                                'archived' => __('blog.status_archived'),
                            ])
                            ->default('draft')
                            ->required()
                            ->columnSpanFull(),
                        
                        Checkbox::make('is_featured')
                            ->label(__('blog.is_featured_field'))
                            ->helperText(__('blog.is_featured_helper'))
                            ->columnSpanFull(),
                        
                        Checkbox::make('allow_comments')
                            ->label(__('blog.allow_comments_field'))
                            ->default(true)
                            ->helperText(__('blog.allow_comments_helper'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(1)
                    ->collapsible(false),
                
                // Alt kısım - SEO ayarları (tam genişlik)
                Section::make(__('blog.seo_section'))
                    ->schema([
                        TextInput::make('meta_title')
                            ->label(__('blog.meta_title_field'))
                            ->maxLength(60)
                            ->helperText(__('blog.meta_title_helper')),
                        
                        Textarea::make('meta_description')
                            ->label(__('blog.meta_description_field'))
                            ->rows(3)
                            ->maxLength(160)
                            ->helperText(__('blog.meta_description_helper'))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull()
                    ->collapsible(true)
                    ->collapsed(true),
                
                // Çeviri Sekmesi
                Section::make('🌍 ' . __('blog.translations_section'))
                    ->schema([
                        TranslationTabs::make([
                            'title' => [
                                'type' => 'text',
                                'label' => __('blog.title_field'),
                                'required' => false,
                                'maxLength' => 255,
                            ],
                            'content' => [
                                'type' => 'richtext',
                                'label' => __('blog.content_field'),
                                'required' => false,
                            ],
                            'excerpt' => [
                                'type' => 'textarea',
                                'label' => __('blog.excerpt_field'),
                                'required' => false,
                                'maxLength' => 500,
                                'rows' => 3,
                            ],
                            'meta_title' => [
                                'type' => 'text',
                                'label' => __('blog.meta_title_field'),
                                'required' => false,
                                'maxLength' => 60,
                            ],
                            'meta_description' => [
                                'type' => 'textarea',
                                'label' => __('blog.meta_description_field'),
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
