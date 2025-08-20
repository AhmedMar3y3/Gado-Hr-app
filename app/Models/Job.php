<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\JobType;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
    ];

    protected $casts = [
        'type' => JobType::class,
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
