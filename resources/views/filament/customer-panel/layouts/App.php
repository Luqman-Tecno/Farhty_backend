<?php


namespace App\Filament\CustomerPanel\Layouts;

use Filament\Layouts\Components\Layout;

class App extends Layout
{
    protected static string $view = 'filament.customer-panel.layouts.app';

    public static function make(): static
    {
        return new static();
    }
}
