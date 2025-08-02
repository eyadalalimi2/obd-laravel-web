<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationAdminController extends Controller
{
    protected $langPath = 'views/admin/lang'; // داخل مجلد views


    public function index()
    {
        $ar = $this->loadTranslations('ar');
        $en = $this->loadTranslations('en');

        $keys = collect(array_merge(array_keys($ar), array_keys($en)))->unique();

        return view('admin.translations.index', [
            'keys' => $keys,
            'ar' => $ar,
            'en' => $en,
        ]);
    }


    public function update(Request $request)
    {
        $translations = $request->input('translations');

        foreach (['ar', 'en'] as $lang) {
            $data = $translations[$lang] ?? [];

            $content = "<?php\n\nreturn [\n";
            foreach ($data as $key => $value) {
                $value = str_replace(["\r", "\n"], '', $value);
                $content .= "    '$key' => '" . addslashes($value) . "',\n";
            }
            $content .= "];\n";

            File::put(resource_path("views/admin/lang/{$lang}.php"), $content);
        }

        return back()->with('success', 'تم حفظ التعديلات بنجاح.');
    }


    private function loadTranslations($lang)
    {
        $file = resource_path("views/admin/lang/{$lang}.php");

        return File::exists($file) ? include $file : [];
    }
}
