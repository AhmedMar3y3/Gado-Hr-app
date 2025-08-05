<?php 

namespace App\Enums;

enum JobType: string
{
    case DRIVER = 'driver';
    case SALES = 'sales';
    case TECHNICIAN = 'technician';
    case OTHER = 'other';
}