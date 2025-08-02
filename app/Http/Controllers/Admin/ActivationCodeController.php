<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActivationCodeRequest;
use App\Models\ActivationCode;
use App\Models\Plan;
use Illuminate\Http\Request;

class ActivationCodeController extends Controller
{
    public function index()
    {
        $codes = ActivationCode::with('plan')->paginate(15);
        return view('admin.activation_codes.index', compact('codes'));
    }

    public function create()
    {
        $plans = Plan::where('is_active', true)->get();
        return view('admin.activation_codes.create', compact('plans'));
    }

    public function store(ActivationCodeRequest $request)
    {
        ActivationCode::create($request->validated());
        return redirect()->route('admin.activation_codes.index')
                         ->with('success', 'تم توليد الرمز بنجاح.');
    }

    public function edit(ActivationCode $activationCode)
    {
        $plans = Plan::where('is_active', true)->get();
        return view('admin.activation_codes.edit', compact('activationCode','plans'));
    }

    public function update(ActivationCodeRequest $request, ActivationCode $activationCode)
    {
        $activationCode->update($request->validated());
        return redirect()->route('admin.activation_codes.index')
                         ->with('success', 'تم تحديث بيانات الرمز.');
    }

    public function destroy(ActivationCode $activationCode)
    {
        $activationCode->delete();
        return redirect()->route('admin.activation_codes.index')
                         ->with('success', 'تم حذف الرمز.');
    }
}
