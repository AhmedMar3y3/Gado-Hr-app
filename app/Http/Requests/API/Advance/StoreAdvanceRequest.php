<?php

namespace App\Http\Requests\API\Advance;

use App\Models\Setting;
use App\Enums\AdvanceType;
use App\Http\Requests\BaseRequest;

class StoreAdvanceRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'type' => 'required|in:normal,long_term',
            'amount' => 'required|integer|min:1',
            'number_of_months' => 'prohibited_if:type,normal|integer|min:1|max:60',
        ];

        if ($this->input('type') === AdvanceType::LONG_TERM->value) {
            $rules['number_of_months'] = 'required|integer|min:1|max:60';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'number_of_months.prohibited_if' => 'عدد الأشهر غير مسموح به للسلفة العادية',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->input('type') === AdvanceType::LONG_TERM->value) {
                $setting = Setting::where('key', 'is_longterm_advance_enabled')->first();
                if (!$setting || $setting->value != '1') {
                    $validator->errors()->add('type', 'السلفة طويلة الأجل غير مفعلة في النظام');
                    return;
                }
            }
        });
    }
}
