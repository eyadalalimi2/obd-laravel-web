<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ObdCode;
use App\Models\Language;
use App\Models\ObdCodeTranslation;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Events\CodeCreated;
use App\Events\CodeUpdated;
use App\Models\Brand;



class ObdCodeController extends Controller
{
    public function index(Request $request)
    {
        $query = ObdCode::query();

        if ($request->has('language') && $request->language) {
            $language = $request->language;
            $query->whereHas('translations', function ($q) use ($language) {
                $q->where('language_code', $language);
            });
        }

        $obdCodes = $query->paginate(10);

        $languages = Language::where('is_active', 1)->get();

        return view('admin.obd_codes.index', compact('obdCodes', 'languages'));
    }


    public function create()
    {
        // جلب كل العلامات من القاعدة
        $brands = Brand::orderBy('name')->get();

        // تمرير المتغيّرات إلى الواجهة
        return view('admin.obd_codes.create', compact('brands'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:255|unique:obd_codes,code',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'causes' => 'nullable|string',
            'solutions' => 'nullable|string',
            'severity' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'category' => 'nullable|string',
            'source_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('obd_images', 'public');
        }

        $obdCode = ObdCode::create($data);

        // إطلاق الحدث
        event(new CodeCreated($obdCode));

        return redirect()->route('admin.obd_codes.index')->with('success', 'تمت إضافة الكود بنجاح');
    }


    public function show(ObdCode $obdCode)
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.obd_codes.show', compact('obdCode', 'brands'));
    }

    public function edit(ObdCode $obdCode)
    {
        $brands = Brand::orderBy('name')->get();
        return view('admin.obd_codes.edit', compact('obdCode', 'brands'));
    }

    public function update(Request $request, ObdCode $obdCode)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'symptoms' => 'nullable|string',
            'causes' => 'nullable|string',
            'solutions' => 'nullable|string',
            'severity' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'category' => 'nullable|string',
            'source_url' => 'nullable|url',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('obd_images', 'public');
        }

        $obdCode->update($data);

        // إطلاق الحدث
        event(new CodeUpdated($obdCode));

        return redirect()->route('admin.obd_codes.index')->with('success', 'تم تحديث الكود بنجاح');
    }


    public function destroy(ObdCode $obdCode)
    {
        $obdCode->delete();
        return back()->with('success', 'تم حذف الكود بنجاح');
    }


    // التحقق من الملف
    public function showImportForm()
    {
        return view('admin.obd_codes.import');
    }

    // 2. تحقق من JSON وعرض المعاينة
    public function validateImport(Request $request)
    {
        $request->validate([
            'json_file' => 'required|file|mimes:json',
        ]);

        $json = file_get_contents($request->file('json_file')->getRealPath());
        $data = json_decode($json, true);
        if (!is_array($data)) {
            return back()
                ->withErrors(['json_file' => 'الملف غير صالح أو ليس مصفوفة JSON'])
                ->withInput();
        }

        // أبني مجموعة الأخطاء لكل صف
        $errors = [];
        foreach ($data as $i => $row) {
            $v = Validator::make($row, [
                'code'        => 'required|string|max:10|unique:obd_codes,code',
                'title'       => 'required|string',
                'description' => 'required|string',
                'symptoms'    => 'nullable|string',
                'causes'      => 'nullable|string',
                'solutions'   => 'nullable|string',
                'diagnosis'   => 'nullable|string',
            ]);
            if ($v->fails()) {
                $errors[$i] = $v->errors()->all();
            }
        }

        if (!empty($errors)) {
            return back()
                ->withErrors(['json_file' => 'وجدت أخطاء في بعض الصفوف'])
                ->with('row_errors', $errors);
        }

        // خزن البيانات مؤقتاً في الجلسة للمعاينة
        session(['obd_import_data' => $data]);

        return view('admin.obd_codes.import_preview', compact('data'));
    }

    // 3. تأكيد الاستيراد
    public function import(Request $request)
    {
        $data = session('obd_import_data', []);
        if (empty($data)) {
            return redirect()->route('admin.obd_codes.import.form')
                ->withErrors(['json_file' => 'لا توجد بيانات للاستيراد.']);
        }

        DB::transaction(function () use ($data) {
            foreach ($data as $row) {
                ObdCode::create([
                    'code'        => $row['code'],
                    'title'       => $row['title'],
                    'description' => $row['description'],
                    'symptoms'    => $row['symptoms'] ?? null,
                    'causes'      => $row['causes'] ?? null,
                    'solutions'   => $row['solutions'] ?? null,
                    'diagnosis'   => $row['diagnosis'] ?? null,
                ]);
            }
        });

        // نظف الجلسة
        session()->forget('obd_import_data');

        return redirect()->route('admin.obd_codes.import.form')
            ->with('success', 'تم استيراد الأكواد بنجاح.');
    }
    /**
     * تبديل حالة التفعيل/التعطيل لكود OBD
     *
     * @param  \App\Models\ObdCode  $obdCode
     * @return \Illuminate\Http\RedirectResponse
     */
    public function toggleStatus(\App\Models\ObdCode $obdCode)
    {
        // قلب القيمة
        $obdCode->status = ! $obdCode->status;
        $obdCode->save();

        // رسالة نجاح
        return back()->with('success', 'تم تحديث حالة الكود بنجاح.');
    }
}
