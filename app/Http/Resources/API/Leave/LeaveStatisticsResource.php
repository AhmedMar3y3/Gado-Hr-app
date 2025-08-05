<?php

namespace App\Http\Resources\API\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveStatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'allowed_off_days'   => (int) $this['allowed_off_days'],
            'used_off_days'      => (int) $this['used_off_days'],
            'remaining_off_days' => (int) $this['remaining_off_days'],
        ];
    }
}
