<?php

namespace App\Http\Requests\API\Article;

use App\Http\Requests\BaseRequest;

class StoreArticleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'about_employee' => 'boolean|required',
            'employee_id' => 'required_if:about_employee,true|exists:employees,id|prohibited_if:about_employee,false',
            'duration_in_days' => 'required|integer|min:1',

        ];
    }
}
