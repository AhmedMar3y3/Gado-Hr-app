<?php

namespace App\Http\Controllers\API\Car;

use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\Car\CarResource;

class CarController extends Controller
{
    use HttpResponses;

    public function myCar()
    {
        $user = auth('employee')->user();
        $car = $user->car;
        
        if (!$car) {
            return $this->failureResponse('لا توجد سيارة مسندة لك');
        }
        
        return $this->successWithDataResponse(new CarResource($car));
    }
}
