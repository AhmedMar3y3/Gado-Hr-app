<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mar3y\ImageUpload\Traits\HasImage;

class MeetingParticipant extends Model
{
    use HasFactory, HasImage;

    protected $fillable = [
        'meeting_id',
        'employee_id',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

}
