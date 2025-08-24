<?php
namespace App\Http\Resources\API\Leave;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Leave;
use App\Enums\Status;
use Carbon\Carbon;

class LeaveDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'start_date'     => $this->from->locale('ar')->translatedFormat('l d F'),
            'end_date'       => $this->to->locale('ar')->translatedFormat('l d F'),
            'number_of_days' => $this->num_of_days,
            'employee'       => [
                'id'    => $this->employee->id,
                'name'  => $this->employee->name,
                'image' => $this->employee->image ?? env('APP_URL') . '/defaults/profile.webp',
                'job'   => $this->employee->job->title,
            ],

            'stats' => [
                'allowed_off_days' => $this->employee->off_days,
                'used_off_days' => $this->getUsedOffDays(),
                'remaining_off_days' => $this->employee->off_days - $this->getUsedOffDays(),
            ]
        ];
    }

    private function getUsedOffDays(): int
    {
        $year = Carbon::now()->year;
        $startDate = Carbon::create($year, 1, 1)->startOfYear();
        $endDate = $startDate->copy()->endOfYear();

        return Leave::where('employee_id', $this->employee->id)
            ->where('status', Status::APPROVED->value)
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('from', [$startDate, $endDate])
                      ->orWhereBetween('to', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('from', '<=', $startDate)
                            ->where('to', '>=', $endDate);
                      });
            })
            ->sum('num_of_days');
    }
}
