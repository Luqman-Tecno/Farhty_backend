<?php

namespace App\Enum;


use App\Trait\EnumValues;
use Filament\Support\Contracts\HasLabel;

enum BookingStatusEnum: string implements HasLabel
{
    use EnumValues;

    case Booked = 'Booked';
    case Cancelled = 'Cancelled';
    case Pending = 'Pending';
    case CHECKOUT = 'Checkout';
    case ON_REVIEW = 'On Review';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Pending => 'قيد الانتظار',
            self::Booked => 'مؤكد',
            self::Cancelled => 'ملغي',
            self::CHECKOUT => 'تم المغادرة',
            self::ON_REVIEW => 'قيد المراجعة',
        };
    }
}
