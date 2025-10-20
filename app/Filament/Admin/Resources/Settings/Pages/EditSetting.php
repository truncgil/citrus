<?php

namespace App\Filament\Admin\Resources\Settings\Pages;

use App\Filament\Admin\Resources\Settings\SettingResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSetting extends EditRecord
{
    protected static string $resource = SettingResource::class;

    public function getTitle(): string
    {
        return __('settings.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('settings.delete')),
            RestoreAction::make()
                ->label(__('settings.restore')),
            ForceDeleteAction::make()
                ->label(__('settings.force_delete')),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('settings.updated_successfully');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Boolean tipindeki değerleri cast et
        if (isset($data['type']) && $data['type'] === 'boolean') {
            $data['value'] = filter_var($data['value'], FILTER_VALIDATE_BOOLEAN);
        }
        
        // Integer tipindeki değerleri cast et
        if (isset($data['type']) && $data['type'] === 'integer') {
            $data['value'] = (int) $data['value'];
        }
        
        // Float tipindeki değerleri cast et
        if (isset($data['type']) && $data['type'] === 'float') {
            $data['value'] = (float) $data['value'];
        }

        return $data;
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
