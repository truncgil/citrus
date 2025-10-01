<?php

namespace App\Filament\Admin\Resources\Languages\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LanguagesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('flag')
                    ->label(__('language.table_flag'))
                    ->sortable()
                    ->searchable()
                    ->formatStateUsing(fn (?string $state): string => 
                        '<span style="font-size: 2rem; line-height: 1;">' . ($state ?? '🌐') . '</span>'
                    )
                    ->html()
                    ->alignCenter(),

                TextColumn::make('code')
                    ->label(__('language.table_code'))
                    ->sortable()
                    ->searchable()
                    ->badge()
                    ->color('info'),

                TextColumn::make('name')
                    ->label(__('language.table_name'))
                    ->sortable()
                    ->searchable()
                    ->description(fn ($record) => $record->native_name),

                IconColumn::make('is_active')
                    ->label(__('language.table_is_active'))
                    ->boolean()
                    ->sortable(),

                IconColumn::make('is_default')
                    ->label(__('language.table_is_default'))
                    ->boolean()
                    ->sortable(),

                TextColumn::make('direction')
                    ->label(__('language.table_direction'))
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'ltr' => 'success',
                        'rtl' => 'warning',
                    })
                    ->sortable(),

                TextColumn::make('sort_order')
                    ->label(__('language.table_sort_order'))
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('language.table_created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label(__('language.table_updated_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('deleted_at')
                    ->label(__('language.table_deleted_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
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
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}

