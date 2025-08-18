<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'content',
        'overtime',
        'is_confirmed',
        'employee_id',
        'num_of_devices',
        'num_of_meters',
        'overtime_hours',
        'sold_devices',
        'bought_devices',
        'commercial_devices',
    ];

    protected $casts = [
        'date' => 'date',
        'is_confirmed' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
