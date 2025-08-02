<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\ObdCode;
use App\Models\ObdCodeTranslation;
use Illuminate\Support\Facades\Storage;

class LanguageController extends Controller
{
    public function index()
    {
        $languages = Language::all()->map(function ($language) {
            $translatedCount = ObdCodeTranslation::where('language_code', $language->code)->count();
            $totalCodes = ObdCode::count();
            $language->translated_count = $translatedCount;
            $language->untranslated_count = $totalCodes - $translatedCount;
            return $language;
        });

        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:10|unique:languages,code',
        ]);

        Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => 1,
        ]);

        return redirect()->route('admin.languages.index')->with('success', 'تمت إضافة اللغة بنجاح.');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'code' => 'required|string|unique:languages,code,' . $id,
        ]);

        $language = Language::findOrFail($id);
        $language->name = $request->name;
        $language->code = $request->code;
        $language->save();

        return redirect()->route('admin.languages.index')->with('success', 'تم تحديث اللغة بنجاح.');
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();

        return redirect()->route('admin.languages.index')->with('success', 'تم حذف اللغة بنجاح.');
    }

    public function show($id)
    {
        $language = Language::findOrFail($id);
        $translations = ObdCodeTranslation::where('language_code', $language->code)->get();
        return view('admin.languages.show', compact('language', 'translations'));
    }

    public function toggleStatus($id)
    {
        $language = Language::findOrFail($id);
        $language->is_active = !$language->is_active;
        $language->save();

        return redirect()->route('admin.languages.index')->with('success', 'تم تحديث حالة اللغة.');
    }

    public function showImportForm($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.languages.import', compact('language'));
    }

    public function importJson(Request $request, $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'json_file' => 'required|mimes:json',
        ]);

        $jsonContent = file_get_contents($request->file('json_file')->getRealPath());
        $data = json_decode($jsonContent, true);

        if (!$data) {
            return back()->withErrors(['الملف غير صالح أو التنسيق غير صحيح.']);
        }

        foreach ($data as $entry) {
            if (empty($entry['code'])) continue;

            $obdCode = ObdCode::where('code', $entry['code'])->first();
            if (!$obdCode) continue;

            $obdCode->translations()->updateOrCreate(
                ['language_code' => $language->code],
                [
                    'title'       => $entry['title'] ?? '',
                    'description' => $entry['description'] ?? '',
                    'symptoms'    => $entry['symptoms'] ?? '',
                    'causes'      => $entry['causes'] ?? '',
                    'solutions'   => $entry['solutions'] ?? '',
                    'severity'    => $entry['severity'] ?? '',
                    'diagnosis'   => $entry['diagnosis'] ?? '',
                    'category'    => $entry['category'] ?? '',
                ]
            );
        }

        return back()->with('success', 'تم استيراد الترجمة بنجاح.');
    }
    public function importJsonForm($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.languages.import', compact('language'));
    }
    
    public function importForm($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.languages.import', compact('language'));
    }

    public function exportJson($id)
    {
        $language = Language::findOrFail($id);
        $translations = $language->translations;

        if ($translations->isEmpty()) {
            return back()->with('error', 'لا توجد ترجمات متاحة لهذه اللغة.');
        }

        $exportData = $translations->map(function ($translation) {
            return [
                'obd_code_id'  => $translation->obd_code_id,
                'language_code'=> $translation->language_code,
                'title'        => $translation->title,
                'description'  => $translation->description,
                'symptoms'     => $translation->symptoms,
                'causes'       => $translation->causes,
                'solutions'    => $translation->solutions,
                'diagnosis'    => $translation->diagnosis,
            ];
        })->toArray();

        $fileName = 'translations_' . $language->code . '.json';
        Storage::disk('local')->put($fileName, json_encode($exportData, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));

        return response()->download(storage_path('app/' . $fileName))->deleteFileAfterSend(true);
    }

    public function showTranslations($languageId)
    {
        $language = Language::findOrFail($languageId);
        $translations = ObdCodeTranslation::where('language_code', $language->code)
            ->with('obdCode')
            ->paginate(20);

        return view('admin.languages.translations', compact('language', 'translations'));
    }
    public function viewTranslations($id)
    {
        $language = Language::findOrFail($id);
        $translations = $language->translations()->paginate(20);

        return view('admin.languages.translations', compact('language', 'translations'));
    }
}