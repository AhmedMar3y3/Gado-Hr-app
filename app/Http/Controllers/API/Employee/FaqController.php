<?php

namespace App\Http\Controllers\API\Employee;

use App\Models\Faq;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;

class FaqController extends Controller
{
    use HttpResponses;
    public function index()
    {
        $faqs = Faq::get(['id', 'content']);
        return $this->successWithDataResponse($faqs);
    }
}
