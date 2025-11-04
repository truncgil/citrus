<?php

namespace App\Filament\Admin\Resources\Languages\Pages;

use App\Filament\Admin\Resources\Languages\LanguageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditLanguage extends EditRecord
{
    protected static string $resource = LanguageResource::class;

    public function getTitle(): string
    {
        return __('language.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('language.save'))
                ->action('save')
                ->keyBindings(['mod+s'])
                ->color('primary')
                ->size('sm'),
            Action::make('cancel')
                ->label(__('language.cancel'))
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->size('sm'),
            DeleteAction::make()
                ->label(__('language.delete'))
                ->size('sm'),
            RestoreAction::make()
                ->label(__('language.restore'))
                ->size('sm'),
            ForceDeleteAction::make()
                ->label(__('language.force_delete'))
                ->size('sm'),
        ];
    }
    
    protected function getFormActions(): array
    {
        return []; // Boş array döndürerek alt taraftaki form action'larını gizliyoruz
    }

    protected function getSavedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title(__('language.updated_successfully'))
            ->body(__('language.updated_successfully_body'));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['updated_by'] = auth()->id();

        return $data;
    }
}

