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
        ];
    }
}
