<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <!-- Favicon -->
    <link rel="icon"
          href="{{ asset('logo.png') }}"
          type="image/x-icon">
    <link rel="shortcut icon"
          href="{{ asset('logo.png') }}"
          type="image/x-icon">

    @include('site.partials.head')
    @stack('styles')
</head>
<body>
    @include('site.partials.navbar')

    <div class="container mt-4">
        @yield('content')
    </div>

    @include('site.partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>