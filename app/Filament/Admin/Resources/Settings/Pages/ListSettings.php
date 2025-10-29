<?php

namespace App\Filament\Admin\Resources\Settings\Pages;

use App\Filament\Admin\Resources\Settings\SettingResource;
use App\Models\Setting;
use Filament\Actions\CreateAction;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    public function getTitle(): string
    {
        return __('settings.title');
    }

    public function getHeading(): string | Htmlable
    {
        return __('settings.title');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('settings.create')),
        ];
    }

    public function getTabs(): array
    {
        $tabs = [];

        // "Tüm Ayarlar" tab'ı ekle
        $allCount = Setting::query()->count();
        $tabs['all'] = Tab::make(__('settings.all_settings'))
            ->icon($this->getGroupIcon(null))
            ->badge($allCount);

        // Her grup için tab oluştur
        $groups = Setting::query()
            ->select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group');

        foreach ($groups as $group) {
            $count = Setting::where('group', $group)->count();
            $label = __("settings.group_{$group}");
            
            $tabs[$group] = Tab::make($label)
                ->icon($this->getGroupIcon($group))
                ->badge($count)
                ->modifyQueryUsing(fn (Builder $query) => $query->where('group', $group));
        }

        return $tabs;
    }

    protected function getGroupIcon(?string $group): string
    {
        if (!$group) {
            return 'heroicon-o-squares-2x2';
        }

        return match($group) {
            'general' => 'heroicon-o-cog-6-tooth',
            'theme' => 'heroicon-o-paint-brush',
            'localization' => 'heroicon-o-language',
            'email' => 'heroicon-o-envelope',
            'seo' => 'heroicon-o-magnifying-glass',
            'social' => 'heroicon-o-share',
            'security' => 'heroicon-o-shield-check',
            'upload' => 'heroicon-o-cloud-arrow-up',
            'payment' => 'heroicon-o-credit-card',
            'notification' => 'heroicon-o-bell',
            'cache' => 'heroicon-o-arrow-path',
            'api' => 'heroicon-o-code-bracket',
            'logging' => 'heroicon-o-document-text',
            'performance' => 'heroicon-o-bolt',
            'integration' => 'heroicon-o-puzzle-piece',
            default => 'heroicon-o-squares-2x2',
        };
    }
}
