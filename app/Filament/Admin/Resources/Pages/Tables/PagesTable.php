<?php

namespace App\Filament\Admin\Resources\Pages\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Notifications\Notification;
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
                    BulkAction::make('duplicate')
                        ->label(__('pages.bulk_action_duplicate'))
                        ->icon('heroicon-o-document-duplicate')
                        ->color('info')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                $record->duplicate();
                                $count++;
                            }
                            
                            Notification::make()
                                ->title(__('pages.bulk_duplicated_successfully', ['count' => $count]))
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    
                    BulkAction::make('publish')
                        ->label(__('pages.bulk_action_publish'))
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->publish()) {
                                    $count++;
                                }
                            }
                            
                            Notification::make()
                                ->title(__('pages.bulk_published_successfully', ['count' => $count]))
                                ->success()
                                ->send();
                        })
                        ->requiresConfirmation()
                        ->deselectRecordsAfterCompletion(),
                    
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
