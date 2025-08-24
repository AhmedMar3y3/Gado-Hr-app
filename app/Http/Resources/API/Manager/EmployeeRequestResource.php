<?php

namespace App\Http\Resources\API\Manager;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeRequestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'date' => Carbon::parse($this->created_at)->locale('ar')->translatedFormat('l, j F'),
            'employee_name' => $this->employee->name,
            'type' => $this->getRequestType(),
            'type_name' => $this->getRequestTypeName(),
        ];

        if ($this->resource instanceof \App\Models\Leave) {
            $data['num_of_days'] = $this->num_of_days;
        } elseif ($this->resource instanceof \App\Models\Advance) {
            $data['amount'] = $this->amount;
            $data['type_of_advance'] = $this->type;
        }

        return $data;
    }

    private function getRequestType(): string
    {
        if ($this->resource instanceof \App\Models\Leave) {
            return 'leave';
        } elseif ($this->resource instanceof \App\Models\Advance) {
            return 'advance';
        }
        return 'unknown';
    }

    private function getRequestTypeName(): string
    {
        if ($this->resource instanceof \App\Models\Leave) {
            return 'طلب إجازة';
        } elseif ($this->resource instanceof \App\Models\Advance) {
            return 'طلب سلفة';
        }
        return 'طلب غير محدد';
    }
}
