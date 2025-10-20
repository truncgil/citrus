<?php

namespace App\Filament\Admin\Resources\Settings;

use App\Filament\Admin\Resources\Settings\Pages\CreateSetting;
use App\Filament\Admin\Resources\Settings\Pages\EditSetting;
use App\Filament\Admin\Resources\Settings\Pages\ListSettings;
use App\Filament\Admin\Resources\Settings\Schemas\SettingForm;
use App\Filament\Admin\Resources\Settings\Tables\SettingsTable;
use App\Models\Setting;
use BackedEnum;
use Filament\Resources\Resource;
use UnitEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Cog6Tooth;

    protected static UnitEnum|string|null $navigationGroup = 'Sistem';

    protected static ?int $navigationSort = 100;

    public static function getNavigationLabel(): string
    {
        return __('settings.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('settings.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('settings.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return SettingForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsTable::configure($table);
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
            'index' => ListSettings::route('/'),
            'create' => CreateSetting::route('/create'),
            'edit' => EditSetting::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
