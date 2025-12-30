<?php

namespace App\Filament\Admin\Resources\ProductCategories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Models\ProductCategory;

class ProductCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make(__('product_categories.general_section'))
                    ->schema([
                        TextInput::make('slug')
                            ->label(__('product_categories.slug'))
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('parent_id')
                            ->label(__('product_categories.parent_category'))
                            ->options(function () {
                                return ProductCategory::all()->mapWithKeys(function ($category) {
                                    $title = is_array($category->title) 
                                        ? ($category->title[app()->getLocale()] ?? \Illuminate\Support\Arr::first($category->title)) 
                                        : $category->title;
                                    return [$category->id => $title ?? ('Category #' . $category->id)];
                                });
                            })
                            ->searchable(),
                        TextInput::make('sort_order')
                            ->label(__('product_categories.sort_order'))
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->label(__('product_categories.is_active'))
                            ->default(true),
                    ])->columns(2),

                Section::make(__('product_categories.translations_section'))
                    ->schema([
                        TranslationTabs::make([
                            'title' => [
                                'type' => 'text',
                                'label' => __('product_categories.title'),
                                'required' => true,
                            ],
                        ]),
                    ]),
            ]);
    }
}
