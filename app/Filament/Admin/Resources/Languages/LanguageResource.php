<?php

namespace App\Filament\Admin\Resources\Languages;

use App\Filament\Admin\Resources\Languages\Pages\CreateLanguage;
use App\Filament\Admin\Resources\Languages\Pages\EditLanguage;
use App\Filament\Admin\Resources\Languages\Pages\ListLanguages;
use App\Models\Language;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static UnitEnum|string|null $navigationGroup = 'System';

    protected static ?int $navigationSort = 100;

    public static function getNavigationLabel(): string
    {
        return __('language.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('language.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('language.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema(\App\Filament\Admin\Resources\Languages\Schemas\LanguageForm::schema());
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Admin\Resources\Languages\Tables\LanguagesTable::configure($table);
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
            'index' => ListLanguages::route('/'),
            'create' => CreateLanguage::route('/create'),
            'edit' => EditLanguage::route('/{record}/edit'),
        ];
    }
}

