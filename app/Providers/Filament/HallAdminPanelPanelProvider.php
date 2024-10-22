<?php

namespace App\Providers\Filament;

use App\Http\Middleware\HallAdminMiddleware;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\View\View;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class HallAdminPanelPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('hallAdminPanel')
            ->path('/HallAdmin')
            ->login()
            ->font('cairo')
            ->colors([
                'danger' => Color::rgb('rgb(255,0,0)'),
                'gray' => Color::Gray,
                'info' => Color::Green,
                'primary' => Color::Violet,
                'success' => Color::Lime,
                'warning' => Color::rgb('rgb(255,69,0)'),
                'edit' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/HallAdminPanel/Resources'), for: 'App\\Filament\\HallAdminPanel\\Resources')
            ->discoverPages(in: app_path('Filament/HallAdminPanel/Pages'), for: 'App\\Filament\\HallAdminPanel\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/HallAdminPanel/Widgets'), for: 'App\\Filament\\HallAdminPanel\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])->plugins([FilamentFullCalendarPlugin::make()])
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
               HallAdminMiddleware::class,
            ])->renderHook('panels::topbar.start', fn(): View => view('filament.app.hooks.welcome_user'));
    }
}
