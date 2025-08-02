<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // عرض جميع التصنيفات
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    // عرض نموذج إضافة تصنيف
    public function create()
    {
        return view('admin.categories.create');
    }

    // حفظ تصنيف جديد
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name',
            'slug' => 'nullable|string|unique:categories,slug',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'تم إنشاء التصنيف.');
    }

    // عرض نموذج التعديل
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // تنفيذ التحديث
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => $request->slug ?? Str::slug($request->name),
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث التصنيف.');
    }

    // حذف التصنيف
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'تم حذف التصنيف.');
    }
}
