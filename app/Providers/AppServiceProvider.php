<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\Services\MailSettingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // يمكنك تسجيل الـ bindings هنا إذا لزم الأمر
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // جلب إعدادات البريد من الخدمة
        $svc = app(MailSettingService::class);

        // استخدم القيم من قاعدة البيانات أو القيم الافتراضية من .env
        $host = $svc->get('host') ?? env('MAIL_HOST');
        $port = (int) ($svc->get('port') ?? env('MAIL_PORT', 587));
        $username = $svc->get('username') ?? env('MAIL_USERNAME');
        $password = $svc->get('password') ?? env('MAIL_PASSWORD');
        $encryption = $svc->get('encryption') ?? env('MAIL_ENCRYPTION', 'tls');
        $fromAddress = $svc->get('from_address') ?? env('MAIL_FROM_ADDRESS');
        $fromName = $svc->get('from_name') ?? env('MAIL_FROM_NAME');
        $mailer = $svc->get('mailer') ?? env('MAIL_MAILER', 'smtp');

        // تطبيق الإعدادات الديناميكية
        Config::set('mail.default', $mailer);
        Config::set('mail.mailers.smtp.host', $host);
        Config::set('mail.mailers.smtp.port', $port);
        Config::set('mail.mailers.smtp.username', $username);
        Config::set('mail.mailers.smtp.password', $password);
        Config::set('mail.mailers.smtp.encryption', $encryption);
        Config::set('mail.from.address', $fromAddress);
        Config::set('mail.from.name', $fromName);
    }
}