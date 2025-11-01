<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Pages\PageResource;
use App\Filament\Admin\Widgets\PagesMenuWidget;
use Filament\Actions\Action;
use Filament\Resources\Pages\Page;

class MenuTree extends Page
{
    protected static string $resource = PageResource::class;

    protected string $view = 'filament.admin.pages.menu-tree';

    public function getTitle(): string
    {
        return __('pages.menu_tree_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label(__('pages.menu_refresh'))
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(function () {
                    $this->dispatch('$refresh');
                }),
            Action::make('back_to_pages')
                ->label(__('pages.menu_back_to_pages'))
                ->icon('heroicon-o-arrow-left')
                ->url(PageResource::getUrl('index'))
                ->color('gray'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            PagesMenuWidget::class,
        ];
    }
}

