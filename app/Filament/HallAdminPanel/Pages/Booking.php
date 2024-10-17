<?php

namespace App\Filament\HallAdminPanel\Pages;

use Filament\Pages\Page;

class Booking extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected ?string $heading = ' الحجوزات';
    protected static ?string $navigationLabel = 'جدول الحجوزات';
    protected static ?string $navigationGroup = 'الصالة';
    protected static string $view = 'filament.hall-admin-panel.pages.booking';
}
