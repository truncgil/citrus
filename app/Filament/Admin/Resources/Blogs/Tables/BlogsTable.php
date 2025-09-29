<?php

namespace App\Filament\Admin\Resources\Blogs\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BlogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('featured_image')
                    ->label(__('blog.featured_image_field'))
                    ->disk('public')
                    ->square()
                    ->size(60),
                
                TextColumn::make('title')
                    ->label(__('blog.table_title'))
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                TextColumn::make('slug')
                    ->label(__('blog.table_slug'))
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                
                TextColumn::make('status')
                    ->label(__('blog.table_status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                        'archived' => 'warning',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'draft' => __('blog.status_draft'),
                        'published' => __('blog.status_published'),
                        'archived' => __('blog.status_archived'),
                    }),
                
                TextColumn::make('author.name')
                    ->label(__('blog.table_author'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('category.name')
                    ->label(__('blog.table_category'))
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('published_at')
                    ->label(__('blog.table_published_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
                
                TextColumn::make('view_count')
                    ->label(__('blog.table_view_count'))
                    ->sortable()
                    ->alignCenter(),
                
                ToggleColumn::make('is_featured')
                    ->label(__('blog.is_featured_field'))
                    ->alignCenter(),
                
                TextColumn::make('created_at')
                    ->label(__('blog.table_created_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->label(__('blog.table_updated_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('blog.status_field'))
                    ->options([
                        'draft' => __('blog.status_draft'),
                        'published' => __('blog.status_published'),
                        'archived' => __('blog.status_archived'),
                    ]),
                
                SelectFilter::make('category_id')
                    ->label(__('blog.category_field'))
                    ->relationship('category', 'name'),
                
                TernaryFilter::make('is_featured')
                    ->label(__('blog.is_featured_field')),
                
                TernaryFilter::make('allow_comments')
                    ->label(__('blog.allow_comments_field')),
            ])
            ->recordActions([
                EditAction::make()
                    ->label(__('blog.edit')),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label(__('blog.delete')),
                    RestoreBulkAction::make()
                        ->label(__('blog.restore')),
                    ForceDeleteBulkAction::make()
                        ->label(__('blog.force_delete')),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
