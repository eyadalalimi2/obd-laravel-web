<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ObdCodeController;
use App\Http\Controllers\Api\SavedCodeController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\OfflineDataController;
use App\Http\Controllers\Api\PlanController;
use App\Http\Controllers\Api\AiChatController;
use App\Http\Controllers\Api\UserCarController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\ModelController;
use App\Http\Controllers\Api\AppKeyController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\FirebaseAuthController;
// Authentication
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
Route::post('password/forgot', [AuthController::class, 'forgotPassword']);
Route::post('password/reset',  [AuthController::class, 'resetPassword']);
Route::post('auth/google', [AuthController::class, 'googleLogin']);
Route::post('/firebase-auth', [AuthController::class, 'firebaseAuthenticate']);
Route::post('/firebase-auth', [FirebaseAuthController::class, 'authenticate']);

// محميّات المصادقة
Route::middleware('auth:sanctum')->group(function () {
    // OBD Codes
    Route::get('codes/trending', [ObdCodeController::class, 'trending']);
    Route::get('codes/{id}/translations/{language_code}', [ObdCodeController::class, 'translation']);
    Route::get('codes/{id}/compare/{other_id}', [ObdCodeController::class, 'compare']);
    Route::get('codes/symptoms/{symptom}', [ObdCodeController::class, 'searchBySymptom']);
    Route::get('codes/{code}', [ObdCodeController::class, 'showByCode']);

    // Saved Codes
    Route::get('user/saved', [SavedCodeController::class, 'index']);
    Route::post('user/saved', [SavedCodeController::class, 'store']);
    Route::delete('user/saved/{id}', [SavedCodeController::class, 'destroy']);

    // Notifications & Settings
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy']);
    Route::get('settings', [SettingController::class, 'index']);

    Route::get('/user/profile', [AuthController::class, 'profile']);
    // تحديث البيانات النصية
    Route::post('user/profile/update', [AuthController::class, 'updateProfileData']);

    // تحديث صورة البروفايل فقط
    Route::post('user/profile/update_image', [AuthController::class, 'updateProfileAvatar']);

    // Offline Data
    Route::get('codes/offline/{language_code}', [OfflineDataController::class, 'index']);

    // سيارات المستخدم

    Route::get('user/cars', [UserCarController::class, 'index']);
    Route::post('user/cars', [UserCarController::class, 'store']);
    Route::put('user/cars/{id}', [UserCarController::class, 'update']);
    Route::delete('user/cars/{id}', [UserCarController::class, 'destroy']);
});


// تسجيل الخروج (يجري إبطال التوكن الحالي)
Route::post('logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// حذف حساب المستخدم
Route::delete('user/profile/delete', [AuthController::class, 'destroy'])
    ->middleware('auth:sanctum');

// -- مسارات الخطط (Public) --
Route::get('plans', [PlanController::class, 'index'])
    ->name('api.plans.index');

Route::get('plans/{plan}', [PlanController::class, 'show'])
    ->name('api.plans.show');

// -- مسارات محميّة للمستخدم (Auth) --
Route::middleware('auth:sanctum')->group(function () {
    // حالة الاشتراك الحالي للمستخدم
    Route::get('subscription/status', [SubscriptionController::class, 'status'])
        ->name('api.subscription.status');

    // تفعيل باقة عبر رمز
    Route::post('activate-code', [SubscriptionController::class, 'activateByCode'])
        ->name('api.subscription.activate_code');

    // شراء باقة عبر توكن الدفع
    Route::post('subscribe', [SubscriptionController::class, 'subscribe'])
        ->name('api.subscription.subscribe');
    Route::post('subscription/renew', [SubscriptionController::class, 'renew'])
        ->name('api.subscription.renew');

    Route::post('subscription/cancel', [SubscriptionController::class, 'cancel'])
        ->name('api.subscription.cancel');
});

// مسار استدعاء مساعد الذكاء الاصطناعي
Route::middleware('auth:sanctum')
    ->post('ai/chat', [AiChatController::class, 'interact']);
// قائمة الشركات (brands)
Route::get('brands', [BrandController::class, 'index']);

// قائمة الموديلات حسب الشركة أو كل الموديلات
Route::get('models', [ModelController::class, 'index']);

// جميع موديلات شركة محددة
Route::get('brands/{brand}/models', [BrandController::class, 'models']);
// جلب سنوات الإنتاج لموديل محدد
Route::get('models/{model}/years', [ModelController::class, 'years']);
Route::post('/app/key/generate', [AppKeyController::class, 'generate']);
Route::get('/app/key', [AppKeyController::class, 'getKey']);
Route::middleware('auth:sanctum')->get('obd/codes/all', [ObdCodeController::class, 'all']);
Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
     ->name('verification.verify');  // للروابط المُوقّعة

Route::post('email/resend-verification', [EmailVerificationController::class, 'resend'])
     ->middleware('auth:sanctum');
Route::get('user/email/verify-status', [EmailVerificationController::class, 'status'])
     ->middleware('auth:sanctum');