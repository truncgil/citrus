<?php

namespace App\Filament\Admin\Resources\MenuTemplates\Pages;

use App\Filament\Admin\Resources\MenuTemplates\MenuTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMenuTemplates extends ListRecords
{
    protected static string $resource = MenuTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
