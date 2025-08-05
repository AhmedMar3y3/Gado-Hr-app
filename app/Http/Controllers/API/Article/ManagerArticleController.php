<?php

namespace App\Http\Controllers\API\Article;

use App\Models\Article;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Manager\ArticlesResource;
use App\Http\Requests\API\Manager\Article\StoreArticleRequest;

class ManagerArticleController extends Controller
{
    use HttpResponses;

     public function index()
    {
        return $this->successWithDataResponse(ArticlesResource::collection(Article::get()));
    }
    public function store(StoreArticleRequest $request)
    {
        $article = Article::create($request->validated() + ['employee_id' => auth('employee')->id()]);
        return $this->successResponse('تم إنشاء المقال بنجاح');
    }
}
