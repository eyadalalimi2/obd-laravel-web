<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;
use App\Models\Language;
use Illuminate\Http\Request;

class ObdCodeTranslationController extends Controller
{
    public function index()
    {
        $obdCodes = ObdCode::latest()->paginate(20);
        return view('admin.obd_translations.index', compact('obdCodes'));
    }
    public function edit($obd_code_id)
    {
        $obdCode = ObdCode::findOrFail($obd_code_id);
        $languages = Language::where('is_active', true)->get();
        $currentTranslation = null;

        return view('admin.obd_translations.edit', compact('obdCode', 'languages', 'currentTranslation'));
    }
    public function update(Request $request, $obd_code_id)
    {
        $obdCode = ObdCode::findOrFail($obd_code_id);

        $data = $request->validate([
            'language_code' => 'required|string|max:10',
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'causes'        => 'nullable|string',
            'symptoms'      => 'nullable|string',
            'solutions'     => 'nullable|string',
            'severity'      => 'nullable|string',
            'diagnosis'     => 'nullable|string',
        ]);

        $translation = ObdCodeTranslation::updateOrCreate(
            [
                'obd_code_id'   => $obdCode->id,
                'language_code' => $data['language_code'],
            ],
            $data
        );

        return redirect()
            ->route('admin.obd_translations.index')
            ->with('success', 'تم حفظ الترجمة بنجاح.');
    }
    public function exportJson()
    {
        $translations = \App\Models\ObdCodeTranslation::with('obdCode')->get();

        $data = $translations->groupBy('obd_code_id')->map(function ($items, $codeId) {
            $obdCode = $items->first()->obdCode;

            return [
                'obd_code_id' => $obdCode->id,
                'code'       => $obdCode->code,
                'translations' => $items->mapWithKeys(function ($item) {
                    return [
                        $item->language_code => [
                            'title'       => $item->title,
                            'description' => $item->description,
                            'symptoms'    => $item->symptoms,
                            'causes'      => $item->causes,
                            'solutions'   => $item->solutions,
                            'diagnosis'   => $item->diagnosis,
                            'severity'    => $item->severity,
                            'category'    => $item->category,
                        ]
                    ];
                })
            ];
        })->values();

        $fileName = 'obd_translations_' . now()->format('Y_m_d_H_i_s') . '.json';

        return response()->json($data, 200, [
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            'Content-Type'        => 'application/json',
        ]);
    }
    public function importJson(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json',
        ]);

        $jsonContent = file_get_contents($request->file('json_file')->getRealPath());
        $data = json_decode($jsonContent, true);

        foreach ($data as $item) {
            $obd_code_id = $item['obd_code_id'];
            $translations = $item['translations'];

            foreach ($translations as $language_code => $fields) {
                \App\Models\ObdCodeTranslation::updateOrCreate(
                    ['obd_code_id' => $obd_code_id, 'language_code' => $language_code],
                    $fields
                );
            }
        }

        return redirect()->route('admin.obd_translations.index')->with('success', 'تم استيراد الترجمات بنجاح.');
    }
    public function report()
    {
        $obdCodes = \App\Models\ObdCode::all();
        $languages = \App\Models\Language::where('is_active', true)->get();

        $translations = \App\Models\ObdCodeTranslation::all()->groupBy(function ($item) {
            return $item->obd_code_id . '_' . $item->language_code;
        });

        return view('admin.obd_translations.report', compact('obdCodes', 'languages', 'translations'));
    }
    public function showTranslationManager()
    {
        $languages = \App\Models\Language::where('is_active', true)->get();
        return view('admin.obd_translations.manager', compact('languages'));
    }
    public function startImport(Request $request)
    {
        try {
            $codes = \App\Models\ObdCode::all();
            $count = $codes->count();
            Log::info("تم استيراد $count كود بنجاح.");
            return response()->json(['status' => 'success', 'message' => "تم استيراد $count كود بنجاح.", 'total' => $count]);
        } catch (\Exception $e) {
            Log::error('فشل الاستيراد: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
    public function analyzeUntranslatedTexts(Request $request)
    {
        $langCode = $request->input('language');
        $totalUntranslated = \App\Models\ObdCode::whereDoesntHave('translations', function ($query) use ($langCode) {
            $query->where('language_code', $langCode);
        })->count();
        Log::info("تم تحليل $totalUntranslated نص غير مترجم.");
        return response()->json(['status' => 'success', 'message' => "عدد النصوص غير المترجمة هو $totalUntranslated", 'total' => $totalUntranslated]);
    }
    public function startTranslation(Request $request)
    {
        $langCode = $request->input('language');
        $translator = new \App\Services\OpenAiTranslationService();
        $codes = \App\Models\ObdCode::whereDoesntHave('translations', function ($query) use ($langCode) {
            $query->where('language_code', $langCode);
        })->get();

        $results = [];
        foreach ($codes as $code) {
            $results[] = [
                'code' => $code->code,
                'title' => $translator->translate($code->title, $langCode),
                'description' => $translator->translate($code->description, $langCode),
            ];
        }

        $fileName = "obd_translations_{$langCode}_" . now()->format('Y_m_d_H_i_s') . ".json";
        Storage::put("exports/{$fileName}", json_encode($results, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
        Log::info("تم إنشاء ملف الترجمة: $fileName");

        return response()->json(['status' => 'success', 'message' => 'تم إنشاء ملف الترجمة بنجاح.', 'file' => $fileName]);
    }
    public function exportToDatabase(Request $request)
    {
        $fileName = $request->input('file');
        $langCode = $request->input('language');
        $path = storage_path("app/exports/$fileName");

        if (!file_exists($path)) {
            Log::error("الملف غير موجود: $fileName");
            return response()->json(['status' => 'error', 'message' => 'الملف غير موجود.'], 404);
        }

        $data = json_decode(file_get_contents($path), true);
        foreach ($data as $item) {
            \App\Models\ObdCodeTranslation::updateOrCreate(
                ['obd_code_id' => \App\Models\ObdCode::where('code', $item['code'])->first()->id ?? null, 'language_code' => $langCode],
                $item
            );
        }

        Log::info("تم تحديث قاعدة البيانات بنجاح.");
        return response()->json(['status' => 'success', 'message' => 'تم تحديث قاعدة البيانات بنجاح.']);
    }
}
