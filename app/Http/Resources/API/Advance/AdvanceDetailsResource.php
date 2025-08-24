<?php
namespace App\Http\Resources\API\Advance;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Advance;
use Carbon\Carbon;

class AdvanceDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'type'     => $this->type,
            'type_name' => $this->type === \App\Enums\AdvanceType::NORMAL ? 'سلفة عادية' : 'سلفة طويلة الامد',
            'amount'   => $this->amount,
            ...(isset($this->number_of_months) ? ['number_of_months' => $this->number_of_months] : []),
            'employee' => [
                'id'    => $this->employee->id,
                'name'  => $this->employee->name,
                'image' => $this->employee->image ?? env('APP_URL') . '/defaults/profile.webp',
                'job'   => $this->employee->job->title,
            ],

            ...( $this->type === \App\Enums\AdvanceType::NORMAL ? [
                'stats' => [
                    'latest_advance_date' => $this->getLatestAdvanceDate()
                        ? Carbon::parse($this->getLatestAdvanceDate())->locale('ar')->translatedFormat('Y F d')
                        : 'لا يوجد سلف سابقة',
                ],
            ] : [] ),
        ];
    }
    private function getLatestAdvanceDate(): ?string
    {
        $latestAdvance = Advance::where('employee_id', $this->employee->id)
            ->orderBy('created_at', 'desc')
            ->first();

        return $latestAdvance ? $latestAdvance->created_at->format('Y-m-d') : null;
    }
}
