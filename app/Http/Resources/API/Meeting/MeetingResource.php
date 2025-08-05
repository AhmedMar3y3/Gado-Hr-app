<?php

namespace App\Http\Resources\API\Meeting;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingResource extends JsonResource
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
            'title' => $this->title,
            'date' => $this->date,
            'time' => $this->time,
            'link' => $this->link,
            'participants' => $this->participants->map(function ($participant) {
                return [
                    'id' => $participant->id,
                    'image' => $participant->image ?? env('APP_URL') . '/defaults/profile.webp',
                ];
            }),
        ];
    }
}
