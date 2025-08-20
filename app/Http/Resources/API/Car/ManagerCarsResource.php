<?php
namespace App\Http\Resources\API\Car;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerCarsResource extends JsonResource
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
            'license_renewal' => $this->license_renewal,
            'next_oil_change' => $this->next_oil_change,
        ];
    }
}
