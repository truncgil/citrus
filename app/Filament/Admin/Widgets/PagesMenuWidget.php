<?php

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Resources\Pages\PageResource;
use App\Models\Page;
use Illuminate\Database\Eloquent\Builder;
use SolutionForest\FilamentTree\Actions\EditAction;
use SolutionForest\FilamentTree\Actions\ViewAction;
use SolutionForest\FilamentTree\Widgets\Tree as BaseWidget;

class PagesMenuWidget extends BaseWidget
{
    protected static string $model = Page::class;

    protected static int $maxDepth = 4;

    protected bool $enableTreeTitle = true;

    public function getTreeTitle(): string
    {
        return __('pages.menu_tree_title');
    }

    protected function getTreeQuery(): Builder
    {
        return Page::query()
            ->where('status', 'published')
            ->where('show_in_menu', true)
            ->orderBy('sort_order');
    }

    public function getTreeRecordTitle(?\Illuminate\Database\Eloquent\Model $record = null): string
    {
        if (!$record) {
            return '';
        }

        $title = $record->title;
        
        // Add child count indicator
        $childCount = $record->children()
            ->where('status', 'published')
            ->where('show_in_menu', true)
            ->count();
            
        if ($childCount > 0) {
            $title .= " ({$childCount})";
        }

        return $title;
    }

    public function getTreeRecordIcon(?\Illuminate\Database\Eloquent\Model $record = null): ?string
    {
        if (!$record) {
            return null;
        }

        // Root pages get folder icon (parent_id is null)
        if ($record->parent_id === null) {
            return 'heroicon-o-folder';
        }

        // Homepage gets special icon
        if ($record->is_homepage) {
            return 'heroicon-o-home';
        }

        // Child pages get document icon
        return 'heroicon-o-document-text';
    }

    protected function hasDeleteAction(): bool
    {
        return false;
    }

    protected function hasEditAction(): bool
    {
        return true;
    }

    protected function hasViewAction(): bool
    {
        return true;
    }

    protected function configureEditAction(EditAction $action): EditAction
    {
        return $action
            ->icon('heroicon-o-pencil')
            ->label(__('pages.edit'))
            ->url(fn (Page $record): string => PageResource::getUrl('edit', ['record' => $record]))
            ->openUrlInNewTab(false);
    }

    protected function configureViewAction(ViewAction $action): ViewAction
    {
        return $action
            ->icon('heroicon-o-eye')
            ->label(__('pages.view'))
            ->url(fn (Page $record): string => $record->url)
            ->openUrlInNewTab(true);
    }

    public function getNodeCollapsedState(?\Illuminate\Database\Eloquent\Model $record = null): bool
    {
        return true;
    }
}

