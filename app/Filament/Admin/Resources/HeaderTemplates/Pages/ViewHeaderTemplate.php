<?php

namespace App\Filament\Admin\Resources\HeaderTemplates\Pages;

use App\Filament\Admin\Resources\HeaderTemplates\HeaderTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHeaderTemplate extends ViewRecord
{
    protected static string $resource = HeaderTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
