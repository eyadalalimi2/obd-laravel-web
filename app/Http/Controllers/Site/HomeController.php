<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
{
    $settings = Setting::pluck('value', 'key')->toArray();

    return view('site.home.index', [
        'site_name' => $settings['site_name'] ?? 'OBD Codes',
        'site_description' => $settings['site_description'] ?? 'Discover comprehensive information about car fault codes.',
        'site_logo' => $settings['site_logo'] ?? null,
    ]);
}

}
