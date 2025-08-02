<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TranslationSiteController extends Controller
{
    public function index()
    {
        $ar = File::exists(lang_path('ar/site.php')) ? include(lang_path('ar/site.php')) : [];
        $en = File::exists(lang_path('en/site.php')) ? include(lang_path('en/site.php')) : [];

        $keys = array_unique(array_merge(array_keys($ar), array_keys($en)));

        return view('admin.translations.site', compact('ar', 'en', 'keys'));
    }

    public function update(Request $request)
    {
        $ar = $request->input('translations.ar', []);
        $en = $request->input('translations.en', []);

        File::put(lang_path('ar/site.php'), '<?php return ' . var_export($ar, true) . ';');
        File::put(lang_path('en/site.php'), '<?php return ' . var_export($en, true) . ';');

        return redirect()->back()->with('success', 'تم حفظ الترجمة بنجاح');
    }
}
