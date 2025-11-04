<?php

namespace App\Filament\Admin\Resources\HeaderTemplates\Pages;

use App\Filament\Admin\Resources\HeaderTemplates\HeaderTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHeaderTemplates extends ListRecords
{
    protected static string $resource = HeaderTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
