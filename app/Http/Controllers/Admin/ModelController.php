<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarModel;
use App\Models\Brand;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function index()
    {
        $models = CarModel::all();
        return view('admin.models.index', compact('models'));
    }

    public function create()
    {
        $brands = Brand::all();
        return view('admin.models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id'
        ]);

        CarModel::create($request->all());
        return redirect()->route('admin.models.index')->with('success', 'تمت الإضافة بنجاح.');
    }

    public function edit(CarModel $model)
    {
        $brands = Brand::all();
        return view('admin.models.edit', compact('model', 'brands'));
    }

    public function update(Request $request, CarModel $model)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id'
        ]);

        $model->update($request->all());
        return redirect()->route('admin.models.index')->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(CarModel $model)
    {
        $model->delete();
        return back()->with('success', 'تم الحذف بنجاح.');
    }
}
