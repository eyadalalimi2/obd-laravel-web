<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * جلب إعدادات التطبيق العامة
     */
    public function index()
    {
        $settings = DB::table('settings')->pluck('value', 'key');
        return response()->json($settings);
    }
}
