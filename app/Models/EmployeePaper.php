<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mar3y\ImageUpload\Traits\HasImage;

class EmployeePaper extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'title',
        'image',
        'employee_id',
    ];

    protected static $imageAttributes = ['image'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
