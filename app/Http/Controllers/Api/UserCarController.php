<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserCarStoreRequest;
use App\Http\Requests\UserCarUpdateRequest;
use App\Http\Resources\UserCarResource;
use App\Models\UserCar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserCarController extends Controller
{
    // قائمة سيارات المستخدم
    public function index(Request $request)
    {
        $user = $request->user();
        $cars = UserCar::with(['brand', 'model'])
            ->where('user_id', $user->id)
            ->get();

        return UserCarResource::collection($cars);
    }

    // إضافة سيارة جديدة
    public function store(UserCarStoreRequest $request)
{
    $data = $request->validated();
    $data['user_id'] = Auth::id();

    $car = UserCar::create($data);

    return new UserCarResource($car->load(['brand', 'model']));
}

public function update(UserCarUpdateRequest $request, $id)
{
    $user = Auth::user();
    $car = UserCar::where('user_id', $user->id)->findOrFail($id);

    $car->update($request->validated());

    return new UserCarResource($car->fresh()->load(['brand', 'model']));
}

    // حذف سيارة
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $car = UserCar::where('user_id', $user->id)->findOrFail($id);

        $car->delete();

        return response()->json(['message' => 'تم حذف السيارة بنجاح.']);
    }
}
