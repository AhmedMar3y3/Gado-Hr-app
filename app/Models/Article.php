<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'about_employee',
        'employee_id'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
