<?php

namespace App\Enums;

enum RequestType: string
{
    case LATE_CLOCK_IN = 'late_clock_in';
    case EARLY_CLOCK_OUT = 'early_clock_out';

    public function getArabicName(): string
    {
        return match($this) {
            self::LATE_CLOCK_IN => 'طلب تأخير في الحضور',
            self::EARLY_CLOCK_OUT => 'طلب انصراف مبكر',
        };
    }
}
