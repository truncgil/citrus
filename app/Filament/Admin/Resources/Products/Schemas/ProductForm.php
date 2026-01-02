<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Filament\Admin\Resources\Products\Schemas\LandingPageSection;
use App\Models\ProductCategory;
use Illuminate\Support\Str;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('products.general_section'))
                    ->schema([
                        TextInput::make('title')
                            ->label(__('products.title'))
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $state) {
                                $set('slug', Str::slug($state));
                                $set('translations.' . app()->getLocale() . '.title', $state);
                            })
                            ->formatStateUsing(fn ($record) => $record?->translate('title'))
                            ->dehydrated(false),
                        TextInput::make('slug')
                            ->label(__('products.slug'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('type')
                            ->label(__('products.type'))
                            ->options([
                                'product' => __('products.product'),
                                'service' => __('products.service'),
                            ])
                            ->required(),
                        Select::make('product_category_id')
                            ->label(__('products.category'))
                            ->options(function () {
                                return ProductCategory::all()->mapWithKeys(function ($category) {
                                    return [$category->id => $category->translate('title') ?? ('Category #' . $category->id)];
                                });
                            })
                            ->searchable(),
                        FileUpload::make('hero_image')
                            ->label(__('products.hero_image'))
                            ->image()
                            ->disk('public')
                            ->directory('products'),
                        TextInput::make('view_template')
                            ->label(__('products.view_template'))
                            ->placeholder(__('products.view_template_placeholder'))
                            ->helperText(__('products.view_template_helper')),
                        TextInput::make('sort_order')
                            ->label(__('products.sort_order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('products.is_active'))
                            ->default(true),
                    ])->columns(2),

                Section::make(__('products.translations_section'))
                    ->schema([
                        TranslationTabs::make([
                            'title' => [
                                'type' => 'text',
                                'label' => __('products.title'),
                                'required' => true,
                            ],
                            'content' => [
                                'type' => 'richtext',
                                'label' => __('products.content'),
                            ],
                        ]),
                    ]),

                // Landing Page Section (only for products)
                LandingPageSection::make(),
            ]);
    }
}
