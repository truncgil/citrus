<?php

namespace App\Filament\Admin\Resources\FooterTemplates\Pages;

use App\Filament\Admin\Resources\FooterTemplates\FooterTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewFooterTemplate extends ViewRecord
{
    protected static string $resource = FooterTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
