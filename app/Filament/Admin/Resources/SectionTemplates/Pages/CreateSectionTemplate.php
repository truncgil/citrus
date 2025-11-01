<?php

namespace App\Filament\Admin\Resources\SectionTemplates\Pages;

use App\Filament\Admin\Resources\SectionTemplates\SectionTemplateResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreateSectionTemplate extends CreateRecord
{
    protected static string $resource = SectionTemplateResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }
}
