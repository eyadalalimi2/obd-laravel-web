<?php

namespace App\Listeners;

use App\Events\CodeCreated;
use App\Models\Notification;
use App\Models\User;

class SendCodeCreatedNotification
{
    public function handle(CodeCreated $event)
    {
        $notif = Notification::create([
            'title'   => 'تمت إضافة كود جديد',
            'message' => 'تمت إضافة الكود: ' . $event->code->code,
            'type'    => 'info',
            'data'    => json_encode(['code_id' => $event->code->id]),
        ]);

        $userIds = User::pluck('id')->toArray();

        $notif->users()->attach($userIds);
    }
}
