<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT_URL'),
    ],


    'facebook' => [
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect'      => env('FACEBOOK_REDIRECT_URI'),
    ],
    
    // إعدادات OpenAI للذكاء الاصطناعي
    'openai' => [
        // مفتاح الوصول إلى API، احفظه في ملف .env
        'key'             => env('OPENAI_API_KEY'),
        // نموذج المحادثة
        'model'           => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
        // نموذج الـ embeddings
        'embedding_model' => env('OPENAI_EMBEDDING_MODEL', 'text-embedding-ada-002'),
        // (اختياري) يمكنك إضافة هنا متغيرات أخرى مثل درجة الحرارة
        'temperature'     => (float) env('OPENAI_TEMPERATURE', 0.7),
    ],


];
