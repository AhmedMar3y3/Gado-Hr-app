<?php

namespace App\Http\Resources\API\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeaveWithStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stats' => [
                'allowed_off_days' => (int) $this['statistics']['allowed_off_days'],
                'used_off_days' => (int) $this['statistics']['used_off_days'],
                'remaining_off_days' => (int) $this['statistics']['remaining_off_days'],
            ],
            'leaves' => LeaveResource::collection($this['leaves']),
        ];
    }
}
