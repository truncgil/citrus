<?php

namespace App\Filament\Admin\Resources\FooterTemplates;

use App\Filament\Admin\Resources\FooterTemplates\Pages\CreateFooterTemplate;
use App\Filament\Admin\Resources\FooterTemplates\Pages\EditFooterTemplate;
use App\Filament\Admin\Resources\FooterTemplates\Pages\ListFooterTemplates;
use App\Filament\Admin\Resources\FooterTemplates\Pages\ViewFooterTemplate;
use App\Filament\Admin\Resources\FooterTemplates\Schemas\FooterTemplateForm;
use App\Filament\Admin\Resources\FooterTemplates\Schemas\FooterTemplateInfolist;
use App\Filament\Admin\Resources\FooterTemplates\Tables\FooterTemplatesTable;
use App\Models\FooterTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FooterTemplateResource extends Resource
{
    protected static ?string $model = FooterTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): string
    {
        return __('footer-templates.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('footer-templates.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('footer-templates.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('footer-templates.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return FooterTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return FooterTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FooterTemplatesTable::configure($table);
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
            'index' => ListFooterTemplates::route('/'),
            'create' => CreateFooterTemplate::route('/create'),
            'view' => ViewFooterTemplate::route('/{record}'),
            'edit' => EditFooterTemplate::route('/{record}/edit'),
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
