<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'time',
        'link',
        'employee_id',
    ];

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function participants()
    {
        return $this->belongsToMany(Employee::class, 'meeting_participants', 'meeting_id', 'employee_id');
    }
}
