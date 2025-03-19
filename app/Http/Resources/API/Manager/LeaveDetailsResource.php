<?php

namespace App\Http\Resources\API\Manager;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveDetailsResource extends JsonResource
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
            'employee_id' => $this->employee->id,
            'employee_name' => $this->employee->name,
            'employee_image' => $this->employee->image,
            'start_date' => $this->from->locale('ar')->translatedFormat('l d F'),
            'end_date' => $this->to->locale('ar')->translatedFormat('l d F'),
            'number_of_days' => $this->num_of_days,
            'status' => $this->status->formattedName(),
        ];
    }
}
