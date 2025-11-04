<?php

namespace App\Filament\Admin\Resources\MenuTemplates\Pages;

use App\Filament\Admin\Resources\MenuTemplates\MenuTemplateResource;
use Filament\Resources\Pages\CreateRecord;

use Filament\Support\Enums\Width;

class CreateMenuTemplate extends CreateRecord
{
    protected static string $resource = MenuTemplateResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }
}
