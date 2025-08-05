<?php

namespace App\Http\Requests\API\Meeting;

use App\Http\Requests\BaseRequest;

class StoreMeetingRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'date' => 'required|date|after_or_equal:date',
            'time' => 'required|date_format:H:i',
            'link' => 'required|url',
            'participants' => 'required|array',
        ];
    }
}
