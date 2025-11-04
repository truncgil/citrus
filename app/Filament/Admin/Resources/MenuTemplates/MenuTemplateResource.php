<?php

namespace App\Filament\Admin\Resources\MenuTemplates;

use App\Filament\Admin\Resources\MenuTemplates\Pages\CreateMenuTemplate;
use App\Filament\Admin\Resources\MenuTemplates\Pages\EditMenuTemplate;
use App\Filament\Admin\Resources\MenuTemplates\Pages\ListMenuTemplates;
use App\Filament\Admin\Resources\MenuTemplates\Pages\ViewMenuTemplate;
use App\Filament\Admin\Resources\MenuTemplates\Schemas\MenuTemplateForm;
use App\Filament\Admin\Resources\MenuTemplates\Schemas\MenuTemplateInfolist;
use App\Filament\Admin\Resources\MenuTemplates\Tables\MenuTemplatesTable;
use App\Models\MenuTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MenuTemplateResource extends Resource
{
    protected static ?string $model = MenuTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): string
    {
        return __('menu-templates.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('menu-templates.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('menu-templates.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('menu-templates.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return MenuTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return MenuTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MenuTemplatesTable::configure($table);
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
            'index' => ListMenuTemplates::route('/'),
            'create' => CreateMenuTemplate::route('/create'),
            'view' => ViewMenuTemplate::route('/{record}'),
            'edit' => EditMenuTemplate::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
