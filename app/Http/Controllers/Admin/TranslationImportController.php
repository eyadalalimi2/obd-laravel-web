<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObdCodeTranslation;
use Illuminate\Support\Facades\Validator;

class TranslationImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.translations.import');
    }

    public function validateJson(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:json,txt',
        ]);

        $data = json_decode(file_get_contents($request->file('file')), true);

        if (!is_array($data)) {
            return back()->withErrors(['file' => 'الملف غير صالح أو لا يحتوي على بيانات JSON.']);
        }

        $errors = [];
        foreach ($data as $index => $item) {
            $validator = Validator::make($item, [
                'obd_code_id'  => 'required|integer|exists:obd_codes,id',
                'language_code'=> 'required|string',
                'title'        => 'required|string',
                'description'  => 'nullable|string',
                'symptoms'     => 'nullable|string',
                'causes'       => 'nullable|string',
                'solutions'    => 'nullable|string',
                'severity'     => 'nullable|string',
                'diagnosis'    => 'nullable|string',
                'category'     => 'nullable|string',
                'source_url'   => 'nullable|string',
            ]);

            if ($validator->fails()) {
                $errors[$index + 1] = $validator->errors()->all();
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['file' => 'تم العثور على أخطاء في الملف.'])->with('validation_errors', $errors);
        }

        // Store validated data in session for processing
        session(['validated_translations' => $data]);

        return back()->with('success', 'تم التحقق من الملف بنجاح. يمكنك الآن استيراده.');
    }

    public function processImport()
    {
        $data = session('validated_translations', []);

        foreach ($data as $item) {
            ObdCodeTranslation::updateOrCreate(
                ['obd_code_id' => $item['obd_code_id'], 'language_code' => $item['language_code']],
                $item
            );
        }

        session()->forget('validated_translations');

        return redirect()->route('admin.translations.import')->with('success', 'تم استيراد الترجمات بنجاح.');
    }
}
