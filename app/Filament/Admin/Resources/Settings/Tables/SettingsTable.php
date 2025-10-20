<?php

namespace App\Filament\Admin\Resources\Settings\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SettingsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label(__('settings.table_key'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('label')
                    ->label(__('settings.table_label'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('value')
                    ->label(__('settings.table_value'))
                    ->searchable()
                    ->limit(50)
                    ->wrap()
                    ->formatStateUsing(function ($state, $record) {
                        // Boolean tipler için emoji göster
                        if ($record->type === 'boolean') {
                            return filter_var($state, FILTER_VALIDATE_BOOLEAN) 
                                ? '✅' 
                                : '❌';
                        }
                        return $state;
                    }),

                TextColumn::make('type')
                    ->label(__('settings.table_type'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'boolean' => 'success',
                        'integer', 'float' => 'info',
                        'array', 'json' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => __("settings.type_{$state}")),

                TextColumn::make('group')
                    ->label(__('settings.table_group'))
                    ->badge()
                    ->color('primary')
                    ->formatStateUsing(fn (string $state): string => __("settings.group_{$state}")),

                IconColumn::make('is_active')
                    ->label(__('settings.table_active'))
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_public')
                    ->label(__('settings.table_public'))
                    ->boolean()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('settings.table_created_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('settings.table_updated_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('group')
                    ->label(__('settings.filter_group'))
                    ->options([
                        'general' => __('settings.group_general'),
                        'email' => __('settings.group_email'),
                        'seo' => __('settings.group_seo'),
                        'social' => __('settings.group_social'),
                        'security' => __('settings.group_security'),
                        'payment' => __('settings.group_payment'),
                        'notification' => __('settings.group_notification'),
                        'other' => __('settings.group_other'),
                    ]),

                SelectFilter::make('type')
                    ->label(__('settings.filter_type'))
                    ->options([
                        'string' => __('settings.type_string'),
                        'text' => __('settings.type_text'),
                        'boolean' => __('settings.type_boolean'),
                        'integer' => __('settings.type_integer'),
                        'float' => __('settings.type_float'),
                        'array' => __('settings.type_array'),
                        'json' => __('settings.type_json'),
                    ]),

                TernaryFilter::make('is_active')
                    ->label(__('settings.filter_active'))
                    ->boolean()
                    ->trueLabel(__('settings.is_active'))
                    ->falseLabel(__('settings.is_active') . ' (Hayır)'),

                TernaryFilter::make('is_public')
                    ->label(__('settings.filter_public'))
                    ->boolean()
                    ->trueLabel(__('settings.is_public'))
                    ->falseLabel(__('settings.is_public') . ' (Hayır)'),

                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
