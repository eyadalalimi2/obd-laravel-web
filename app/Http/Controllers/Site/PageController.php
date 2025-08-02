<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show($slug)
{
    $page = Page::where('slug', $slug)
               ->where('language_code', app()->getLocale())
               ->first()
          ?? Page::where('slug', $slug)
               ->where('language_code', 'en')
               ->firstOrFail();

    return view('site.page.show', compact('page'));
}

}
