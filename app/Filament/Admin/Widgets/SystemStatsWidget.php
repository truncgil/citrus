<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Language;
use App\Models\Page;
use App\Models\Translation;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class SystemStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make(__('dashboard.stats.total_users'), User::count())
                ->description(__('dashboard.stats.total_users'))
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make(__('dashboard.stats.total_pages'), Page::count())
                ->description(__('dashboard.stats.published_pages') . ': ' . Page::where('status', 'published')->count())
                ->descriptionIcon('heroicon-m-document-text')
                ->color('success'),

            Stat::make(__('dashboard.stats.total_translations'), Translation::count())
                ->description(__('dashboard.stats.published_translations') . ': ' . Translation::where('status', 'published')->count())
                ->descriptionIcon('heroicon-m-language')
                ->color('info'),

            Stat::make(__('dashboard.stats.active_languages'), Language::where('is_active', true)->count())
                ->description(__('dashboard.stats.active_languages'))
                ->descriptionIcon('heroicon-m-globe-alt')
                ->color('warning'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}

