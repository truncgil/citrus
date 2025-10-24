<?php

namespace App\Filament\Admin\Widgets;

use App\Models\Page;
use App\Models\Translation;
use Filament\Widgets\ChartWidget;

class ContentOverviewWidget extends ChartWidget
{
    protected static ?int $sort = 5;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $pagesByStatus = Page::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $translationsByStatus = Translation::selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => __('dashboard.content_overview.pages_by_status'),
                    'data' => [
                        $pagesByStatus['published'] ?? 0,
                        $pagesByStatus['draft'] ?? 0,
                        $pagesByStatus['review'] ?? 0,
                    ],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)', // success - published
                        'rgb(156, 163, 175)', // gray - draft
                        'rgb(245, 158, 11)', // warning - review
                    ],
                ],
                [
                    'label' => __('dashboard.content_overview.translations_by_status'),
                    'data' => [
                        $translationsByStatus['published'] ?? 0,
                        $translationsByStatus['draft'] ?? 0,
                        $translationsByStatus['review'] ?? 0,
                        $translationsByStatus['approved'] ?? 0,
                    ],
                    'backgroundColor' => [
                        'rgb(34, 197, 94)', // success - published
                        'rgb(156, 163, 175)', // gray - draft
                        'rgb(245, 158, 11)', // warning - review
                        'rgb(59, 130, 246)', // info - approved
                    ],
                ],
            ],
            'labels' => [
                __('dashboard.content_overview.published'),
                __('dashboard.content_overview.draft'),
                __('dashboard.content_overview.review'),
                __('dashboard.content_overview.approved'),
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'position' => 'top',
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                ],
            ],
        ];
    }
}

