<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;
use Illuminate\Http\Request;

class ObdCodeController extends Controller
{
    /**
     * استرجاع كود OBD برمزه
     */
    public function showByCode($code)
    {
        $code = strtoupper($code);
        $obd = ObdCode::where('code', $code)->first();

        if (!$obd) {
            return response()->json(['message' => 'الكود غير موجود'], 404);
        }

        return response()->json($obd);
    }

    /**
     * استرجاع ترجمة كود بلغة معينة
     */
    public function translation($id, $language_code)
    {
        $translation = ObdCodeTranslation::where('obd_code_id', $id)
            ->where('language_code', $language_code)
            ->first();

        if (!$translation) {
            return response()->json(['message' => 'الترجمة غير متوفرة'], 404);
        }

        return response()->json($translation);
    }

    /**
     * استرجاع الأكواد الشائعة (mock)
     */
    public function trending()
    {
        $top = ObdCode::limit(10)->get();
        return response()->json($top);
    }

    /**
     * مقارنة كودين
     */
    public function compare($id1, $id2)
    {
        $code1 = ObdCode::find($id1);
        $code2 = ObdCode::find($id2);

        if (!$code1 || !$code2) {
            return response()->json(['message' => 'كود واحد أو أكثر غير موجود'], 404);
        }

        return response()->json([
            'code_1' => $code1,
            'code_2' => $code2,
        ]);
    }

    /**
     * البحث حسب عرض الأعراض (قيد التوسعة)
     */
    public function searchBySymptom($symptom)
    {
        $results = ObdCodeTranslation::where('symptoms', 'LIKE', "%{$symptom}%")->get();
        return response()->json($results);
    }
    public function all()
{
    $codes = ObdCode::select([
        'id',
        'code',
        'type',
        'brand_id',
        'title',
        'description',
        'symptoms',
        'causes',
        'solutions',
        'severity',
        'diagnosis',
        'image',
        'updated_at',
    ])->get();

    return response()->json($codes);
}
}
