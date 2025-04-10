<?php

namespace App\Http\Requests\API\Admin\Employee;

use App\Http\Requests\BaseRequest;

class AddEmployeeRequest extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'name'        => 'required|string',
            'role'        => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'username'    => 'required|string|unique:employees,username',
            'password'    => 'required|string',
            'phone'       => 'required|string|unique:employees,phone',
            'city'        => 'required|string',
            'age'         => 'required|integer',
            'job_id'      => 'required|exists:jobs,id',
            'manager_id'  => 'nullable|exists:employees,id',
            'shift_id'    => 'required|exists:shifts,id',
            'location_id' => 'required|exists:locations,id',
            'off_days'    => 'nullable|integer',
            'salary'      => 'required|numeric',
        ];

        if ($this->input('role') == 1) {
            $rules['manager_id'] = 'prohibited';
        }

        return $rules;
    }
}
