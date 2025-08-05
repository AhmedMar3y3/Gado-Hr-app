<?php

namespace App\Http\Controllers\API\Home;

use Carbon\Carbon;
use App\Models\Article;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Home\HomeScreenResource;

class HomeController extends Controller
{
    use HttpResponses;

    public function homeScreen()
    {
        $employee = Auth('employee')->user();
        $employee->load(['shift', 'attendances' => function ($query) {
            $query->whereDate('date', Carbon::today());
        }]);

        $todayMeetings = $employee->meetings()->whereDate('date', Carbon::today())->get();
        $articles = Article::latest()->get();

        $employee->todayMeetings = $todayMeetings;
        $employee->articles = $articles;

        return $this->successWithDataResponse(new HomeScreenResource($employee));
    }
}
