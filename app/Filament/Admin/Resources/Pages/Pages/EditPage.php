<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Filament\Admin\Resources\Pages\PageResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\View\View;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;
    
    // Sticky header aktif
    protected static bool $hasTopbar = true;
    
    public bool $autoSaveEnabled = false;
    public ?string $lastAutoSaveTime = null;

    public function mount($record): void
    {
        parent::mount($record);
        
        // Eager load translations to avoid N+1 queries
        $this->record->load('translations');
    }

    public function getTitle(): string
    {
        return __('pages.edit');
    }
    
    public function autoSave(): void
    {
        try {
            $this->save();
            $this->lastAutoSaveTime = now()->format('H:i:s');
            
            // Sessiz başarı bildirimi
            \Filament\Notifications\Notification::make()
                ->title('Otomatik Kaydedildi')
                ->body('Son kayıt: ' . $this->lastAutoSaveTime)
                ->success()
                ->duration(2000)
                ->send();
        } catch (\Exception $e) {
            // Hata olursa sessizce geç, kullanıcıyı rahatsız etme
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            
            Action::make('save')
                ->label(__('pages.save'))
                ->action('save')
                ->keyBindings(['mod+s'])
                ->color('primary')
                ->size('sm'),
            Action::make('cancel')
                ->label(__('pages.cancel'))
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->size('sm'),
            DeleteAction::make()
                ->label(__('pages.delete'))
                ->size('sm'),
            ForceDeleteAction::make()
                ->label(__('pages.force_delete'))
                ->size('sm'),
            RestoreAction::make()
                ->label(__('pages.restore'))
                ->size('sm'),
        ];
    }
    
    protected function getFormActions(): array
    {
        return []; // Boş array döndürerek alt taraftaki form action'larını gizliyoruz
    }

    protected function getRedirectUrl(): ?string
    {
        return null; // Aynı sayfada kal
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('pages.updated_successfully');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing translations with eager loading
        $translationData = TranslationTabs::fillFromRecord($this->record);
        
        // DISABLED: Old format conversion causes memory exhaustion with nested arrays
        // Leave sections as-is; they work fine in their original format
        // If needed, conversion can be done manually or in a separate migration
        
        return array_merge($data, $translationData);
    }

    protected function afterSave(): void
    {
        // Save translations
        TranslationTabs::saveTranslations($this->record, $this->form->getState());
    }
    
    public function getFooter(): ?View
    {
        return view('filament.pages.edit-page-footer', [
            'autoSaveEnabled' => $this->autoSaveEnabled,
        ]);
    }
}
