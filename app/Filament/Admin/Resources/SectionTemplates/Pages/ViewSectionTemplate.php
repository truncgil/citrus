<?php

namespace App\Filament\Admin\Resources\SectionTemplates\Pages;

use App\Filament\Admin\Resources\SectionTemplates\SectionTemplateResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSectionTemplate extends ViewRecord
{
    protected static string $resource = SectionTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
