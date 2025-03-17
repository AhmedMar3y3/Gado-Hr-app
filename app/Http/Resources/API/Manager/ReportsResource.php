<?php

namespace App\Http\Resources\API\Manager;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportsResource extends JsonResource
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
            'date' => $this->date->locale('ar')->translatedFormat('l d F'),
            'name' => $this->employee->name,
            'addition' => $this->addition->formattedName(),
        ];
    }
}
