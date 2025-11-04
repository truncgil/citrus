<?php

namespace App\Filament\Admin\Resources\MenuTemplates\Pages;

use App\Filament\Admin\Resources\MenuTemplates\MenuTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMenuTemplate extends ViewRecord
{
    protected static string $resource = MenuTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
