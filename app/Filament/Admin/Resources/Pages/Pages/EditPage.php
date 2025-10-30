<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Components\TranslationTabs;
use App\Filament\Admin\Resources\Pages\PageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPage extends EditRecord
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages.edit');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label(__('pages.delete')),
            ForceDeleteAction::make()
                ->label(__('pages.force_delete')),
            RestoreAction::make()
                ->label(__('pages.restore')),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return __('pages.updated_successfully');
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Load existing translations
        $translationData = TranslationTabs::fillFromRecord($this->record);
        
        // Convert old format sections to new format
        if (isset($data['sections']) && is_array($data['sections'])) {
            $data['sections'] = array_map(function ($section) {
                if (!isset($section['data']) || !is_array($section['data'])) {
                    return $section;
                }
                
                // Check if already in new format
                $firstKey = array_key_first($section['data']);
                if (is_numeric($firstKey) && isset($section['data'][$firstKey]['key'])) {
                    return $section;
                }
                
                // Convert old format to new format
                $newData = [];
                foreach ($section['data'] as $key => $value) {
                    $type = 'text'; // Default
                    
                    // Auto-detect type based on key name and value
                    if (str_contains($key, 'image') || str_contains($key, 'photo')) {
                        $type = 'image';
                    } elseif (str_contains($key, 'icon') && is_string($value) && str_starts_with($value, 'assets/')) {
                        $type = 'image';
                    } elseif (str_contains($key, 'color')) {
                        $type = 'color';
                    } elseif (str_contains($key, 'url') || str_contains($key, 'link')) {
                        $type = 'url';
                    } elseif (is_string($value) && (str_contains($key, 'subtitle') || str_contains($key, 'description'))) {
                        $type = 'textarea';
                    } elseif (is_string($value) && str_contains($value, '<') && str_contains($value, '>') && strlen($value) > 200) {
                        $type = 'html'; // Long HTML content
                    } elseif (is_string($value) && strlen($value) > 100) {
                        $type = 'textarea';
                    } elseif (is_array($value)) {
                        $type = 'array';
                    } elseif (is_bool($value)) {
                        $type = 'boolean';
                    }
                    // 'title' gibi kısa HTML snippet'leri 'text' olarak kalır
                    
                    $newData[] = [
                        'key' => $key,
                        'type' => $type,
                        'value' => $value,
                    ];
                }
                
                $section['data'] = $newData;
                return $section;
            }, $data['sections']);
        }
        
        return array_merge($data, $translationData);
    }

    protected function afterSave(): void
    {
        // Save translations
        TranslationTabs::saveTranslations($this->record, $this->form->getState());
    }
}
