<?php

namespace App\Filament\Admin\Resources\SiteTranslations;

use App\Filament\Admin\Resources\SiteTranslations\Pages;
use App\Filament\Admin\Resources\SiteTranslations\Schemas\SiteTranslationForm;
use App\Filament\Admin\Resources\SiteTranslations\Tables\SiteTranslationsTable;
use App\Models\SiteTranslation;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

use UnitEnum;
use BackedEnum;

class SiteTranslationResource extends Resource
{
    protected static ?string $model = SiteTranslation::class;

    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-language';

    protected static UnitEnum|string|null $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 100;

    public static function form(Schema $schema): Schema
    {
        return SiteTranslationForm::make($schema);
    }

    public static function table(Table $table): Table
    {
        return SiteTranslationsTable::make($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteTranslations::route('/'),
            'create' => Pages\CreateSiteTranslation::route('/create'),
            'edit' => Pages\EditSiteTranslation::route('/{record}/edit'),
        ];
    }

    public static function getNavigationLabel(): string
    {
        return __('Site Translations');
    }

    public static function getModelLabel(): string
    {
        return __('Translation');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Translations');
    }
}

