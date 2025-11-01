<?php

namespace App\Filament\Admin\Resources\HeaderTemplates\Pages;

use App\Filament\Admin\Resources\HeaderTemplates\HeaderTemplateResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateHeaderTemplate extends CreateRecord
{
    protected static string $resource = HeaderTemplateResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }
}
