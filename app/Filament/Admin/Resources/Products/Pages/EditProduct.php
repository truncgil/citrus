<?php

namespace App\Filament\Admin\Resources\Products\Pages;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Filament\Admin\Resources\Products\ProductResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

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
