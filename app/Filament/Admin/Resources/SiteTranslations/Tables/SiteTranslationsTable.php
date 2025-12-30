<?php

namespace App\Filament\Admin\Resources\SiteTranslations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SiteTranslationsTable
{
    public static function make(Table $table): Table
    {
        $defaultLocale = app()->getLocale();

        return $table
            ->columns([
                TextColumn::make('key')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->wrap(),

                TextColumn::make("translations.{$defaultLocale}")
                    ->label("Translation ({$defaultLocale})")
                    ->searchable()
                    ->limit(50)
                    ->wrap()
                    ->placeholder('No translation'),
                
                TextColumn::make('created_at')
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

