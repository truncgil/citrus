<?php

namespace App\Filament\Admin\Resources\SiteTranslations\Pages;

use App\Filament\Admin\Resources\SiteTranslations\SiteTranslationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSiteTranslations extends ListRecords
{
    protected static string $resource = SiteTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}



