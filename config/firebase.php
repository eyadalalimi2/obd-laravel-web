<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Firebase project
    |--------------------------------------------------------------------------
    |
    | اختر هنا اسم المشروع الافتراضي (يطابق أحد مفاتيح المصفوفة projects أدناه)
    |
    */
    'default' => env('FIREBASE_PROJECT', 'app'),

    /*
    |--------------------------------------------------------------------------
    | Firebase project configurations
    |--------------------------------------------------------------------------
    |
    | يمكنك تعريف أكثر من مشروع هنا، ولكل مشروع بيانات اعتماده، URL قاعدة البيانات،
    | معلومات التخزين، إلخ.
    |
    */
    'projects' => [

        'app' => [

            /*
            |--------------------------------------------------------------------------
            | Credentials / Service Account
            |--------------------------------------------------------------------------
            |
            | مسار ملف Service Account JSON، مثال:
            | FIREBASE_CREDENTIALS="/full/path/to/obd-code-hub-service-account.json"
            |
            */
            'credentials' => env('FIREBASE_CREDENTIALS', env('GOOGLE_APPLICATION_CREDENTIALS')),

            /*
            |--------------------------------------------------------------------------
            | Firebase Auth component
            |--------------------------------------------------------------------------
            |
            | إذا كنت تستخدم Authentication multi-tenancy:
            |
            */
            'auth' => [
                'tenant_id' => env('FIREBASE_AUTH_TENANT_ID', null),
            ],

            /*
            |--------------------------------------------------------------------------
            | Firestore (إن كنت تستخدم Firestore)
            |--------------------------------------------------------------------------
            |
            */
//          'firestore' => [
//              // 'database' => env('FIREBASE_FIRESTORE_DATABASE', '(default)'),
//          ],

            /*
            |--------------------------------------------------------------------------
            | Realtime Database
            |--------------------------------------------------------------------------
            |
            | URL الخاص بقاعدة البيانات اللحظية (Realtime DB)، مثال:
            | FIREBASE_DATABASE_URL="https://obd-code-hub.firebaseio.com"
            |
            */
            'database' => [
                'url' => env('FIREBASE_DATABASE_URL', null),
            ],

            /*
            |--------------------------------------------------------------------------
            | Firebase Dynamic Links
            |--------------------------------------------------------------------------
            |
            */
            'dynamic_links' => [
                'default_domain' => env('FIREBASE_DYNAMIC_LINKS_DEFAULT_DOMAIN', null),
            ],

            /*
            |--------------------------------------------------------------------------
            | Firebase Cloud Storage
            |--------------------------------------------------------------------------
            |
            | اسم الـ bucket، مثال:
            | FIREBASE_STORAGE_DEFAULT_BUCKET="obd-code-hub.appspot.com"
            |
            */
            'storage' => [
                'default_bucket' => env('FIREBASE_STORAGE_DEFAULT_BUCKET', null),
            ],

            /*
            |--------------------------------------------------------------------------
            | Caching
            |--------------------------------------------------------------------------
            |
            | يستخدم الكاش لتخزين مفاتيح التحقق (ID token keys)، الافتراضي file.
            |
            */
            'cache_store' => env('FIREBASE_CACHE_STORE', 'file'),

            /*
            |--------------------------------------------------------------------------
            | HTTP Logging (اختياري)
            |--------------------------------------------------------------------------
            |
            | لتتبع طلبات HTTP المرسلة إلى Firebase.
            |
            */
            'logging' => [
                'http_log_channel'       => env('FIREBASE_HTTP_LOG_CHANNEL', null),
                'http_debug_log_channel' => env('FIREBASE_HTTP_DEBUG_LOG_CHANNEL', null),
            ],

            /*
            |--------------------------------------------------------------------------
            | HTTP Client Options
            |--------------------------------------------------------------------------
            |
            | يمكنك ضبط Proxy أو مهلة الاتصال هنا.
            |
            */
            'http_client_options' => [
                'proxy'           => env('FIREBASE_HTTP_CLIENT_PROXY', null),
                'timeout'         => env('FIREBASE_HTTP_CLIENT_TIMEOUT', 30.0),
                'guzzle_middlewares' => [],
            ],

        ],

        // يمكنك إضافة مشاريع أخرى هنا...
    ],

];
