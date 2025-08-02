<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ModelYear;
use App\Models\CarModel;
use Illuminate\Http\Request;

class ModelYearController extends Controller
{
    public function index()
    {
        $years = ModelYear::all();
        return view('admin.model_years.index', compact('years'));
    }

    public function create()
    {
        $models = CarModel::all();
        return view('admin.model_years.create', compact('models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'model_id' => 'required|exists:models,id'
        ]);

        ModelYear::create($request->all());
        return redirect()->route('admin.model_years.index')->with('success', 'تمت الإضافة بنجاح.');
    }

    public function edit(ModelYear $model_year)
    {
        $models = CarModel::all();
        return view('admin.model_years.edit', compact('model_year', 'models'));
    }

    public function update(Request $request, ModelYear $model_year)
    {
        $request->validate([
            'year' => 'required|integer',
            'model_id' => 'required|exists:models,id'
        ]);

        $model_year->update($request->all());
        return redirect()->route('admin.model_years.index')->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(ModelYear $model_year)
    {
        $model_year->delete();
        return back()->with('success', 'تم الحذف بنجاح.');
    }
}
