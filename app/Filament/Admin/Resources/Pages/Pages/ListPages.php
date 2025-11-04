<?php

namespace App\Filament\Admin\Resources\Pages\Pages;

use App\Filament\Admin\Resources\Pages\PageResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPages extends ListRecords
{
    protected static string $resource = PageResource::class;

    public function getTitle(): string
    {
        return __('pages.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('menu')
                ->label(__('pages.menu_tree_title'))
                ->icon('heroicon-o-bars-3')
                ->url(PageResource::getUrl('menu'))
                ->color('gray'),
            CreateAction::make()
                ->label(__('pages.create')),
        ];
    }
}
