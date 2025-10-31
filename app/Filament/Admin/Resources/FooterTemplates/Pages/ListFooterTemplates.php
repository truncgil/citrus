<?php

namespace App\Filament\Admin\Resources\FooterTemplates\Pages;

use App\Filament\Admin\Resources\FooterTemplates\FooterTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListFooterTemplates extends ListRecords
{
    protected static string $resource = FooterTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
