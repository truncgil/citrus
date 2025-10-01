<?php

namespace App\Filament\Admin\Resources\Blogs\Pages;

use App\Filament\Admin\Resources\Blogs\BlogResource;
use App\Filament\Admin\Resources\Components\TranslationTabs;
use Filament\Resources\Pages\CreateRecord;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    public function getTitle(): string
    {
        return __('blog.create');
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return __('blog.created_successfully');
    }

    protected function afterCreate(): void
    {
        // Save translations
        TranslationTabs::saveTranslations($this->record, $this->form->getState());
    }
}
