<?php

namespace App\Http\Resources\API\Advance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvanceWithStatsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'stats' => [
                'latest_advance_date' =>  \Carbon\Carbon::parse($this['stats']['latest_advance_date'])->locale('ar')->translatedFormat('Y F d')
                    ?? 'لا يوجد سلف سابقة',
            ],
            'advances' => AdvanceResource::collection($this['advances']),
        ];
    }
}
