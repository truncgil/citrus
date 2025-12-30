<?php

namespace App\Filament\Admin\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Section;
use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Models\ProductCategory;

class ProductForm
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
                        Select::make('type')
                            ->options([
                                'product' => 'Product',
                                'service' => 'Service',
                            ])
                            ->required(),
                        Select::make('product_category_id')
                            ->label('Category')
                            ->options(function () {
                                return ProductCategory::all()->mapWithKeys(function ($category) {
                                    $title = is_array($category->title) 
                                        ? ($category->title[app()->getLocale()] ?? \Illuminate\Support\Arr::first($category->title)) 
                                        : $category->title;
                                    return [$category->id => $title ?? ('Category #' . $category->id)];
                                });
                            })
                            ->searchable(),
                        FileUpload::make('hero_image')
                            ->image()
                            ->directory('products'),
                        TextInput::make('view_template')
                            ->label('Custom View Path')
                            ->placeholder('e.g. front.products.custom-page')
                            ->helperText('Leave empty to use the default landing page.'),
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
                            'content' => [
                                'type' => 'richtext',
                                'label' => 'Content',
                            ],
                        ]),
                    ]),
            ]);
    }
}
