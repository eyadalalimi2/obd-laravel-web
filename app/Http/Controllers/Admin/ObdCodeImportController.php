<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObdCode;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ObdCodeImportController extends Controller
{
    public function showForm()
    {
        return view('admin.obd_codes.import');
    }

    public function validateFile(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json',
        ]);

        $data = json_decode($request->file('json_file')->get(), true);
        if (!is_array($data)) {
            return back()->withErrors(['json_file' => 'الملف ليس JSON صالح'])->withInput();
        }

        $rowErrors = [];
        foreach ($data as $i => $row) {
            $v = Validator::make($row, [
                'code'        => 'required|unique:obd_codes,code',  // أو حسب منطقك
                'title'       => 'required|string',
                'description' => 'required|string',
                // ... باقي الحقول الإلزامية
            ]);
            if ($v->fails()) {
                $rowErrors[$i+1] = $v->errors()->all();
            }
        }

        if ($rowErrors) {
            return back()
                ->withErrors(['json_file' => 'وجدت أخطاء في صفوف JSON'])
                ->with('row_errors', $rowErrors);
        }

        // خزّن البيانات في الجلسة للخطوة القادمة
        session(['obd_import_data' => $data]);

        return view('admin.obd_codes.import_preview', ['data' => $data]);
    }

    public function confirmImport(Request $request)
    {
        $data = session('obd_import_data', []);
        if (!$data) {
            return redirect()->route('admin.obd_codes.import_form')
                             ->withErrors(['json_file' => 'لا توجد بيانات للاستيراد']);
        }

        DB::transaction(function () use ($data) {
            foreach ($data as $row) {
                ObdCode::create([
                    'code'        => $row['code'],
                    'title'       => $row['title'],
                    'description' => $row['description'],
                    'symptoms'    => $row['symptoms'],
                    'causes'      => $row['causes'],
                    // الحقول الجديدة:
                    'category'    => $row['category']    ?? null,
                    'diagnosis'   => $row['diagnosis']   ?? null,
                    'severity'    => $row['severity']    ?? null,
                    'solutions'   => $row['solutions']   ?? null,
                    'status'      => $row['status']      ?? 1,
                    'source_url'  => $row['source_url']  ?? null,
                    'lang'        => $row['lang']        ?? 'en',
                    'image'       => $row['image']       ?? null,
                ]);
            }
        });        

        session()->forget('obd_import_data');

        return redirect()->route('admin.obd_codes.import_form')
                         ->with('success', 'تم استيراد أكواد OBD بنجاح');
    }
}
