<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\EmailTemplateTranslation;
use Illuminate\Http\Request;

class EmailTemplateTranslationController extends Controller
{
    /**
     * إظهار نموذج تعديل/إنشاء ترجمة للقالب بلغة محددة.
     *
     * @param  int    $templateId
     * @param  string $locale
     * @return \Illuminate\View\View
     */
    public function edit(int $templateId, string $locale)
    {
        $template    = EmailTemplate::findOrFail($templateId);
        $translation = EmailTemplateTranslation::firstOrNew([
            'email_template_id' => $template->id,
            'locale'            => $locale,
        ]);

        return view('admin.email_templates.translation', [
            'template'    => $template,
            'translation' => $translation,
            'locale'      => $locale,
        ]);
    }

    /**
     * حفظ أو تحديث ترجمة القالب للغة معينة.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $templateId
     * @param  string                   $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, int $templateId, string $locale)
    {
        $data = $request->validate([
            'subject'      => 'required|string|max:191',
            'body'         => 'required|string',
            'placeholders' => 'nullable|array',
        ]);

        $template = EmailTemplate::findOrFail($templateId);

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
            ->with('success', "تم حفظ الترجمة ({$locale}) بنجاح.");
    }

    /**
     * حذف ترجمة لغة معينة (اختياري).
     *
     * @param  int    $templateId
     * @param  string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $templateId, string $locale)
    {
        $translation = EmailTemplateTranslation::where([
            ['email_template_id', $templateId],
            ['locale',            $locale],
        ])->firstOrFail();

        $translation->delete();

        return back()->with('success', "تم حذف ترجمة ({$locale}).");
    }
}