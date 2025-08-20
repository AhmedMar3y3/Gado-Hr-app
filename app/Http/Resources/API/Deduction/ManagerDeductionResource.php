<?php
namespace App\Http\Resources\API\Deduction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ManagerDeductionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'date'     => \Carbon\Carbon::parse($this->date)
                ->locale('ar')
                ->translatedFormat('l, j F'),
            'amount'   => $this->amount,
            'type'     => $this->type,
            'employee' => [
                'name' => $this->employee->name,
                'job'  => $this->employee->job->title,
            ],
        ];
    }
}
