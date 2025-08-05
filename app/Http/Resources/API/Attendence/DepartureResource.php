<?php

namespace App\Http\Resources\API\Attendence;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DepartureResource extends JsonResource
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
            'shift' => $this->employee->shift->end_time,
            'departure' => $this->departure,
            'status' => $this->status->formattedName(),
        ];
    }
}
