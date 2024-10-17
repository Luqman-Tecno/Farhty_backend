<?php

namespace App\Enum;

use App\Trait\EnumValues;
use Filament\Support\Contracts\HasLabel;

enum BookingShiftEnum: string implements HasLabel
{
    use EnumValues;

    case DAY = 'day';
    case NIGHT = 'night';
    case FULL_DAY = 'full_day';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::DAY => 'صباح',
            self::NIGHT => 'مساء',
            self::FULL_DAY => 'اليوم كله',
        };
    }


}
