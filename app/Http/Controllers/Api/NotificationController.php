<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserNotificationResource;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * استرجاع إشعارات المستخدم
     */
    public function index()
    {
        $userId = Auth::id();

        $items = UserNotification::with('notification')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return UserNotificationResource::collection($items);
    }

    /**
     * تعيين إشعار كمقروء
     */
    public function markAsRead($id)
    {
        $userId = Auth::id();

        $item = UserNotification::where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $item->read_at = now();
        $item->save();

        return response()->json(['message' => 'Notification marked as read.']);
    }

    /**
     * حذف إشعار من حساب المستخدم
     */
    public function destroy($id)
    {
        $userId = Auth::id();

        $item = UserNotification::where('user_id', $userId)
            ->where('id', $id)
            ->firstOrFail();

        $item->delete();

        return response()->json(['message' => 'Notification deleted successfully.']);
    }
}
