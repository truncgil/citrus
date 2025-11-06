<?php

namespace App\Filament\Admin\Resources\BlogCategories\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BlogCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->schema([
                Section::make(__('blog_category.general_section'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('blog_category.name_field'))
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
                            ->label(__('blog_category.slug_field'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText(__('blog_category.slug_helper')),
                        
                        Textarea::make('description')
                            ->label(__('blog_category.description_field'))
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText(__('blog_category.description_helper'))
                            ->columnSpanFull(),
                        
                        ColorPicker::make('color')
                            ->label(__('blog_category.color_field'))
                            ->default('#3B82F6')
                            ->helperText(__('blog_category.color_helper')),
                        
                        TextInput::make('sort_order')
                            ->label(__('blog_category.sort_order_field'))
                            ->numeric()
                            ->default(0)
                            ->helperText(__('blog_category.sort_order_helper')),
                        
                        Toggle::make('is_active')
                            ->label(__('blog_category.is_active_field'))
                            ->default(true)
                            ->helperText(__('blog_category.is_active_helper'))
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
                    ->collapsible(false),
            ]);
    }
}

