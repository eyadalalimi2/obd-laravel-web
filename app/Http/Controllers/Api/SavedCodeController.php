<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SavedCodeResource;
use App\Models\ObdCode;
use App\Models\SavedCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedCodeController extends Controller
{
    /**
     * استرجاع الأكواد المحفوظة للمستخدم
     */
    public function index()
    {
        $saved = SavedCode::with('obdCode')
            ->where('user_id', Auth::id())
            ->orderByDesc('saved_at')
            ->get();

        return SavedCodeResource::collection($saved);
    }

    /**
     * حفظ كود جديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'obd_code_id' => 'required|exists:obd_codes,id',
        ]);

        $exists = SavedCode::where('user_id', Auth::id())
            ->where('obd_code_id', $request->obd_code_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'هذا الكود محفوظ مسبقًا.',
            ], 409);
        }

        $saved = SavedCode::create([
            'user_id' => Auth::id(),
            'obd_code_id' => $request->obd_code_id,
            'saved_at' => now(),
        ]);

        return response()->json([
            'message' => 'تم حفظ الكود بنجاح.',
            'data' => new SavedCodeResource($saved->load('obdCode')),
        ]);
    }

    /**
     * حذف كود محفوظ
     */
    public function destroy($id)
    {
        $saved = SavedCode::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $saved->delete();

        return response()->json([
            'message' => 'تم حذف الكود بنجاح.',
        ]);
    }
}
