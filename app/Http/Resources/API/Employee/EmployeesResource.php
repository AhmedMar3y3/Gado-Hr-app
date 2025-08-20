<?php

namespace App\Http\Resources\API\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeesResource extends JsonResource
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
            'name' => $this->name,
            'job' => $this->job->title,
            'image' => $this->image ?? env('APP_URL') . '/defaults/profile.webp',
        ];
    }
}
