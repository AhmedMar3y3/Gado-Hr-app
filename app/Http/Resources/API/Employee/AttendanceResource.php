<?php

namespace App\Http\Resources\API\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'shift' => $this->employee->shift->start_time,
            'attendance' => $this->attendance,
            'status' => $this->status->formattedName(),
        ];
    }
}
