<?php

namespace App\Filament\Admin\Resources\ProductCategories\Pages;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Filament\Admin\Resources\ProductCategories\ProductCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductCategory extends EditRecord
{
    protected static string $resource = ProductCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        return array_merge($data, TranslationTabs::fillFromRecord($this->record));
    }

    protected function afterSave(): void
    {
        $data = $this->form->getState();
        TranslationTabs::saveTranslations($this->record, $data);
    }
}
