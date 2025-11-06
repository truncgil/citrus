<?php

namespace App\Filament\Admin\Resources\BlogCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogCategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('color')
                    ->label(__('blog_category.color_field')),
                
                TextColumn::make('name')
                    ->label(__('blog_category.name_field'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                
                TextColumn::make('slug')
                    ->label(__('blog_category.slug_field'))
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->color('gray'),
                
                TextColumn::make('description')
                    ->label(__('blog_category.description_field'))
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),
                
                TextColumn::make('blogs_count')
                    ->label(__('blog_category.blogs_count'))
                    ->counts('blogs')
                    ->sortable()
                    ->alignCenter(),
                
                TextColumn::make('sort_order')
                    ->label(__('blog_category.sort_order_field'))
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(),
                
                ToggleColumn::make('is_active')
                    ->label(__('blog_category.is_active_field'))
                    ->alignCenter(),
                
                TextColumn::make('created_at')
                    ->label(__('blog_category.table_created_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label(__('blog_category.table_updated_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('blog_category.is_active_field')),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('blog_category.edit')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('blog_category.delete')),
                    RestoreBulkAction::make()
                        ->label(__('blog_category.restore')),
                    ForceDeleteBulkAction::make()
                        ->label(__('blog_category.force_delete')),
                ]),
            ])
            ->defaultSort('sort_order');
    }
}

