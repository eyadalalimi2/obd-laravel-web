<?php

namespace App\Listeners;

use App\Events\SubscriptionExpired;
use App\Models\Notification;

class SendSubscriptionExpiredNotification
{
    public function handle(SubscriptionExpired $event)
    {
        $notif = Notification::create([
            'title'   => 'انتهاء الاشتراك',
            'message' => 'لقد انتهى اشتراكك، يرجى التجديد للاستمرار في استخدام التطبيق.',
            'type'    => 'warning',
            'data'    => json_encode(['user_id' => $event->user->id]),
        ]);

        $notif->users()->attach($event->user->id);
    }
}
