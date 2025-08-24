<?php

namespace App\Http\Controllers\API\Article;

use App\Models\Article;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Article\ArticlesResource;
use App\Http\Requests\API\Article\StoreArticleRequest;

class ArticleController extends Controller
{
    use HttpResponses;

     public function index()
    {
        return $this->successWithDataResponse(ArticlesResource::collection(Article::get()));
    }
    public function store(StoreArticleRequest $request)
    {
        Article::create($request->validated());
        return $this->successResponse('تم إنشاء المقال بنجاح');
    }
}
