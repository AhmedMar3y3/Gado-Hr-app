<?php

namespace App\Http\Resources\API\Request;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d'),
            'requested_time' => $this->requested_time->format('H:i'),
            'type' => $this->type->value,
            'type_name' => $this->type->getArabicName(),
            'duration_minutes' => $this->duration_minutes,
            'reason' => $this->reason,
            'status' => $this->status->value,
            'status_name' => $this->getStatusName(),
            'employee_id' => $this->employee_id,
            'employee_name' => $this->employee->name,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }

    private function getStatusName(): string
    {
        return match($this->status) {
            \App\Enums\Status::PENDING => 'في الانتظار',
            \App\Enums\Status::APPROVED => 'مقبول',
            \App\Enums\Status::REJECTED => 'مرفوض',
            default => 'غير محدد',
        };
    }
}
