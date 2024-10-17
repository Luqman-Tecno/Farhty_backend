<?php

namespace App\Filament\CustomerPanel\Components;

use Filament\Panel;
use Illuminate\View\Component;
use Illuminate\View\View;

class Layout extends Component
{
    public function __construct(
        protected Panel $panel,
    ) {}

    public function render(): View
    {
        return view('filament.customer-panel.components.layout', [
            'panel' => $this->panel,
        ]);
    }
}
