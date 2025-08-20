<?php
namespace App\Http\Resources\API\Attendence;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'date'        => Carbon::parse($this->date)->locale('ar')->translatedFormat('l, j F'), 
            'attendance'  => $this->attendance ? Carbon::parse($this->attendance)->format('h:i') . ' ' . (date('a', strtotime($this->attendance)) == 'am' ? 'ص' : 'م') : null,
            'departure'   => $this->departure ? Carbon::parse($this->departure)->format('h:i') . ' ' . (date('a', strtotime($this->departure)) == 'am' ? 'ص' : 'م') : null,
        ];
    }
}
