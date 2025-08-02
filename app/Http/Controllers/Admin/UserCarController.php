<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserCar;
use App\Models\User;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ModelYear;
use Illuminate\Http\Request;

class UserCarController extends Controller
{
    // قائمة السيارات مع الفلاتر
    public function index(Request $request)
    {
        $cars = UserCar::with(['user', 'brand', 'model'])
            ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
            ->when($request->brand_id, fn($q) => $q->where('brand_id', $request->brand_id))
            ->when($request->model_id, fn($q) => $q->where('model_id', $request->model_id))
            ->latest()->paginate(20);

        $users = User::pluck('username', 'id');
        $brands = Brand::pluck('name', 'id');
        $models = CarModel::pluck('name', 'id');

        return view('admin.user_cars.index', compact('cars', 'users', 'brands', 'models'));
    }

    // شاشة إضافة سيارة
    public function create()
    {
        $users = User::pluck('username', 'id');
        $brands = Brand::pluck('name', 'id');
        $models = []; // لا موديلات حتى يختار الشركة
        $years  = []; // لا سنوات حتى يختار الموديل
        return view('admin.user_cars.create', compact('users', 'brands', 'models', 'years'));
    }


    // حفظ سيارة جديدة
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4',
            'car_name' => 'nullable|string|max:50',
        ]);

        UserCar::create($request->all());

        return redirect()->route('admin.user_cars.index')
            ->with('success', 'تمت إضافة السيارة بنجاح.');
    }

    // شاشة تعديل سيارة
    public function edit($id)
    {
        $car = UserCar::findOrFail($id);
        $users = User::pluck('username', 'id');
        $brands = Brand::pluck('name', 'id');

        // جلب الموديلات حسب الشركة الحالية للسيارة
        $models = [];
        if ($car->brand_id) {
            $models = CarModel::where('brand_id', $car->brand_id)->pluck('name', 'id');
        }

        // جلب السنوات حسب الموديل الحالي للسيارة
        $years = [];
        if ($car->model_id) {
            $years = ModelYear::where('model_id', $car->model_id)->pluck('year');
        }

        return view('admin.user_cars.edit', compact('car', 'users', 'brands', 'models', 'years'));
    }

    // حفظ التعديل
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'brand_id' => 'required|exists:brands,id',
            'model_id' => 'required|exists:models,id',
            'year' => 'required|digits:4',
            'car_name' => 'nullable|string|max:50',
        ]);

        $car = UserCar::findOrFail($id);
        $car->update($request->all());

        return redirect()->route('admin.user_cars.index')
            ->with('success', 'تم تحديث السيارة بنجاح.');
    }

    // حذف سيارة
    public function destroy($id)
    {
        $car = UserCar::findOrFail($id);
        $car->delete();

        return redirect()->route('admin.user_cars.index')
            ->with('success', 'تم حذف السيارة بنجاح.');
    }
}
