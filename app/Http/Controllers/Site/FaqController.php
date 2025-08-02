<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index()
{
    $faqs = Faq::where('language_code', app()->getLocale())
              ->orWhere('language_code', 'en')
              ->get();

    return view('site.faq.index', compact('faqs'));
}

}
