<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JsonTranslationValidatorController extends Controller
{
    public function showForm()
    {
        return view('admin.translations.json-validator');
    }

    public function validateJson(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json'
        ]);

        $content = file_get_contents($request->file('json_file')->getRealPath());
        $decoded = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE || !is_array($decoded)) {
            return back()->withErrors(['الملف ليس بتنسيق JSON صالح.']);
        }

        $errors = [];
        foreach ($decoded as $index => $entry) {
            if (!isset($entry['id'], $entry['obd_code_id'], $entry['language_code'], $entry['title'], $entry['description'])) {
                $errors[] = "السطر $index غير مكتمل أو به أخطاء.";
            }
        }

        if (!empty($errors)) {
            return back()->withErrors($errors);
        }

        return back()->with('success', 'الملف صالح وجاهز للاستيراد.');
    }
}
