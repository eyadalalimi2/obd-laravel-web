<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::with('users')->latest()->get();
        $users         = User::orderBy('username')->get();
        $types         = [
            'info'    => ['label'=>'معلومات','color'=>'#17a2b8'],
            'warning' => ['label'=>'تحذير','color'=>'#ffc107'],
            'error'   => ['label'=>'خطأ','color'=>'#dc3545'],
        ];

        return view('admin.notifications.index', compact('notifications','users','types'));
    }

    public function create()
    {
        $users = User::orderBy('username')->get();
        $types = [
            'info'    => ['label'=>'معلومات','color'=>'#17a2b8'],
            'warning' => ['label'=>'تحذير','color'=>'#ffc107'],
            'error'   => ['label'=>'خطأ','color'=>'#dc3545'],
        ];

        return view('admin.notifications.create', compact('users','types'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'message'     => 'required|string',
            'type'        => 'nullable|string|max:50',
            'data'        => 'nullable|json',
            'send_to_all' => 'nullable|boolean',
            'users'       => 'required_without:send_to_all|array',
            'users.*'     => 'exists:users,id',
        ]);

        $notification = Notification::create([
            'title'   => $data['title'],
            'message' => $data['message'],
            'type'    => $data['type'] ?? null,
            'data'    => $data['data'] ?? null,
        ]);

        if ($request->boolean('send_to_all')) {
            $ids = User::pluck('id')->toArray();
        } else {
            $ids = $data['users'];
        }

        // ربط بالمستخدمين
        $notification->users()->attach($ids);

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'تم إنشاء الإشعار بنجاح');
    }

    /**
     * حذف إشعار بالكامل (مع pivot تلقائيًا بسبب CASCADE)
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with('success', 'تم حذف الإشعار بنجاح');
    }
}
