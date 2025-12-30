<?php

namespace App\Filament\Admin\Resources\ProductCategories\Pages;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Filament\Admin\Resources\ProductCategories\ProductCategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProductCategory extends CreateRecord
{
    protected static string $resource = ProductCategoryResource::class;

    protected function afterCreate(): void
    {
        $data = $this->form->getState();
        TranslationTabs::saveTranslations($this->record, $data);
    }
}
