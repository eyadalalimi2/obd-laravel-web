<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppKey;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AppKeyController extends Controller
{
    public function index()
    {
        $keys = AppKey::latest()->paginate(20);
        return view('admin.app_keys.index', compact('keys'));
    }

    public function create()
    {
        return view('admin.app_keys.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'package_name' => 'required|string|unique:app_keys,package_name',
            'version_code' => 'required|string',
        ]);

        $key = base64_encode(Str::random(32));

        AppKey::create([
            'package_name' => $request->package_name,
            'version_code' => $request->version_code,
            'encryption_key' => $key,
            'expires_at' => now()->addYears(5),
        ]);

        return redirect()->route('admin.app_keys.index')->with('success', 'تم إنشاء المفتاح بنجاح.');
    }

    public function destroy(AppKey $appKey)
    {
        $appKey->delete();
        return back()->with('success', 'تم حذف المفتاح بنجاح.');
    }
}
