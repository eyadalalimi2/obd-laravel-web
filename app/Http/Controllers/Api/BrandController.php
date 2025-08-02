<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    // جلب جميع الشركات
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        return BrandResource::collection($brands);
    }

    // جلب جميع الموديلات المرتبطة بشركة محددة
    public function models($brandId)
    {
        $brand = Brand::with('models')->findOrFail($brandId);
        return response()->json([
            'brand' => new BrandResource($brand),
            'models' => $brand->models // ممكن تحويلهم لاحقًا لـ Resource مخصص إذا رغبت
        ]);
    }
}
