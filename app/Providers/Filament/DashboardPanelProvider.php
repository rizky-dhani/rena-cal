<?php

namespace App\Providers\Filament;

use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Enums\Width;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use App\Filament\Dashboard\Pages\EditProfile;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Filament\Http\Middleware\AuthenticateSession;
use App\Filament\Dashboard\Widgets\RecordCountWidget;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use App\Filament\Dashboard\Widgets\CustomerByTypeChartWidget;
use App\Filament\Dashboard\Widgets\TopProvincesByCustomerWidget;
use App\Filament\Dashboard\Resources\Devices\Widgets\DevicesWidget;

class DashboardPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('dashboard')
            ->path('dashboard')
            ->login()
            ->spa()
            ->viteTheme('resources/css/filament/dashboard/theme.css')
            ->brandName('Rena')
            ->brandLogo(fn() => asset('assets/images/logos/Rena-Logo.webp'))
            ->brandLogoHeight('4em')
            ->favicon(fn() => asset('assets/images/logos/Rena-Logo.webp'))
            ->profile(EditProfile::class)
            ->maxContentWidth(Width::Full)
            ->colors([
                'primary' => Color::Red,
            ])
            ->userMenuItems([
                'profile' => MenuItem::make()
                                ->label(fn() => auth()->user()->name)
                                ->url(fn()=> EditProfile::getUrl())
                                ->icon(Heroicon::UserCircle)
            ])
            ->navigationGroups([
                NavigationGroup::make(fn() => __('navigation.Inventories')),
                NavigationGroup::make(fn() =>__('navigation.Devices')),
                NavigationGroup::make(fn() =>__('navigation.User Management'))
            ])
            ->discoverResources(in: app_path('Filament/Dashboard/Resources'), for: 'App\Filament\Dashboard\Resources')
            ->discoverPages(in: app_path('Filament/Dashboard/Pages'), for: 'App\Filament\Dashboard\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Dashboard/Widgets'), for: 'App\Filament\Dashboard\Widgets')
            ->widgets([
                DevicesWidget::class,
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugins([
            ]);
    }
}
