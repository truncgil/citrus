<?php

namespace App\Filament\Admin\Resources\SectionTemplates\Pages;

use App\Filament\Admin\Resources\SectionTemplates\SectionTemplateResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;

class EditSectionTemplate extends EditRecord
{
    protected static string $resource = SectionTemplateResource::class;

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Transform nested default_data fields (e.g., default_data.color.bg) 
        // into proper array format
        $defaultData = [];
        
        foreach ($data as $key => $value) {
            if (str_starts_with($key, 'default_data.')) {
                // Remove 'default_data.' prefix to get the nested key
                $nestedKey = substr($key, 13); // 'default_data.' length is 13
                $defaultData[$nestedKey] = $value;
                // Remove the flattened key from data
                unset($data[$key]);
            }
        }
        
        // Set the properly formatted default_data array
        if (!empty($defaultData)) {
            $data['default_data'] = $defaultData;
        }
        
        return $data;
    }

    protected function afterSave(): void
    {
        // Kaydetme sonrası preview'ı güncelle
        // Livewire event dispatch et
        $this->dispatch('template-saved');
    }
}
