<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ModelYear;

class CarController extends Controller
{
    public function index()
    {
        $brands = Brand::with('models.years')->get();
        return view('admin.cars.index', compact('brands'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.cars.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_name' => 'required|string|max:255',
            'model_name' => 'required|string|max:255',
            'years'      => 'required|array|min:1'
        ]);

        // حفظ أو استرجاع البراند
        $brand = Brand::firstOrCreate(['name' => $request->brand_name]);

        // إنشاء موديل
        $model = CarModel::create([
            'name' => $request->model_name,
            'brand_id' => $brand->id
        ]);

        // حفظ السنوات
        foreach ($request->years as $year) {
            ModelYear::create([
                'model_id' => $model->id,
                'year' => $year
            ]);
        }

        return redirect()->route('admin.cars.index')->with('success', 'تمت إضافة السيارة بنجاح.');
    }

    public function destroy($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return back()->with('success', 'تم حذف الشركة وموديلاتها.');
    }
}
