<?php

namespace App\Models;

use App\Enums\RequestType;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'requested_time',
        'type',
        'duration_minutes',
        'reason',
        'status',
        'employee_id',
    ];

    protected $casts = [
        'type' => RequestType::class,
        'status' => Status::class,
        'date' => 'date',
        'requested_time' => 'datetime',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
