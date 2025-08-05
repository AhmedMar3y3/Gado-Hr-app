<?php

namespace App\Http\Requests\Admin\Employee;

use App\Http\Requests\BaseRequest;

class UpdateEmployeeRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'        => 'nullable|string',
            'role'        => 'nullable|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'username'    => 'nullable|string|unique:employees,username',
            'phone'       => 'nullable|string|unique:employees,phone',
            'city'        => 'nullable|string',
            'age'         => 'nullable|integer',
            'job_id'      => 'nullable|exists:jobs,id',
            'manager_id'  => 'nullable|exists:employees,id',
            'shift_id'    => 'nullable|exists:shifts,id',
            'location_id' => 'nullable|exists:locations,id',
            'off_days'    => 'nullable|integer',
            'salary'      => 'nullable|numeric',
        ];
        if ($this->input('role') == 0) {
            $rules['manager_id'] = 'required|exists:employees,id';
        } else {
            $rules['manager_id'] = 'prohibited';
        }
        return $rules;
    }
}
