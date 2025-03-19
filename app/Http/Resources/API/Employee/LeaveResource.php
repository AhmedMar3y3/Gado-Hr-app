<?php

namespace App\Http\Resources\API\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveResource extends JsonResource
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
            'from' => $this->from,
            'num_of_days' => $this->num_of_days,
            'status' => $this->status->formattedName(),
        ];
    }
}
