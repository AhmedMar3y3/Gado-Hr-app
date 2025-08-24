<?php

namespace App\Http\Requests\API\Filters;

use Illuminate\Foundation\Http\FormRequest;

class LeaveFilterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'month' => 'sometimes|integer|min:1|max:12',
            'year' => 'sometimes|integer|min:2020|max:2030',
        ];
    }

    public function messages(): array
    {
        return [
            'month.integer' => 'الشهر يجب أن يكون رقم صحيح',
            'month.min' => 'الشهر يجب أن يكون بين 1 و 12',
            'month.max' => 'الشهر يجب أن يكون بين 1 و 12',
            'year.integer' => 'السنة يجب أن تكون رقم صحيح',
            'year.min' => 'السنة يجب أن تكون بين 2020 و 2030',
            'year.max' => 'السنة يجب أن تكون بين 2020 و 2030',
        ];
    }

    public function getMonth(): int
    {
        return $this->input('month', now()->month);
    }

    public function getYear(): int
    {
        return $this->input('year', now()->year);
    }
}
