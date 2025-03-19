<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'from', 'to', 'status', 'num_of_days'];

    protected $casts = [
        'status' => Status::class,
        'from' => 'date',
        'to' => 'date',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
