<?php

namespace App\Enum;

use App\Trait\EnumValues;
use Filament\Support\Contracts\HasLabel;

enum UserTypeEnum: string implements HasLabel
{
    use EnumValues;

    case ADMIN = 'Admin';
    case WEDDING_ADMIN = 'Wedding admin';
    case USER = 'user';

    public function getLabel(): ?string
    {

        return match ($this) {

            self::ADMIN => 'مدير النظام',
            self::WEDDING_ADMIN => 'مدير الصالة',
            self::USER => 'مستخدم',


        };
    }

}
