<?php
namespace App\Http\Resources\API\Report;

use App\Enums\JobType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $baseData = [
            'id'           => $this->id,
            'date' => \Carbon\Carbon::parse($this->date)
                ->locale('ar')
                ->translatedFormat('l, j F'),
        ];

        $jobType = $this->employee->job->type;

        switch ($jobType) {
            case JobType::DRIVER:
                $baseData['num_of_devices'] = $this->num_of_devices;
                $baseData['overtime_hours'] = $this->overtime_hours;
                break;

            case JobType::SALES:
                $baseData['sold_devices']       = $this->sold_devices;
                $baseData['bought_devices']     = $this->bought_devices;
                $baseData['commercial_devices'] = $this->commercial_devices;
                break;

            case JobType::TECHNICIAN:
                $baseData['num_of_devices'] = $this->num_of_devices;
                $baseData['num_of_meters']  = $this->num_of_meters;
                break;

            case JobType::OTHER:
                $baseData['overtime_hours'] = $this->overtime_hours;
                break;
        }
        return $baseData;
    }
}
