<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // عرض جميع المستخدمين
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // عرض نموذج إنشاء مستخدم
    public function create()
    {
        return view('admin.users.create');
    }

    // حفظ المستخدم الجديد
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'           => 'required|string|unique:users,username',
            'phone'              => 'required|string|unique:users,phone',
            'email'              => 'nullable|email|unique:users,email',
            'password'           => 'required|string|min:6|confirmed',
            'is_admin'           => 'required|boolean',
            'job_title'          => 'nullable|string|max:255',
            'package_name'       => 'nullable|string|max:255',
            'user_mode'          => 'nullable|string|max:50',
            'current_plan'       => 'nullable|string|max:100',
            'plan_start_date'    => 'nullable|date',
            'plan_renewal_date'  => 'nullable|date',
            'profile_image'      => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role'               => 'nullable|string|max:255',
            'status'             => 'nullable|string|max:255',
        ]);

        $data = [
            'username'         => $validated['username'],
            'phone'            => $validated['phone'],
            'email'            => $validated['email'] ?? null,
            'password'         => Hash::make($validated['password']),
            'is_admin'         => $validated['is_admin'],
            'job_title'        => $validated['job_title'] ?? null,
            'package_name'     => $validated['package_name'] ?? null,
            'user_mode'        => $validated['user_mode'] ?? null,
            'current_plan'     => $validated['current_plan'] ?? null,
            'plan_start_date'  => $validated['plan_start_date'] ?? null,
            'plan_renewal_date'=> $validated['plan_renewal_date'] ?? null,
            'role'             => $validated['role'] ?? 'admin',
            'status'           => $validated['status'] ?? 'active',
        ];

        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $request
                ->file('profile_image')
                ->store('avatars', 'public');
        }

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح.');
    }

    // عرض نموذج التعديل
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // تنفيذ التحديث
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'username'           => 'required|string|max:100',
            'phone'              => 'required|string|unique:users,phone,' . $user->id,
            'email'              => 'nullable|email|unique:users,email,' . $user->id,
            'password'           => 'nullable|string|min:6|confirmed',
            'is_admin'           => 'required|boolean',
            'job_title'          => 'nullable|string|max:255',
            'package_name'       => 'nullable|string|max:255',
            'user_mode'          => 'nullable|string|max:50',
            'current_plan'       => 'nullable|string|max:100',
            'plan_start_date'    => 'nullable|date',
            'plan_renewal_date'  => 'nullable|date',
            'profile_image'      => 'nullable|file|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role'               => 'nullable|string|max:255',
            'status'             => 'nullable|string|max:255',
        ]);

        $user->fill([
            'username'         => $validated['username'],
            'phone'            => $validated['phone'],
            'email'            => $validated['email'] ?? null,
            'is_admin'         => $validated['is_admin'],
            'job_title'        => $validated['job_title'] ?? null,
            'package_name'     => $validated['package_name'] ?? null,
            'user_mode'        => $validated['user_mode'] ?? null,
            'current_plan'     => $validated['current_plan'] ?? null,
            'plan_start_date'  => $validated['plan_start_date'] ?? null,
            'plan_renewal_date'=> $validated['plan_renewal_date'] ?? null,
            'role'             => $validated['role'] ?? 'admin',
            'status'           => $validated['status'] ?? 'active',
        ]);

        if ($request->hasFile('profile_image')) {
            $user->profile_image = $request
                ->file('profile_image')
                ->store('avatars', 'public');
        }

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم.');
    }

    // حذف المستخدم
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (auth()->id() == $user->id) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم.');
    }

    // عرض تفاصيل مستخدم
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }
}
