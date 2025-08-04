<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_time',
        'end_time',
        'title',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
