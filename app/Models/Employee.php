<?php

namespace App\Models;

use App\Traits\HasImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Employee extends Authenticatable
{
    use HasFactory, HasImage, HasApiTokens;

    protected $fillable = [
        'name',
        'role',
        'image',
        'username',
        'password',
        'phone',
        'city',
        'age',
        'job_id',
        'manager_id',
        'shift_id',
        'location_id',
        'off_days',
        'salary',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function manager()
    {
        return $this->belongsTo(Employee::class, 'manager_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'manager_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
