<?php


namespace App\Filament;

use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Support\Colors\Color;
use Filament\Themes\Contracts\Theme;

class CustomTheme implements Theme
{
    public static function getName(): string
    {
        return 'custom';
    }

    public static function getStylesheetUrl(): string
    {
        return asset('css/custom-filament.css');
    }
}
