<?php

namespace App\Filament\Admin\Resources\SiteTranslations\Pages;

use App\Filament\Admin\Resources\SiteTranslations\SiteTranslationResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSiteTranslation extends EditRecord
{
    protected static string $resource = SiteTranslationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}

