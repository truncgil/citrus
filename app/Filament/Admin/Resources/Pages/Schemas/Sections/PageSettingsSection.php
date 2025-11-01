<?php

namespace App\Filament\Admin\Resources\Pages\Schemas\Sections;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PageSettingsSection
{
    public static function make(): Section
    {
        return Section::make(__('pages.form_section_page_settings'))
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
            ->collapsible(false);
    }
}

