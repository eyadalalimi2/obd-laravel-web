<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlanRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::paginate(15);
        return view('admin.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.plans.create');
    }

    public function store(PlanRequest $request)
    {
        Plan::create($request->validated());
        return redirect()->route('admin.plans.index')
                         ->with('success', 'تم إنشاء الباقة بنجاح.');
    }

    public function edit(Plan $plan)
    {
        return view('admin.plans.edit', compact('plan'));
    }

    public function update(PlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());
        return redirect()->route('admin.plans.index')
                         ->with('success', 'تم تحديث بيانات الباقة.');
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return redirect()->route('admin.plans.index')
                         ->with('success', 'تم حذف الباقة.');
    }
}
