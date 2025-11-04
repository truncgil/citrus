<?php

namespace App\Filament\Admin\Resources\SectionTemplates;

use App\Filament\Admin\Resources\SectionTemplates\Pages\CreateSectionTemplate;
use App\Filament\Admin\Resources\SectionTemplates\Pages\EditSectionTemplate;
use App\Filament\Admin\Resources\SectionTemplates\Pages\ListSectionTemplates;
use App\Filament\Admin\Resources\SectionTemplates\Pages\ViewSectionTemplate;
use App\Filament\Admin\Resources\SectionTemplates\Schemas\SectionTemplateForm;
use App\Filament\Admin\Resources\SectionTemplates\Schemas\SectionTemplateInfolist;
use App\Filament\Admin\Resources\SectionTemplates\Tables\SectionTemplatesTable;
use App\Models\SectionTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SectionTemplateResource extends Resource
{
    protected static ?string $model = SectionTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getNavigationGroup(): string
    {
        return __('section-templates.navigation_group');
    }

    public static function getNavigationLabel(): string
    {
        return __('section-templates.navigation_label');
    }

    public static function getModelLabel(): string
    {
        return __('section-templates.model_label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('section-templates.plural_model_label');
    }

    public static function form(Schema $schema): Schema
    {
        return SectionTemplateForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SectionTemplateInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SectionTemplatesTable::configure($table);
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
            'index' => ListSectionTemplates::route('/'),
            'create' => CreateSectionTemplate::route('/create'),
            'view' => ViewSectionTemplate::route('/{record}'),
            'edit' => EditSectionTemplate::route('/{record}/edit'),
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
