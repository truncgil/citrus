<?php

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Widgets\ContentOverviewWidget;
use App\Filament\Admin\Widgets\RecentActivitiesWidget;
use App\Filament\Admin\Widgets\SystemStatsWidget;
use App\Filament\Admin\Widgets\TranslationProgressWidget;
use App\Filament\Admin\Widgets\UserActivityWidget;
use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getTitle(): string
    {
        return __('dashboard.title');
    }

    public static function getNavigationLabel(): string
    {
        return __('dashboard.navigation_label');
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('create_page')
                ->label(__('dashboard.actions.create_page'))
                ->icon('heroicon-m-plus')
                ->url(route('filament.admin.resources.pages.create'))
                ->color('primary'),
            
            Action::make('manage_users')
                ->label(__('dashboard.actions.manage_users'))
                ->icon('heroicon-m-users')
                ->url(route('filament.admin.resources.users.index'))
                ->color('gray'),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            SystemStatsWidget::class,
        ];
    }

    public function getWidgets(): array
    {
        return [
            RecentActivitiesWidget::class,
            TranslationProgressWidget::class,
            UserActivityWidget::class,
            ContentOverviewWidget::class,
        ];
    }

    public function getColumns(): array | int
    {
        return 1;
    }
}
