<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObdCode;

class OfflineDataController extends Controller
{
    public function index($language_code = 'en')
    {
        $codes = ObdCode::with(['translations' => function ($query) use ($language_code) {
            $query->where('language_code', $language_code);
        }])->get();

        return response()->json($codes);
    }
}
