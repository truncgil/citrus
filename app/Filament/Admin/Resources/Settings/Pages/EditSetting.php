<?php

namespace App\Filament\Admin\Resources\Settings\Pages;

use App\Filament\Admin\Resources\Settings\SettingResource;
use Filament\Actions\Action;
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

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();
        
        if (isset($data['type'])) {
            $type = $data['type'];
            $virtualField = 'value_' . $type;
            
            try {
                // Model accessor'ını kullanarak değeri al
                $data[$virtualField] = $record->{$virtualField};
            } catch (\Exception $e) {
                // Accessor bulunamazsa devam et
            }
        }
        
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('settings.save'))
                ->action('save')
                ->keyBindings(['mod+s'])
                ->color('primary')
                ->size('sm'),
            Action::make('cancel')
                ->label(__('settings.cancel'))
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->size('sm'),
            DeleteAction::make()
                ->label(__('settings.delete'))
                ->size('sm'),
            RestoreAction::make()
                ->label(__('settings.restore'))
                ->size('sm'),
            ForceDeleteAction::make()
                ->label(__('settings.force_delete'))
                ->size('sm'),
        ];
    }
    
    protected function getFormActions(): array
    {
        return []; // Boş array döndürerek alt taraftaki form action'larını gizliyoruz
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('settings.updated_successfully');
    }
}
