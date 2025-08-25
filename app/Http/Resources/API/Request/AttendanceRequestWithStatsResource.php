<?php

namespace App\Http\Resources\API\Request;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceRequestWithStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'requests' => AttendanceRequestResource::collection($this['requests']),
            'stats' => [
                'total_requests' => $this['stats']['total_requests'],
                'pending_requests' => $this['stats']['pending_requests'],
                'approved_requests' => $this['stats']['approved_requests'],
                'rejected_requests' => $this['stats']['rejected_requests'],
                'requests_45min' => $this['stats']['requests_45min'],
                'requests_30min' => $this['stats']['requests_30min'],
                'requests_15min' => $this['stats']['requests_15min'],
                'remaining_45min' => $this['stats']['remaining_45min'],
                'remaining_30min' => $this['stats']['remaining_30min'],
                'remaining_15min' => $this['stats']['remaining_15min'],
                'monthly_limit' => $this['stats']['monthly_limit'],
            ],
        ];
    }
}
