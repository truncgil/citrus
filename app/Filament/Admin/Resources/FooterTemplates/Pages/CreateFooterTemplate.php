<?php

namespace App\Filament\Admin\Resources\FooterTemplates\Pages;

use App\Filament\Admin\Resources\FooterTemplates\FooterTemplateResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateFooterTemplate extends CreateRecord
{
    protected static string $resource = FooterTemplateResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }
}
