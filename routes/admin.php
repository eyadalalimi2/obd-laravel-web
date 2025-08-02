<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DatabaseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TranslationAdminController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\TranslationSiteController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\ObdCodeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ModelController;
use App\Http\Controllers\Admin\ModelYearController;
use App\Http\Controllers\Admin\ObdCodeTranslationController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\AdsSettingController;
use App\Http\Controllers\Admin\TranslationImportController;
use App\Http\Controllers\Admin\JsonTranslationValidatorController;
use App\Http\Controllers\Admin\ObdCodeImportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\MailSettingsController;
use App\Http\Controllers\Admin\EmailTemplateController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserCarController;
use App\Http\Controllers\Admin\AppKeyController;
use App\Http\Controllers\Admin\ActivationCodeController;

Route::get('/', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');
Route::post('/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

// لوحة التحكم بعد تسجيل الدخول
Route::middleware(['admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
});
Route::middleware(['admin'])->prefix('database')->name('admin.database.')->group(function () {
    Route::get('/tables', [DatabaseController::class, 'index'])->name('tables');
    Route::post('/create-table', [DatabaseController::class, 'createTable'])->name('create');
    Route::post('/drop-table', [DatabaseController::class, 'dropTable'])->name('drop');
    Route::get('/columns', [DatabaseController::class, 'columnsPage'])->name('columns');
    Route::post('/add-column', [DatabaseController::class, 'addColumn'])->name('addColumn');
    Route::post('/edit-column', [DatabaseController::class, 'editColumn'])->name('editColumn');
    Route::post('/drop-column', [DatabaseController::class, 'dropColumn'])->name('dropColumn');
    Route::get('/sql', [DatabaseController::class, 'sqlPage'])->name('sql');
    Route::post('/run-sql', [DatabaseController::class, 'runSql'])->name('runSql');
});
Route::middleware(['admin'])->prefix('users')->name('admin.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [UserController::class, 'update'])->name('update');
    Route::post('/{id}/delete', [UserController::class, 'destroy'])->name('delete');
    Route::get('/{id}/show', [UserController::class, 'show'])->name('show');
});
Route::middleware(['admin'])->prefix('posts')->name('admin.posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/create', [PostController::class, 'create'])->name('create');
    Route::post('/store', [PostController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [PostController::class, 'update'])->name('update');
    Route::post('/{id}/delete', [PostController::class, 'destroy'])->name('delete');
});
Route::middleware(['admin'])->prefix('categories')->name('admin.categories.')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/create', [CategoryController::class, 'create'])->name('create');
    Route::post('/store', [CategoryController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::post('/{id}/update', [CategoryController::class, 'update'])->name('update');
    Route::post('/{id}/delete', [CategoryController::class, 'destroy'])->name('delete');
});
Route::get('translations', [TranslationAdminController::class, 'index'])->name('admin.translations.index');
Route::post('translations/update', [TranslationAdminController::class, 'update'])->name('admin.translations.update');
Route::get('/settings', [SettingsController::class, 'index'])->name('admin.settings.index');
Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');
Route::get('/translations/site', [TranslationSiteController::class, 'index'])->name('admin.translations.site');
Route::post('/translations/site', [TranslationSiteController::class, 'update'])->name('admin.translations.site.update');
Route::resource('pages', PageController::class)->names([
    'index' => 'admin.pages.index',
    'create' => 'admin.pages.create',
    'store' => 'admin.pages.store',
    'edit' => 'admin.pages.edit',
    'update' => 'admin.pages.update',
    'destroy' => 'admin.pages.destroy'
])->parameters(['pages' => 'page']);
Route::resource('faqs', FaqController::class)->names([
    'index' => 'admin.faqs.index',
    'create' => 'admin.faqs.create',
    'store' => 'admin.faqs.store',
    'edit' => 'admin.faqs.edit',
    'update' => 'admin.faqs.update',
    'destroy' => 'admin.faqs.destroy'
])->parameters(['faqs' => 'faq']);
Route::get('/cars', [CarController::class, 'index'])->name('admin.cars.index');
Route::get('/cars/create', [CarController::class, 'create'])->name('admin.cars.create');
Route::post('/cars/store', [CarController::class, 'store'])->name('admin.cars.store');
Route::delete('/cars/{id}', [CarController::class, 'destroy'])->name('admin.cars.destroy');
Route::resource('obd-codes', ObdCodeController::class)->names([
    'create' => 'admin.obd_codes.create',
    'store' => 'admin.obd_codes.store',
    'edit' => 'admin.obd_codes.edit',
    'show' => 'admin.obd_codes.show',
    'update' => 'admin.obd_codes.update',
    'destroy' => 'admin.obd_codes.destroy',

]);
Route::post('obd_codes/{obd_code}/toggle-status', [ObdCodeController::class, 'toggleStatus'])->name('admin.obd_codes.toggleStatus');
Route::get('obd-codes/{lang?}', [ObdCodeController::class, 'index'])->name('admin.obd_codes.index');
Route::delete('/obd-codes/{id}', [ObdCodeController::class, 'destroy'])->name('admin.obd_codes.delete');
Route::resource('brands', BrandController::class)->names('admin.brands');
Route::resource('models', ModelController::class)->names('admin.models');
Route::resource('model-years', ModelYearController::class)->names('admin.model_years');
Route::get('obd-translations', [ObdCodeTranslationController::class, 'index'])
    ->middleware('admin')
    ->name('admin.obd_translations.index');
Route::get('obd-translations/{obd_code_id}/edit', [ObdCodeTranslationController::class, 'edit'])
    ->middleware('admin')
    ->name('admin.obd_translations.edit');
Route::post('obd-translations/{obd_code_id}/update', [ObdCodeTranslationController::class, 'update'])
    ->middleware('admin')
    ->name('admin.obd_translations.update');
Route::get('/login', function () {
    return view('admin.auth.login');
})->name('login');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::get('obd-translations/export-json', [ObdCodeTranslationController::class, 'exportJson'])->name('admin.obd_translations.export_json');
Route::post('obd-translations/import-json', [ObdCodeTranslationController::class, 'importJson'])->name('admin.obd_translations.import_json');
Route::get('obd_translations/report', [ObdCodeTranslationController::class, 'report'])->name('admin.obd_translations.report');
Route::get('obd-translations/manager', [ObdCodeTranslationController::class, 'showTranslationManager'])->name('admin.obd_translations.manager');
Route::post('obd-translations/start-import', [ObdCodeTranslationController::class, 'startImport'])->name('admin.obd_translations.start_import');
Route::post('obd-translations/analyze', [ObdCodeTranslationController::class, 'analyzeUntranslatedTexts'])->name('admin.obd_translations.analyze');
Route::post('obd-translations/start-translation', [ObdCodeTranslationController::class, 'startTranslation'])->name('admin.obd_translations.start_translation');
Route::post('obd-translations/export', [ObdCodeTranslationController::class, 'exportToDatabase'])->name('admin.obd_translations.export');
Route::get('system/logs', function () {
    $logPath = storage_path('logs/laravel.log');
    $logs = file_exists($logPath) ? file_get_contents($logPath) : 'لا توجد سجلات حالياً.';
    return view('admin.system.logs', compact('logs'));
})->name('admin.system.logs')->middleware('admin');
Route::post('system/logs/clear', function () {
    file_put_contents(storage_path('logs/laravel.log'), '');
    return redirect()->route('admin.system.logs')->with('success', 'تم مسح السجل بنجاح.');
})->name('admin.system.logs.clear')->middleware('admin');
Route::get('system/logs/download', function () {
    $logPath = storage_path('logs/laravel.log');
    if (!file_exists($logPath)) {
        abort(404);
    }
    return response()->download($logPath, 'laravel.log');
})->name('admin.system.logs.download')->middleware('admin');
Route::get('obd-translations/manager', [ObdCodeTranslationController::class, 'showTranslationManager'])->name('admin.obd_translations.manager');
Route::post('obd-translations/start-import', [ObdCodeTranslationController::class, 'startImport'])->name('admin.obd_translations.start_import');
Route::post('obd-translations/analyze', [ObdCodeTranslationController::class, 'analyzeUntranslatedTexts'])->name('admin.obd_translations.analyze');
Route::post('obd-translations/start-translation', [ObdCodeTranslationController::class, 'startTranslation'])->name('admin.obd_translations.start_translation');
Route::post('obd-translations/export', [ObdCodeTranslationController::class, 'exportToDatabase'])->name('admin.obd_translations.export');
Route::get('/ads-settings', [AdsSettingController::class, 'index'])->name('admin.ads_settings.index');
Route::post('/ads-settings/update', [AdsSettingController::class, 'update'])->name('admin.ads_settings.update');
Route::post('/obd-translations/translate', [ObdCodeTranslationController::class, 'startTranslation'])->name('admin.obd_translations.translate');
Route::get('languages', [LanguageController::class, 'index'])->name('admin.languages.index');
Route::patch('languages/{id}/toggle', [LanguageController::class, 'toggleStatus'])->name('admin.languages.toggle');
Route::get('languages/create', [LanguageController::class, 'create'])->name('admin.languages.create');
Route::post('languages', [LanguageController::class, 'store'])->name('admin.languages.store');
Route::get('languages/{id}/edit', [LanguageController::class, 'edit'])->name('admin.languages.edit');
Route::patch('languages/{id}', [LanguageController::class, 'update'])->name('admin.languages.update');
Route::delete('languages/{id}', [LanguageController::class, 'destroy'])->name('admin.languages.destroy');
Route::patch('languages/{id}/toggle', [LanguageController::class, 'toggleStatus'])->name('admin.languages.toggle');
Route::get('languages/{id}/export-json', [LanguageController::class, 'exportJson'])->name('admin.languages.exportJson');
Route::get('languages/{id}/translations', [LanguageController::class, 'viewTranslations'])->name('admin.languages.viewTranslations');
Route::get('languages/create', [LanguageController::class, 'create'])->name('admin.languages.create');
Route::post('languages', [LanguageController::class, 'store'])->name('admin.languages.store');
Route::get('languages/{id}/translations', [LanguageController::class, 'viewTranslations'])
    ->name('admin.languages.translations');
Route::get('languages/{id}/export-json', [LanguageController::class, 'exportJson'])
    ->name('admin.languages.export_json');
Route::get('languages/{id}/import-json', [LanguageController::class, 'showImportForm'])->name('admin.languages.importForm');
Route::post('languages/{id}/import-json', [LanguageController::class, 'importJson'])->name('admin.languages.importJson');
Route::get('translations/import', [TranslationImportController::class, 'showImportForm'])
    ->middleware(['auth','admin'])
    ->name('admin.translations.import');
Route::post('translations/import/validate', [TranslationImportController::class, 'validateJson'])
    ->middleware(['auth','admin'])
    ->name('admin.translations.import.validate');
Route::post('translations/import/process', [TranslationImportController::class, 'processImport'])
    ->middleware(['auth','admin'])
    ->name('admin.translations.import.process');
Route::get('translations/json-validator', [JsonTranslationValidatorController::class, 'showForm'])->name('admin.translations.json_validator');
Route::post('translations/json-validator', [JsonTranslationValidatorController::class, 'validateJson'])->name('admin.translations.json_validator.submit');
Route::get('translations/import', [TranslationImportController::class, 'showImportForm'])->name('admin.translations.import');
Route::post('translations/import/validate', [TranslationImportController::class, 'validateJson'])->name('admin.translations.import.validate');
Route::post('translations/import/process', [TranslationImportController::class, 'processImport'])->name('admin.translations.import.process');
Route::get('obd_codes/import', [ObdCodeController::class, 'showImportForm'])
    ->middleware(['auth','admin'])
    ->name('admin.obd_codes.import.form');
Route::post('obd_codes/import/validate', [ObdCodeController::class, 'validateImport'])
    ->middleware(['auth','admin'])
    ->name('admin.obd_codes.import.validate');
Route::post('obd_codes/import', [ObdCodeController::class, 'import'])
    ->middleware(['auth','admin'])
    ->name('admin.obd_codes.import');
Route::get('obd-codes/import', [ObdCodeImportController::class, 'showForm'])
    ->middleware(['auth','admin'])
    ->name('admin.obd_codes.import_form');
Route::post('obd-codes/import/validate', [ObdCodeImportController::class, 'validateFile'])
    ->middleware(['auth','admin'])
    ->name('admin.obd_codes.import_validate');
Route::post('obd-codes/import/confirm', [ObdCodeImportController::class, 'confirmImport'])
    ->middleware(['auth','admin'])
    ->name('admin.obd_codes.import_confirm');
Route::get('site-settings', [SiteSettingController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('admin.site-settings.edit');
Route::post('site-settings', [SiteSettingController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('admin.site-settings.update');
Route::get('notifications', [NotificationController::class, 'index'])
    ->middleware(['auth','admin'])
    ->name('admin.notifications.index');
Route::get('notifications/create', [NotificationController::class, 'create'])
    ->middleware(['auth','admin'])
    ->name('admin.notifications.create');
Route::post('notifications', [NotificationController::class, 'store'])
    ->middleware(['auth','admin'])
    ->name('admin.notifications.store');
Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])
    ->middleware(['auth','admin'])
    ->name('admin.notifications.destroy');
Route::get('notifications/debug', function () {
    $notifications = \App\Models\Notification::with('users')
                          ->latest()
                          ->take(20)
                          ->get();
    return view('admin.notifications.debug', compact('notifications'));
})->middleware(['auth','admin'])
  ->name('admin.notifications.debug');
Route::get('mail-settings', [MailSettingsController::class, 'edit'])
    ->name('admin.mail.edit');
Route::post('mail-settings', [MailSettingsController::class, 'update'])
    ->name('admin.mail.update');
Route::get('email_templates',                [EmailTemplateController::class, 'index'])
    ->name('admin.email_templates.index');
Route::get('email_templates/create',         [EmailTemplateController::class, 'create'])
    ->name('admin.email_templates.create');
Route::post('email_templates',               [EmailTemplateController::class, 'store'])
    ->name('admin.email_templates.store');
Route::get('email_templates/{template}',     [EmailTemplateController::class, 'show'])
    ->name('admin.email_templates.show');
Route::get('email_templates/{template}/edit', [EmailTemplateController::class, 'edit'])
    ->name('admin.email_templates.edit');
Route::put('email_templates/{template}',     [EmailTemplateController::class, 'update'])
    ->name('admin.email_templates.update');
Route::delete('email_templates/{template}',  [EmailTemplateController::class, 'destroy'])
    ->name('admin.email_templates.destroy');
Route::get('email_templates/{template}/test/{locale?}', [EmailTemplateController::class, 'showTest'])
    ->name('admin.email_templates.show_test');
Route::post('email_templates/{template}/send-test', [EmailTemplateController::class, 'sendTest'])
    ->name('admin.email_templates.send_test');
Route::get(
    'email_templates/{template}/translation/{locale}',
    [EmailTemplateController::class, 'editTranslation']
)
    ->name('admin.email_templates.edit_translation');
Route::post(
    'email_templates/{template}/translation/{locale}',
    [EmailTemplateController::class, 'updateTranslation']
)
    ->name('admin.email_templates.update_translation');
Route::delete(
    'email_templates/{template}/translation/{locale}',
    [EmailTemplateController::class, 'destroyTranslation']
)
    ->name('admin.email_templates.destroy_translation');
Route::get('plans', [PlanController::class, 'index'])
    ->middleware(['auth', 'admin'])
    ->name('admin.plans.index');
Route::get('plans/create', [PlanController::class, 'create'])
    ->middleware(['auth', 'admin'])
    ->name('admin.plans.create');
Route::post('plans', [PlanController::class, 'store'])
    ->middleware(['auth', 'admin'])
    ->name('admin.plans.store');
Route::get('plans/{plan}/edit', [PlanController::class, 'edit'])
    ->middleware(['auth', 'admin'])
    ->name('admin.plans.edit');
Route::put('plans/{plan}', [PlanController::class, 'update'])
    ->middleware(['auth', 'admin'])
    ->name('admin.plans.update');
Route::delete('plans/{plan}', [PlanController::class, 'destroy'])
    ->middleware(['auth', 'admin'])
    ->name('admin.plans.destroy');

// أولاً: نموذج إضافة اشتراك جديد
Route::get('subscriptions/create', [SubscriptionController::class, 'create'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.create');

// ثم: حفظ الاشتراك الجديد
Route::post('subscriptions', [SubscriptionController::class, 'store'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.store');

// بعدَها باقي المسارات التي تستخدم {subscription}
Route::get('subscriptions', [SubscriptionController::class, 'index'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.index');

Route::post('subscriptions/{subscription}/renew', [SubscriptionController::class, 'renew'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.renew');

Route::post('subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.cancel');

Route::get('subscriptions/{subscription}', [SubscriptionController::class, 'show'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.show');

Route::get('subscriptions/{subscription}/edit', [SubscriptionController::class, 'edit'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.edit');

Route::put('subscriptions/{subscription}', [SubscriptionController::class, 'update'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.update');

Route::delete('subscriptions/{subscription}', [SubscriptionController::class, 'destroy'])
    ->middleware(['auth','admin'])
    ->name('admin.subscriptions.destroy');
Route::get('navigation', function () {
    return view('admin.navigation');
})->middleware(['auth', 'admin'])->name('admin.navigation');
// قائمة كل السيارات
Route::get('user_cars', [UserCarController::class, 'index'])->name('admin.user_cars.index');

// عرض شاشة إضافة سيارة جديدة
Route::get('user_cars/create', [UserCarController::class, 'create'])->name('admin.user_cars.create');

// حفظ السيارة الجديدة
Route::post('user_cars', [UserCarController::class, 'store'])->name('admin.user_cars.store');

// عرض شاشة تعديل سيارة
Route::get('user_cars/{id}/edit', [UserCarController::class, 'edit'])->name('admin.user_cars.edit');

// حفظ التعديل على السيارة
Route::put('user_cars/{id}', [UserCarController::class, 'update'])->name('admin.user_cars.update');

// حذف سيارة
Route::delete('user_cars/{id}', [UserCarController::class, 'destroy'])->name('admin.user_cars.destroy');
// جلب الموديلات حسب الشركة
Route::get('brands/{brand}/models', function($brandId) {
    return \App\Models\CarModel::where('brand_id', $brandId)->pluck('name', 'id');
});

// جلب السنوات حسب الموديل
Route::get('models/{model}/years', function($modelId) {
    return \App\Models\ModelYear::where('model_id', $modelId)->pluck('year');
});

// عرض جميع المفاتيح
Route::get('/app_keys', [AppKeyController::class, 'index'])->name('admin.app_keys.index')->middleware('auth');

// عرض نموذج إنشاء مفتاح
Route::get('/app_keys/create', [AppKeyController::class, 'create'])->name('admin.app_keys.create')->middleware('auth');

// تخزين المفتاح الجديد
Route::post('app_keys/store', [AppKeyController::class, 'store'])->name('admin.app_keys.store')->middleware('auth');

// حذف مفتاح
Route::delete('app_keys/{appKey}/delete', [AppKeyController::class, 'destroy'])->name('admin.app_keys.destroy')->middleware('auth');
Route::get('activation-codes/{activation_code}/edit', [ActivationCodeController::class, 'edit'])
     ->middleware(['auth','admin'])
     ->name('admin.activation_codes.edit');

// عرض قائمة رموز التفعيل
Route::get('activation-codes', [ActivationCodeController::class, 'index'])
    ->middleware(['auth','admin'])
    ->name('admin.activation_codes.index');

// نموذج إنشاء رمز جديد
Route::get('activation-codes/create', [ActivationCodeController::class, 'create'])
    ->middleware(['auth','admin'])
    ->name('admin.activation_codes.create');

// تخزين الرمز الجديد
Route::post('activation-codes', [ActivationCodeController::class, 'store'])
    ->middleware(['auth','admin'])
    ->name('admin.activation_codes.store');

// نموذج تعديل رمز
Route::get('activation-codes/{activation_code}/edit', [ActivationCodeController::class, 'edit'])
    ->middleware(['auth','admin'])
    ->name('admin.activation_codes.edit');

// تحديث بيانات الرمز
Route::put('activation-codes/{activation_code}', [ActivationCodeController::class, 'update'])
    ->middleware(['auth','admin'])
    ->name('admin.activation_codes.update');

// حذف الرمز
Route::delete('activation-codes/{activation_code}', [ActivationCodeController::class, 'destroy'])
    ->middleware(['auth','admin'])
    ->name('admin.activation_codes.destroy');
