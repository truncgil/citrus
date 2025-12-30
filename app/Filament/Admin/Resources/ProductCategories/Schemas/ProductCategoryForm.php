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
                Section::make('General')
                    ->schema([
                        TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true),
                        Select::make('parent_id')
                            ->label('Parent Category')
                            ->options(function () {
                                return ProductCategory::all()->mapWithKeys(function ($category) {
                                    $title = is_array($category->title) 
                                        ? ($category->title[app()->getLocale()] ?? first($category->title)) 
                                        : $category->title;
                                    return [$category->id => $title];
                                });
                            })
                            ->searchable(),
                        TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),

                Section::make('Translations')
                    ->schema([
                        TranslationTabs::make([
                            'title' => [
                                'type' => 'text',
                                'label' => 'Title',
                                'required' => true,
                            ],
                        ]),
                    ]),
            ]);
    }
}
