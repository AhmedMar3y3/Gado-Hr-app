<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ReportAddition;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'content',
        'addition',
        'addition_target',
        'addition_overtime',
        'is_confirmed',
        'employee_id'
    ];

    protected $casts = [
        'addition' => ReportAddition::class,
        'date' => 'date',
        'is_confirmed' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
