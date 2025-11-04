<?php

namespace App\Filament\Admin\Resources\Customers\Pages;

use App\Filament\Admin\Resources\Customers\CustomerResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCustomer extends EditRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->action('save')
                ->keyBindings(['mod+s'])
                ->color('primary')
                ->size('sm'),
            Action::make('cancel')
                ->label('Cancel')
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->size('sm'),
            DeleteAction::make()
                ->size('sm'),
        ];
    }
    
    protected function getFormActions(): array
    {
        return []; // Boş array döndürerek alt taraftaki form action'larını gizliyoruz
    }
}
