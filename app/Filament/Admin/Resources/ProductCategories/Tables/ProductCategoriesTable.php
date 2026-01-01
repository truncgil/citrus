<?php

namespace App\Filament\Admin\Resources\ProductCategories\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\BulkActionGroup;

class ProductCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('product_categories.title'))
                    ->getStateUsing(fn ($record) => $record->translate('title'))
                    ->searchable(query: function ($query, $search) {
                        return $query->whereHas('translations', function ($q) use ($search) {
                            $q->where('field_name', 'title')
                              ->where('field_value', 'like', "%{$search}%")
                              ->where('language_code', app()->getLocale());
                        });
                    }),
                TextColumn::make('slug')
                    ->label(__('product_categories.slug'))
                    ->searchable(),
                TextColumn::make('parent.title')
                    ->getStateUsing(fn ($record) => $record->parent?->translate('title'))
                    ->label(__('product_categories.parent')),
                TextColumn::make('sort_order')
                    ->label(__('product_categories.sort_order'))
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label(__('product_categories.is_active')),
                TextColumn::make('created_at')
                    ->label(__('product_categories.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
