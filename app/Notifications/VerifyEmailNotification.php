<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Mail\GenericTemplateMail;
use App\Services\EmailTemplateService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;

class VerifyEmailNotification extends Notification
{
    public function via($notifiable) { return ['mail']; }
public function toMail($notifiable)
{
     // 1) هذا يولّد رابط كامل http(s)://obdcodehub.com/email/verify/...
    $activationLink = URL::temporarySignedRoute(
        'verification.show',
        now()->addMinutes(60),
        [
          'id'   => $notifiable->id,
          'hash' => sha1($notifiable->email),
        ]
    );

    // 4. جهّز الـ subject و الـ body عبر خدمتك
    $render = EmailTemplateService::render('account_activation', [
        'user_name'       => $notifiable->username,
        'activation_link' => $activationLink,
    ]);

    // 5. أرسل الـ Mailable مع ضبط المستلم
    return (new GenericTemplateMail($render['subject'], $render['body']))
                ->to($notifiable->email);
}

}
