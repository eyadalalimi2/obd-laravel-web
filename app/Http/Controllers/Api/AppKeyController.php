<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppKeyController extends Controller
{
    // توليد مفتاح جديد
    public function generate(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|unique:app_keys,package_name',
            'version_code' => 'required|string',
        ]);

        $key = base64_encode(Str::random(32));

        $appKey = AppKey::create([
            'package_name' => $request->package_name,
            'version_code' => $request->version_code,
            'encryption_key' => $key,
            'expires_at' => now()->addYears(5),
        ]);

        return response()->json([
            'message' => 'Key created successfully.',
            'data' => $appKey,
        ]);
    }

    // جلب مفتاح بناءً على الحزمة والإصدار
    public function getKey(Request $request)
    {
        $request->validate([
            'package' => 'required|string',
            'version' => 'required|string',
        ]);

        $appKey = AppKey::where('package_name', $request->package)
            ->where('version_code', $request->version)
            ->first();

        if (!$appKey || $appKey->expires_at->isPast()) {
            return response()->json(['error' => 'Key not found or expired.'], 403);
        }

        return response()->json([
            'key' => $appKey->encryption_key,
        ]);
    }
}
