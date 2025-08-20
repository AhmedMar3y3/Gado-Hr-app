<?php

namespace App\Http\Resources\API\Report;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DailyReportResource extends JsonResource
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
            'date' => $this->date,
            'content' => $this->content,
            'is_confirmed' => $this->is_confirmed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
            // Job-specific fields
            'num_of_devices' => $this->num_of_devices,
            'num_of_meters' => $this->num_of_meters,
            'overtime_hours' => $this->overtime_hours,
            'sold_devices' => $this->sold_devices,
            'bought_devices' => $this->bought_devices,
            'commercial_devices' => $this->commercial_devices,
            
            // Employee information
            'employee' => [
                'id' => $this->employee->id,
                'name' => $this->employee->name,
                'job' => [
                    'id' => $this->employee->job->id,
                    'title' => $this->employee->job->title,
                    'type' => $this->employee->job->type,
                ]
            ]
        ];
    }
}
