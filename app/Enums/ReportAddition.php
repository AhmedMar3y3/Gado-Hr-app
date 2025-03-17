<?php

namespace App\Enums;

enum ReportAddition: int
{
    case NOTHING = 0;
    case TARGET = 1;
    case OVERTIME = 2;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}