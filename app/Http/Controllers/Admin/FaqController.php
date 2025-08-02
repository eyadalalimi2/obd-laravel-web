<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('admin.faqs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        Faq::create($request->only(['question', 'answer', 'category']));

        return redirect()->route('admin.faqs.index')->with('success', 'تم إضافة السؤال بنجاح.');
    }

    public function edit(Faq $faq)
    {
        return view('admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer'   => 'required|string',
            'category' => 'nullable|string|max:100',
        ]);

        $faq->update($request->only(['question', 'answer', 'category']));

        return redirect()->route('admin.faqs.index')->with('success', 'تم تحديث السؤال بنجاح.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'تم حذف السؤال بنجاح.');
    }
}
