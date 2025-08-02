{{-- resources/views/admin/navigation.blade.php --}}
@extends('admin.layouts.admin')
@section('title', 'التنقل بين الأقسام')

@section('content')
<div class="container-fluid">
  <h1 class="mb-4">التنقل بين الأقسام</h1>
  <div class="row">

    <!-- لوحة القيادة -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary btn-block py-4">
        <i class="fas fa-tachometer-alt fa-2x mb-2"></i>
        <div>لوحة القيادة</div>
      </a>
    </div>

    <!-- إدارة الباقات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.plans.index') }}" class="btn btn-outline-success btn-block py-4">
        <i class="fas fa-tags fa-2x mb-2"></i>
        <div>إدارة الباقات</div>
      </a>
    </div>

    <!-- إدارة الاشتراكات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-info btn-block py-4">
        <i class="fas fa-receipt fa-2x mb-2"></i>
        <div>إدارة الاشتراكات</div>
      </a>
    </div>

    <!-- أكواد الأعطال -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.obd_codes.index') }}" class="btn btn-outline-warning btn-block py-4">
        <i class="fas fa-tools fa-2x mb-2"></i>
        <div>قائمة أكواد الأعطال</div>
      </a>
    </div>

    <!-- ترجمة الأكواد -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.obd_translations.index') }}" class="btn btn-outline-dark btn-block py-4">
        <i class="fas fa-language fa-2x mb-2"></i>
        <div>ترجمة الأكواد</div>
      </a>
    </div>

    <!-- استيراد أكواد OBD -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.obd_codes.import.form') }}" class="btn btn-outline-primary btn-block py-4">
        <i class="fas fa-file-import fa-2x mb-2"></i>
        <div>استيراد أكواد OBD</div>
      </a>
    </div>

    <!-- تقرير الترجمات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.obd_translations.report') }}" class="btn btn-outline-success btn-block py-4">
        <i class="fas fa-chart-pie fa-2x mb-2"></i>
        <div>تقرير الترجمات</div>
      </a>
    </div>

    <!-- إدارة الترجمة التفاعلية -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.obd_translations.manager') }}" class="btn btn-outline-info btn-block py-4">
        <i class="fas fa-magic fa-2x mb-2"></i>
        <div>الترجمة التفاعلية</div>
      </a>
    </div>

    <!-- إدارة قاعدة البيانات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.database.tables') }}" class="btn btn-outline-warning btn-block py-4">
        <i class="fas fa-table fa-2x mb-2"></i>
        <div>عرض الجداول</div>
      </a>
    </div>

    <!-- إدارة الأعمدة -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.database.columns') }}" class="btn btn-outline-secondary btn-block py-4">
        <i class="fas fa-columns fa-2x mb-2"></i>
        <div>إدارة الأعمدة</div>
      </a>
    </div>

    <!-- تنفيذ SQL -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.database.sql') }}" class="btn btn-outline-dark btn-block py-4">
        <i class="fas fa-terminal fa-2x mb-2"></i>
        <div>تنفيذ SQL</div>
      </a>
    </div>

    <!-- إدارة المحتوى -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary btn-block py-4">
        <i class="fas fa-newspaper fa-2x mb-2"></i>
        <div>المقالات</div>
      </a>
    </div>

    <!-- التصنيفات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-success btn-block py-4">
        <i class="fas fa-tags fa-2x mb-2"></i>
        <div>التصنيفات</div>
      </a>
    </div>

    <!-- الصفحات الثابتة -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-info btn-block py-4">
        <i class="fas fa-file-alt fa-2x mb-2"></i>
        <div>الصفحات الثابتة</div>
      </a>
    </div>

    <!-- الأسئلة الشائعة -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-warning btn-block py-4">
        <i class="fas fa-question-circle fa-2x mb-2"></i>
        <div>الأسئلة الشائعة</div>
      </a>
    </div>

    <!-- إدارة السيارات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.cars.index') }}" class="btn btn-outline-secondary btn-block py-4">
        <i class="fas fa-car fa-2x mb-2"></i>
        <div>السيارات</div>
      </a>
    </div>

    <!-- الشركات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.brands.index') }}" class="btn btn-outline-dark btn-block py-4">
        <i class="fas fa-building fa-2x mb-2"></i>
        <div>الشركات</div>
      </a>
    </div>

    <!-- الموديلات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.models.index') }}" class="btn btn-outline-primary btn-block py-4">
        <i class="fas fa-car-side fa-2x mb-2"></i>
        <div>الموديلات</div>
      </a>
    </div>

    <!-- سنوات الإنتاج -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.model_years.index') }}" class="btn btn-outline-success btn-block py-4">
        <i class="fas fa-calendar-alt fa-2x mb-2"></i>
        <div>سنوات الإنتاج</div>
      </a>
    </div>

    <!-- إدارة اللغات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.languages.index') }}" class="btn btn-outline-info btn-block py-4">
        <i class="fas fa-language fa-2x mb-2"></i>
        <div>إدارة اللغات</div>
      </a>
    </div>

    <!-- ترجمة لوحة التحكم -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.translations.index') }}" class="btn btn-outline-warning btn-block py-4">
        <i class="fas fa-language fa-2x mb-2"></i>
        <div>ترجمة لوحة التحكم</div>
      </a>
    </div>

    <!-- ترجمة واجهة الموقع -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.translations.site') }}" class="btn btn-outline-secondary btn-block py-4">
        <i class="fas fa-globe fa-2x mb-2"></i>
        <div>ترجمة الموقع</div>
      </a>
    </div>

    <!-- المستخدمون -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.users.index') }}" class="btn btn-outline-dark btn-block py-4">
        <i class="fas fa-users fa-2x mb-2"></i>
        <div>المستخدمون</div>
      </a>
    </div>

    <!-- إعدادات الإعلانات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.ads_settings.index') }}" class="btn btn-outline-primary btn-block py-4">
        <i class="fas fa-ad fa-2x mb-2"></i>
        <div>إعدادات الإعلانات</div>
      </a>
    </div>

    <!-- سجل الأحداث -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.system.logs') }}" class="btn btn-outline-success btn-block py-4">
        <i class="fas fa-file-alt fa-2x mb-2"></i>
        <div>سجل الأحداث</div>
      </a>
    </div>

    <!-- الإشعارات -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.notifications.index') }}" class="btn btn-outline-info btn-block py-4">
        <i class="fas fa-bell fa-2x mb-2"></i>
        <div>الإشعارات</div>
      </a>
    </div>

    <!-- إعدادات الموقع العامة -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.site-settings.edit') }}" class="btn btn-outline-warning btn-block py-4">
        <i class="fas fa-cog fa-2x mb-2"></i>
        <div>الإعدادات العامة</div>
      </a>
    </div>

    <!-- عرض إشعارات (Debug) -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.notifications.debug') }}" class="btn btn-outline-secondary btn-block py-4">
        <i class="fas fa-bug fa-2x mb-2"></i>
        <div>عرض إشعارات</div>
      </a>
    </div>

    <!-- إعدادات البريد الإلكتروني -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.mail.edit') }}" class="btn btn-outline-dark btn-block py-4">
        <i class="fas fa-envelope fa-2x mb-2"></i>
        <div>إعدادات البريد</div>
      </a>
    </div>

    <!-- قوالب البريد -->
    <div class="col-md-3 mb-4">
      <a href="{{ route('admin.email_templates.index') }}" class="btn btn-outline-primary btn-block py-4">
        <i class="fas fa-file-alt fa-2x mb-2"></i>
        <div>قوالب البريد</div>
      </a>
    </div>

  </div>
</div>
@endsection