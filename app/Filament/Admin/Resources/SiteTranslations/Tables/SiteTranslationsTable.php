<?php

namespace App\Filament\Admin\Resources\SiteTranslations\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Models\Language;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Actions\ImportAction;
use Filament\Actions\ExportAction;
use App\Filament\Imports\SiteTranslationImporter;
use App\Filament\Exports\SiteTranslationExporter;

class SiteTranslationsTable
{
    public static function make(Table $table): Table
    {
        $defaultLocale = app()->getLocale();

        return $table
            ->headerActions([
                ImportAction::make()
                    ->importer(SiteTranslationImporter::class),
                ExportAction::make()
                    ->exporter(SiteTranslationExporter::class)
            ])
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
                EditAction::make()
                    ->modalWidth('xl')
                    ->form(function () {
                        $languages = Language::where('is_active', true)->get();
                        
                        $translationFields = [];
                        foreach ($languages as $language) {
                            $translationFields[] = Textarea::make($language->code)
                                ->label($language->name . " ({$language->code})")
                                ->rows(2);
                        }

                        return [
                             Section::make()
                                ->schema([
                                    Textarea::make('key')
                                        ->label('Key / Original Text')
                                        ->required()
                                        ->columnSpanFull()
                                        ->helperText('The original text to be translated. Use this exact text in t() helper.'),

                                    Group::make()
                                        ->schema($translationFields)
                                        ->statePath('translations')
                                        ->columnSpanFull(),
                                ])
                        ];
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

