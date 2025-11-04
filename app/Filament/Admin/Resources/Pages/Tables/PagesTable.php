<?php

namespace App\Filament\Admin\Resources\Pages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('featured_image')
                    ->label(__('pages.table_column_featured_image'))
                    ->formatStateUsing(function ($state, $record) {
                        // Eğer featured_image varsa image göster
                        if ($record->featured_image_url) {
                            return '<img src="' . e($record->featured_image_url) . '" alt="" class="w-10 h-10 rounded-full object-cover" />';
                        }
                        
                        // Yoksa Heroicon page icon'unu göster (dark mode'da beyaz, light mode'da siyah)
                        $svgIcon = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-10 w-10"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>';
                        
                        return '<div class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-800 text-gray-950 dark:text-white">' . $svgIcon . '</div>';
                    })
                    ->html()
                    ->alignCenter(),
                
                TextColumn::make('title')
                    ->label(__('pages.table_column_title'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->excerpt ? \Str::limit($record->excerpt, 50) : null),
                
                TextColumn::make('slug')
                    ->label(__('pages.table_column_slug'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage(__('pages.copy_url_message'))
                    ->url(fn ($record) => $record->url, shouldOpenInNewTab: true)
                    ->color('primary'),
                
                TextColumn::make('status')
                    ->label(__('pages.table_column_status'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => __('pages.status_published'),
                        'draft' => __('pages.status_draft'),
                        'archived' => __('pages.status_archived'),
                    }),
                
                TextColumn::make('author.name')
                    ->label(__('pages.table_column_author'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('published_at')
                    ->label(__('pages.table_column_published_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('parent.title')
                    ->label(__('pages.table_column_parent'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('template')
                    ->label(__('pages.table_column_template'))
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                ToggleColumn::make('is_homepage')
                    ->label(__('pages.table_column_is_homepage'))
                    ->toggleable(isToggledHiddenByDefault: true),
                
                ToggleColumn::make('show_in_menu')
                    ->label(__('pages.table_column_show_in_menu'))
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('sort_order')
                    ->label(__('pages.table_column_sort_order'))
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label(__('pages.table_column_created_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('pages.table_column_status'))
                    ->options([
                        'published' => __('pages.status_published'),
                        'draft' => __('pages.status_draft'),
                        'archived' => __('pages.status_archived'),
                    ]),
                
                SelectFilter::make('template')
                    ->label(__('pages.table_column_template'))
                    ->options([
                        'default' => __('pages.template_default'),
                        'landing' => __('pages.template_landing'),
                        'blog' => __('pages.template_blog'),
                        'contact' => __('pages.template_contact'),
                    ]),
                
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
