<?php

namespace App\Filament\Admin\Resources\SectionTemplates\Pages;

use App\Filament\Admin\Resources\SectionTemplates\SectionTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSectionTemplates extends ListRecords
{
    protected static string $resource = SectionTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
