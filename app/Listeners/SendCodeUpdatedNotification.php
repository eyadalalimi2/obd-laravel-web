<?php

namespace App\Listeners;

use App\Events\CodeUpdated;
use App\Models\Notification;
use App\Models\User;

class SendCodeUpdatedNotification
{
    public function handle(CodeUpdated $event)
    {
        $notif = Notification::create([
            'title'   => 'تم تحديث كود',
            'message' => 'تم تحديث الكود: ' . $event->code->code,
            'type'    => 'info',
            'data'    => json_encode(['code_id' => $event->code->id]),
        ]);

        $userIds = User::pluck('id')->toArray();

        $notif->users()->attach($userIds);
    }
}
