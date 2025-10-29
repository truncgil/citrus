<?php

namespace App\Filament\Admin\Resources\Settings\Pages;

use App\Filament\Admin\Resources\Settings\SettingResource;
use App\Filament\Admin\Resources\Settings\Tables\SettingsTable;
use Filament\Actions\CreateAction;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListSettings extends ListRecords implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = SettingResource::class;

    public ?string $activeGroup = null;

    public function getView(): string
    {
        return 'filament.admin.resources.settings.pages.list-settings';
    }

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

    public function mount(): void
    {
        parent::mount();
        
        // Query string'den activeGroup' 별 al, yoksa tüm ayarları göster (null)
        $this->activeGroup = request()->query('group', null);
    }

    public function getGroups(): \Illuminate\Support\Collection
    {
        return \App\Models\Setting::whereNull('deleted_at')
            ->select('group')
            ->distinct()
            ->orderBy('group')
            ->pluck('group')
            ->mapWithKeys(function ($group) {
                return [$group => __("settings.group_{$group}")];
            });
    }

    public function setActiveGroup(?string $group): void
    {
        $this->activeGroup = $group;
    }

    protected function getTableQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getTableQuery();
        
        // Eğer bir grup seçildiyse filtrele
        if ($this->activeGroup) {
            $query->where('group', $this->activeGroup);
        }
        
        return $query;
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

    protected function getGroupCount(?string $group): int
    {
        if (!$group) {
            return \App\Models\Setting::whereNull('deleted_at')->count();
        }

        return \App\Models\Setting::where('group', $group)
            ->whereNull('deleted_at')
            ->count();
    }
}
