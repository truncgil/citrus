<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Admin\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use BezhanSalleh\FilamentShield\FilamentShieldPlugin;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Navigation\MenuItem;
use App\Models\Language;
use Illuminate\Support\Facades\Schema;
use App\Http\Middleware\SetLocale;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $languages = [];
        try {
            if (Schema::hasTable('languages')) {
                $languages = Language::where('is_active', true)->get();
            }
        } catch (\Exception $e) {
            // Migration çalışmamış olabilir
        }

        return $panel
            ->id('admin')
            ->path('admin')
            ->default()
            ->brandLogo(asset('logos/citrus-yatay.svg'))
            ->darkModeBrandLogo(asset('logos/citrus-yatay-dark.svg'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->plugin(\TomatoPHP\FilamentUsers\FilamentUsersPlugin::make())
            ->plugin(FilamentShieldPlugin::make())
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                SetLocale::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->login()
            ->profile() // Profil sayfası ve şifre değiştirme aktif
            ->userMenuItems([
                // Dilleri menüye ekle
                ...collect($languages)->map(function ($language) {
                    return MenuItem::make()
                        ->label($language->native_name)
                        ->url(url('/lang/' . $language->code))
                        ->icon('heroicon-m-language')
                        ->sort(100); // En sonda görünsün
                })->toArray()
            ])
            ->assets([
                \Filament\Support\Assets\Css::make('citrus', resource_path('css/citrus.css')),
            ]);
    }
}
