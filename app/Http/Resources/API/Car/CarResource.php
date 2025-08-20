<?php
namespace App\Http\Resources\API\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'model'           => $this->model,
            'license_plate'   => $this->license_plate,
            'license_issue'   => $this->license_issue,
            'license_renewal' => $this->license_renewal,
            'last_oil_change' => $this->last_oil_change,
            'next_oil_change' => $this->next_oil_change,
            'employee_id'     => $this->employee_id,
            'employee_name'   => $this->employee->name,
        ];
    }
}
