<?php

namespace App\Http\Resources\API\Employee;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportDetailsResource extends JsonResource
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
            'content' => $this->content,
            'addition' => $this->addition->formattedName(),
            'addition_target' => $this->when($this->addition_target !== null, $this->addition_target),
            'addition_overtime' => $this->when($this->addition_overtime !== 0, $this->addition_overtime),
        ];
    }
}
