<?php

namespace App\Http\Resources\API\Home;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\API\Meeting\MeetingResource;
use App\Http\Resources\API\Article\ArticlesResource;

class HomeScreenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $shift = $this->shift;
        $todayAttendance = $this->attendances->first();
        
        $shiftStart = Carbon::parse($shift->start_time);
        $shiftEnd = Carbon::parse($shift->end_time);
        $shiftHours = $shiftEnd->diffInHours($shiftStart);
        
        $lastTimeBeforeDeduction = $shiftStart->copy()->addMinutes(30)->format('H:i');
        
        $dailySalary = null;
        if ($todayAttendance && $todayAttendance->departure) {
            $dailySalary = round($this->salary / 30, 2);
        }

        return [
            'shift' => [
                'from' => $shift->start_time ? Carbon::parse($shift->start_time)->format('h:i') . (Carbon::parse($shift->start_time)->format('A') === 'AM' ? ' ص' : ' م') : null,
                'to' => $shift->end_time ? Carbon::parse($shift->end_time)->format('h:i') . (Carbon::parse($shift->end_time)->format('A') === 'AM' ? ' ص' : ' م') : null,
                'hours' => $shiftHours,
                'last_time_before_deduction' => $lastTimeBeforeDeduction ? Carbon::parse($lastTimeBeforeDeduction)->format('h:i') . (Carbon::parse($lastTimeBeforeDeduction)->format('A') === 'AM' ? ' ص' : ' م') : null,
                'attendance_time' => $todayAttendance ? $todayAttendance->attendance : '',
            ],
            'today_meetings' => MeetingResource::collection($this->todayMeetings ?? collect([])),
            'articles' => ArticlesResource::collection($this->articles ?? collect([])),
            'daily_salary' => $dailySalary ?? '',
        ];
    }
}
