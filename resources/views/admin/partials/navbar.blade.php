<nav class="main-header navbar navbar-expand navbar-dark" style="background: linear-gradient(135deg, #1d2b64, #f8cdda); direction: rtl;">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div>
            <button class="navbar-toggler" type="button" data-widget="pushmenu">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="d-flex align-items-center">
            <!-- زر التنقل -->
            <a href="{{ route('admin.navigation') }}" class="nav-link text-white mx-3">
                <i class="fas fa-th-large"></i> التنقل
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-link text-white">
                <i class="fas fa-cogs"></i> الإعدادات
            </a>
            <a href="#" class="nav-link text-white mx-3">
                <i class="fas fa-language"></i> اللغة
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </button>
            </form>
        </div>
    </div>
</nav>