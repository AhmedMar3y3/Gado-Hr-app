<?php

namespace App\Http\Requests\API\Manager\Meeting;

use App\Http\Requests\BaseRequest;

class StoreMeetingRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
            'link' => 'required|url',
            'participants' => 'required|array',
        ];
    }
}
