<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ObdCode;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('site.category.index', compact('categories'));
    }


    public function show($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $codes = ObdCode::where('category', $slug)->get();

        return view('site.category.show', compact('category', 'codes'));
    }
}
