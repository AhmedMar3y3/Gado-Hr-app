<?php
namespace App\Http\Controllers\API\Car;

use App\Models\Car;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Car\StoreCarRequest;
use App\Http\Requests\API\Car\UpdateCarRequest;
use App\Http\Resources\API\Car\ManagerCarsResource;
use App\Http\Resources\API\Car\ManagerDetailedCarResource;

class ManagerCarController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $user        = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        $Cars        = Car::whereIn('employee_id', $employeeIds)->get();
        return $this->successWithDataResponse(ManagerCarsResource::collection($Cars));
    }

    public function show(Car $car)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        
        // Check if manager has access to this car
        if (!$employeeIds->contains($car->employee_id)) {
            return $this->failureResponse('لا يمكنك الوصول لهذه السيارة');
        }
        
        return $this->successWithDataResponse(new ManagerDetailedCarResource($car));
    }

    public function store(StoreCarRequest $request)
    {
        Car::create($request->validated());
        return $this->successResponse('تم إنشاء السيارة بنجاح');
    }

    public function update(UpdateCarRequest $request, Car $car)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        
        // Check if manager has access to this car
        if (!$employeeIds->contains($car->employee_id)) {
            return $this->failureResponse('لا يمكنك تحديث هذه السيارة');
        }
        
        $car->update($request->validated());
        return $this->successResponse('تم تحديث السيارة بنجاح');
    }

    public function destroy(Car $car)
    {
        $user = auth('employee')->user();
        $employeeIds = $user->employees->pluck('id');
        
        // Check if manager has access to this car
        if (!$employeeIds->contains($car->employee_id)) {
            return $this->failureResponse('لا يمكنك حذف هذه السيارة');
        }
        
        $car->delete();
        return $this->successResponse('تم حذف السيارة بنجاح');
    }
}
