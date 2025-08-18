<?php 

namespace App\Enums;

enum AdminRole: string
{
    case ADMIN = 'admin';
    case HR = 'hr';
    case ASSISTANT = 'assistant';
}