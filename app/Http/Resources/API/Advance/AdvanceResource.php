<?php

namespace App\Http\Resources\API\Advance;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdvanceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => Carbon::parse($this->created_at)->locale('ar')->translatedFormat('l, j F'),
            'amount' => $this->amount,
            'status' => [
                'label' => config('enums.status_labels')[$this->status->value],
                'color' => config('enums.status_colors')[$this->status->value],
            ],
        ];
    }
}
