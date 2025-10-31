<?php

namespace App\Filament\Admin\Resources\HeaderTemplates;

use App\Filament\Admin\Resources\HeaderTemplates\Pages\CreateHeaderTemplate;
use App\Filament\Admin\Resources\HeaderTemplates\Pages\EditHeaderTemplate;
use App\Filament\Admin\Resources\HeaderTemplates\Pages\ListHeaderTemplates;
use App\Filament\Admin\Resources\HeaderTemplates\Pages\ViewHeaderTemplate;
use App\Filament\Admin\Resources\HeaderTemplates\Schemas\HeaderTemplateForm;
use App\Filament\Admin\Resources\HeaderTemplates\Schemas\HeaderTemplateInfolist;
use App\Filament\Admin\Resources\HeaderTemplates\Tables\HeaderTemplatesTable;
use App\Models\HeaderTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeaderTemplateResource extends Resource
{
    protected static ?string $model = HeaderTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): string
    {
        return __('header-templates.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('header-templates.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('header-templates.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('header-templates.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return HeaderTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HeaderTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HeaderTemplatesTable::configure($table);
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
            'index' => ListHeaderTemplates::route('/'),
            'create' => CreateHeaderTemplate::route('/create'),
            'view' => ViewHeaderTemplate::route('/{record}'),
            'edit' => EditHeaderTemplate::route('/{record}/edit'),
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
