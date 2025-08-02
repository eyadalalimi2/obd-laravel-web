<aside class="main-sidebar elevation-4"
    style="background: linear-gradient(135deg, #2c3e50, #4ca1af); color: white; width: 250px; position: fixed; height: 100vh; overflow-y: auto; right: 0; left: auto;">

    <a href="{{ route('admin.dashboard') }}" class="brand-link text-center"
        style="color: #fff; font-weight: bold; border-bottom: 1px solid rgba(255,255,255,0.2); padding: 15px;">
        <i class="fas fa-tools"></i> لوحة التحكم
    </a>

    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" style="text-align: right;" data-widget="treeview"
                role="menu">

                {{-- إدارة المستخدمين --}}
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link text-white">
                        <p>المستخدمون</p>
                    </a>
                </li>

                {{-- سيارات المستخدمين --}}
                <li class="nav-item">
                    <a href="{{ route('admin.user_cars.index') }}" class="nav-link text-white">
                        <p>سيارات المستخدمين</p>
                    </a>
                </li>

                {{-- إدارة الباقات --}}
                <li class="nav-item">
                    <a href="{{ route('admin.plans.index') }}" class="nav-link text-white">
                        <p>إدارة الباقات</p>
                    </a>
                </li>

                {{-- إدارة رموز التفعيل --}}
                <li class="nav-item">
                    <a href="{{ route('admin.activation_codes.index') }}" class="nav-link text-white">
                        <p>رموز التفعيل</p>
                    </a>
                </li>

                {{-- إدارة الاشتراكات --}}
                <li class="nav-item">
                    <a href="{{ route('admin.subscriptions.index') }}" class="nav-link text-white">
                        <p>الاشتراكات</p>
                    </a>
                </li>

                {{-- إعدادات الإعلانات --}}
                <li class="nav-item">
                    <a href="{{ route('admin.ads_settings.index') }}" class="nav-link text-white">
                        <p>الإعلانات</p>
                    </a>
                </li>

                {{-- سجل الأحداث --}}
                <li class="nav-item">
                    <a href="{{ route('admin.system.logs') }}" class="nav-link text-white">
                        <p>الأحداث</p>
                    </a>
                </li>

                {{-- مفاتيح التشفير --}}
                <li class="nav-item">
                    <a href="{{ route('admin.app_keys.index') }}" class="nav-link text-white">
                        <p>مفاتيح التشفير</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
