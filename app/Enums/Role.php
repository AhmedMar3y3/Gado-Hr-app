<?php

namespace App\Enums;

enum Role: int
{
    case EMPLOYEE = 0;
    case MANAGER = 1;

    public function formattedName(): string
    {
        return ucfirst(strtolower($this->name));
    }
}