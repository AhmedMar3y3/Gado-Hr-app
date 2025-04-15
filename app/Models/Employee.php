<?php

namespace App\Models;

use App\Enums\Role;
use App\Traits\HasImage;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
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

    protected $casts = [

        'role' => Role::class,
    ];

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

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

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function deleteManagerId($request)
    {
        if ($request->role == 1) {
            $this->manager_id = null;
            $this->save();
            return true;
        }
        return false;
    }


    public function meetings()
    {
        return $this->belongsToMany(Meeting::class, 'meeting_participants', 'employee_id', 'meeting_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    public function checkRole(Role $role)
    {
        if ($role === Role::MANAGER) {
            return true;
        }
        return false;
    }
}
