<?php

namespace App\Filament\Admin\Resources\Settings\Pages;

use App\Filament\Admin\Resources\Settings\SettingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    public function getTitle(): string
    {
        return __('settings.create');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('settings.created_successfully');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Boolean değerleri string'e çevir
        if (isset($data['type']) && $data['type'] === 'boolean') {
            $data['value'] = $data['value'] ? '1' : '0';
        }
        
        // Integer değerleri string'e çevir
        if (isset($data['type']) && $data['type'] === 'integer') {
            $data['value'] = (string) $data['value'];
        }
        
        // Float değerleri string'e çevir
        if (isset($data['type']) && $data['type'] === 'float') {
            $data['value'] = (string) $data['value'];
        }

        return $data;
    }
}
