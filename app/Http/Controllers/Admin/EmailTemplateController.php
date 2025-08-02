<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateTranslation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class EmailTemplateController extends Controller
{
    /**
     * عرض قائمة القوالب مع كافة الترجمات
     */
    public function index()
    {
        $templates = EmailTemplate::with('translations')->paginate(15);
        $locales   = config('locales.supported');
        return view('admin.email_templates.index', compact('templates', 'locales'));
    }

    /**
     * إظهار نموذج إنشاء قالب جديد
     */
    public function create()
    {
        $locales = config('locales.supported');
        return view('admin.email_templates.create', compact('locales'));
    }

    /**
     * حفظ قالب جديد (المفتاح Key + ترجمة افتراضية للغة التطبيق)
     */
    public function store(Request $request)
    {
        // 1) تحقق من المدخلات
        $data = $request->validate([
            'key'          => 'required|string|max:100|unique:email_templates,key',
            'locale'       => 'required|string|size:2',
            'subject'      => 'required|string|max:191',
            'body'         => 'required|string',
            'placeholders' => 'nullable|array',
        ]);

        // 2) أنشئ القالب الأساسي مع subject و body
        $template = EmailTemplate::create([
            'key'          => $data['key'],
            'subject'      => $data['subject'],      // هنا ضمننا ملء العمود
            'body'         => $data['body'],         // وهنا أيضا
            'placeholders' => $data['placeholders'] ?? [],
        ]);

        // 3) أنشئ الترجمة الافتراضية في جدول الترجمة
        $template->translations()->create([
            'locale'       => $data['locale'],
            'subject'      => $data['subject'],
            'body'         => $data['body'],
            'placeholders' => $data['placeholders'] ?? [],
        ]);

        return redirect()
            ->route('admin.email_templates.index')
            ->with('success', 'تم إنشاء القالب بنجاح.');
    }
    /**
     * معاينة قالب ولغة معينة
     */
    public function show(EmailTemplate $template, Request $request)
{
    $locales = config('locales.supported');
    $locale = $request->query('locale', app()->getLocale());
    $translation = $template->translations->firstWhere('locale', $locale)
                   ?? abort(404, "لا توجد ترجمة للغة {$locale}");
    return view('admin.email_templates.show', compact('template','translation','locale','locales'));
}


    /**
     * إظهار نموذج تعديل القالب نفسه (Key + placeholders)
     */
    public function edit(EmailTemplate $template)
    {
        // خريطة المتغيرات الكاملة
        $map = config('email_placeholders');

        // المتغيرات الخاصة بالقالب الحالي
        $allPlaceholders = $map[$template->key] ?? [];

        return view('admin.email_templates.edit', compact('template', 'allPlaceholders'));
    }

    /**
     * تحديث مفتاح القالب أو placeholders
     */
    public function update(Request $request, EmailTemplate $template)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:191',
            'body'         => 'required|string',
            'placeholders' => 'nullable|array',
        ]);

        // حدِّث الجدول الأساسي
        $template->update([
            'subject'      => $data['subject'],
            'body'         => $data['body'],
            'placeholders' => $data['placeholders'] ?? [],
        ]);

        // (اختياري) حدِّث الترجمة الافتراضية أيضاً
        $locale = app()->getLocale();
        $template->translations()->updateOrCreate(
            ['locale' => $locale],
            [
                'subject'      => $data['subject'],
                'body'         => $data['body'],
                'placeholders' => $data['placeholders'] ?? [],
            ]
        );

        return back()->with('success', 'تم تحديث القالب بنجاح.');
    }

    /**
     * حذف القالب وكل الترجمات المرتبطة به
     */
    public function destroy(EmailTemplate $template)
    {
        $template->delete();
        return redirect()
            ->route('admin.email_templates.index')
            ->with('success', 'تم حذف القالب نهائيًا.');
    }

    /**
     * إرسال رسالة تجريبية للقالب إلى البريد الشخصي
     */
    public function sendTest(EmailTemplate $template)
    {
        $translation = $template->translation();

        Mail::raw($translation->body, function ($m) use ($translation) {
            // استخدم عنواناً موثوقاً (مطابق لـ MAIL_FROM_ADDRESS)
            $m->from(config('mail.from.address'), config('mail.from.name'));
            $m->to(auth()->user()->email);
            $m->subject('[TEST] ' . $translation->subject);
        });

        return back()->with('success', 'تم إرسال رسالة تجريبية إلى بريدك.');
    }
    /**
     * إظهار نموذج تحرير ترجمة لغة محددة
     */
    public function editTranslation(EmailTemplate $template, $locale)
    {
        $translation = EmailTemplateTranslation::firstOrNew([
            'email_template_id' => $template->id,
            'locale'            => $locale,
        ]);

        return view('admin.email_templates.translation', compact('template', 'translation', 'locale'));
    }

    /**
     * حفظ أو تحديث ترجمة اللغة
     */
    public function updateTranslation(Request $request, EmailTemplate $template, $locale)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:191',
            'body'         => 'required|string',
            'placeholders' => 'nullable|array',
        ]);

        $template->translations()->updateOrCreate(
            ['locale' => $locale],
            [
                'subject'      => $data['subject'],
                'body'         => $data['body'],
                'placeholders' => $data['placeholders'] ?? [],
            ]
        );

        return redirect()
            ->route('admin.email_templates.index')
            ->with('success', "تم حفظ الترجمة ($locale) بنجاح.");
    }
}
