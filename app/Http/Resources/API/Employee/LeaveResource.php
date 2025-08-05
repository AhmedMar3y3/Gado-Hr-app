<?php

namespace App\Http\Resources\API\Employee;

use Carbon\Carbon;
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
            'created_at' => $this->created_at->translatedFormat('l, j F'),
            'num_of_days' => $this->num_of_days,
            'from' => Carbon::parse($this->from)->translatedFormat('d F'),
            'status' => [
                'label' => config('enums.status_labels')[$this->status->value],
                'color' => config('enums.status_colors')[$this->status->value],
            ],
        ];
    }
}
