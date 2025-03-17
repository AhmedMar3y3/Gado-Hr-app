<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\AttendanceStatus;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'attendance', 'departure', 'status', 'total_delay', 'overtime', 'employee_id'
    ];

    protected $casts = [
        'status' => AttendanceStatus::class,
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
