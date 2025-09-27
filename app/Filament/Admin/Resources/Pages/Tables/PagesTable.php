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
                ImageColumn::make('featured_image_url')
                    ->label('Görsel')
                    ->circular()
                    ->size(40)
                    ->defaultImageUrl('/images/placeholder-page.png'),
                
                TextColumn::make('title')
                    ->label('Başlık')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->excerpt ? \Str::limit($record->excerpt, 50) : null),
                
                TextColumn::make('slug')
                    ->label('URL')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('URL kopyalandı')
                    ->url(fn ($record) => $record->url, shouldOpenInNewTab: true)
                    ->color('primary'),
                
                TextColumn::make('status')
                    ->label('Durum')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'published' => 'success',
                        'draft' => 'warning',
                        'archived' => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'published' => 'Yayında',
                        'draft' => 'Taslak',
                        'archived' => 'Arşivlendi',
                    }),
                
                TextColumn::make('author.name')
                    ->label('Yazar')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('published_at')
                    ->label('Yayın Tarihi')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(),
                
                TextColumn::make('parent.title')
                    ->label('Üst Sayfa')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('template')
                    ->label('Şablon')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                ToggleColumn::make('is_homepage')
                    ->label('Ana Sayfa')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                ToggleColumn::make('show_in_menu')
                    ->label('Menüde Göster')
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('sort_order')
                    ->label('Sıra')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('created_at')
                    ->label('Oluşturulma')
                    ->dateTime('d.m.Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Durum')
                    ->options([
                        'published' => 'Yayında',
                        'draft' => 'Taslak',
                        'archived' => 'Arşivlendi',
                    ]),
                
                SelectFilter::make('template')
                    ->label('Şablon')
                    ->options([
                        'default' => 'Varsayılan',
                        'landing' => 'Landing Page',
                        'blog' => 'Blog',
                        'contact' => 'İletişim',
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
