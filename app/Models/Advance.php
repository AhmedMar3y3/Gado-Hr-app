<?php

namespace App\Models;

use App\Enums\AdvanceType;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advance extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
        'status',
        'number_of_months',
        'employee_id',
    ];

    protected $casts = [
        'type' => AdvanceType::class,
        'status' => Status::class,
        'amount' => 'integer',
        'number_of_months' => 'integer',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
