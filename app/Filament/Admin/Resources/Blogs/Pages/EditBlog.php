<?php

namespace App\Filament\Admin\Resources\Blogs\Pages;

use App\Filament\Admin\Resources\Blogs\BlogResource;
use App\Filament\Admin\Resources\Components\TranslationTabs;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    public function getTitle(): string
    {
        return __('blog.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')
                ->label(__('blog.save'))
                ->action('save')
                ->keyBindings(['mod+s'])
                ->color('primary')
                ->size('sm'),
            Action::make('cancel')
                ->label(__('blog.cancel'))
                ->url($this->getResource()::getUrl('index'))
                ->color('gray')
                ->size('sm'),
            DeleteAction::make()
                ->label(__('blog.delete'))
                ->size('sm'),
            RestoreAction::make()
                ->label(__('blog.restore'))
                ->size('sm'),
            ForceDeleteAction::make()
                ->label(__('blog.force_delete'))
                ->size('sm'),
        ];
    }
    
    protected function getFormActions(): array
    {
        return []; // Boş array döndürerek alt taraftaki form action'larını gizliyoruz
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('blog.updated_successfully');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing translations
        $translationData = TranslationTabs::fillFromRecord($this->record);
        
        \Log::info('Loading translations for edit', [
            'blog_id' => $this->record->id,
            'translations' => $translationData
        ]);
        
        return array_merge($data, $translationData);
    }

    protected function afterSave(): void
    {
        \Log::info('Saving blog translations', [
            'blog_id' => $this->record->id,
            'form_state' => $this->form->getState()
        ]);
        
        // Save translations
        TranslationTabs::saveTranslations($this->record, $this->form->getState());
    }
}
