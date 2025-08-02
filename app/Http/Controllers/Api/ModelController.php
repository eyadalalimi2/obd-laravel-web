<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModelResource;
use App\Models\CarModel;
use App\Models\ModelYear;            // أضف هذا السطر
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;    // أضف هذا للسلاسة

class ModelController extends Controller
{
    /**
     * GET /models
     * جلب جميع الموديلات أو فلترتها حسب brand_id
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $query = CarModel::query();

        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }

        $models = $query->orderBy('name')->get();
        return ModelResource::collection($models);
    }

    /**
     * GET /models/{model}/years
     * جلب قائمة سنوات الإنتاج للموديل المحدد
     */
    public function years(int $model): JsonResponse
    {
        $years = ModelYear::where('model_id', $model)
                          ->pluck('year');
        return response()->json($years);
    }
}
