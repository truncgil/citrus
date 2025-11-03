<?php

namespace App\Filament\Admin\Pages;

use App\Services\GuideService;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;

class UserGuide extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected string $view = 'filament.admin.pages.user-guide';

    protected static ?int $navigationSort = 999;

    public ?string $selectedGuide = null;

    public function mount(): void
    {
        $guideService = app(GuideService::class);
        $firstGuide = $guideService->getFirstGuide();
        
        if ($firstGuide) {
            $this->selectedGuide = $firstGuide['slug'];
        }
    }

    public static function getNavigationLabel(): string
    {
        return __('user-guide.navigation_label');
    }

    public function getTitle(): string
    {
        return __('user-guide.title');
    }

    public function getMaxContentWidth(): Width | string | null
    {
        return Width::Full;
    }

    public function getGuides(): array
    {
        $guideService = app(GuideService::class);
        return $guideService->getAllGuides();
    }

    public function getSelectedGuideContent(): ?array
    {
        if (!$this->selectedGuide) {
            return null;
        }

        $guideService = app(GuideService::class);
        return $guideService->getGuide($this->selectedGuide);
    }

    public function selectGuide(string $slug): void
    {
        $guideService = app(GuideService::class);
        
        if ($guideService->guideExists($slug)) {
            $this->selectedGuide = $slug;
        }
    }
}

