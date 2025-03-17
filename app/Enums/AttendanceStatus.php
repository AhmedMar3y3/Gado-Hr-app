<?php

namespace App\Enums;

enum AttendanceStatus: int
{
    case INTIME = 0;
    case LATE = 1;
    case EARLY = 2;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}