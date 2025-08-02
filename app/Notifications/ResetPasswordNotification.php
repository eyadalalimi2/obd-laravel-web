<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use App\Mail\GenericTemplateMail;
use App\Services\EmailTemplateService;

class ResetPasswordNotification extends Notification
{
    public function __construct(public string $token) {}

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // بناء رابط إعادة الضبط
        $frontend = config('app.frontend_url');
        $link = config('app.frontend_url')
            . "/reset-password?token={$this->token}&email=" . urlencode($notifiable->email);

        // تجهيز الموضوع والمحتوى
        $render = EmailTemplateService::render('password_reset', [
            'user_name'  => $notifiable->username,
            'reset_link' => $link,
        ]);

        // أنشئ المرسل
        $mailable = new GenericTemplateMail($render['subject'], $render['body']);

        // اضبط عنوان “To” يدوياً
        $mailable->to($notifiable->getEmailForPasswordReset(), $notifiable->username);

        return $mailable;
    }
}
