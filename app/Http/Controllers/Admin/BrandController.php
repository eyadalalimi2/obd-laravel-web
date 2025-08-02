<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));
    }


    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Brand::create(['name' => $request->name]);
        return redirect()->route('admin.brands.index')->with('success', 'تمت الإضافة بنجاح.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $brand->update(['name' => $request->name]);
        return redirect()->route('admin.brands.index')->with('success', 'تم التحديث بنجاح.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return back()->with('success', 'تم الحذف بنجاح.');
    }
}
