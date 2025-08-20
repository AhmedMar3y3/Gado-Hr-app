<?php

namespace App\Http\Requests\API\Filters;

use App\Http\Requests\BaseRequest;

class AttendanceFilterRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'month' => 'sometimes|integer|between:1,12',
            'year' => 'sometimes|integer|min:2020|max:2030',
        ];
    }

    public function messages(): array
    {
        return [
            'month.integer' => 'الشهر يجب أن يكون رقم صحيح',
            'month.between' => 'الشهر يجب أن يكون بين 1 و 12',
            'year.integer' => 'السنة يجب أن تكون رقم صحيح',
            'year.min' => 'السنة يجب أن تكون 2020 أو أحدث',
            'year.max' => 'السنة يجب أن تكون 2030 أو أقدم',
        ];
    }

    /**
     * Get the month filter, default to current month
     */
    public function getMonth(): int
    {
        return $this->input('month', now()->month);
    }

    /**
     * Get the year filter, default to current year
     */
    public function getYear(): int
    {
        return $this->input('year', now()->year);
    }
}
