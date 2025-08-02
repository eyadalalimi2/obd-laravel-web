<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">


<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'لوحة التحكم')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.rtl.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.rtl.min.css">

    <link href="https://cdn.jsdelivr.net/gh/ColorlibHQ/AdminLTE@3.2/dist/css/adminlte.rtl.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-aL8c2PS4Hevf6EGMo0oN+bfjYAPFoHeHqAH2Sk3cwEbYbq2t6sBJKXZStq5xtiQXFGVboF5rr1arBvIbUdMe3w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-xxx" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GtvN5NlgA3AdQ8joO2mrSgMwTVUmhZKzryuHgEJhPV3KjKKRQel0wE1V1NcBxmIp" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"
        integrity="sha384-lAlF9clWgo5lgoZu3gGS15Ei9lYQ5IRn8N9ppT0MyG8ZzC2fZwIgJrw8r3n3A12V" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-TbA/9Hb2D7fnrxz9qFuLz+VZ+iZb3Z5Dk5gOQ+s0s8aNtxzZmPp3rKJyz6UbFA7rxI7dYjeoKEgCVuEk0ZJr2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css"
        integrity="sha384-xxx" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Toast CSS (موجود ضمن Bootstrap 5) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .pagination {
            direction: rtl;
        }

        .pagination .page-link {
            border-radius: 8px;
            margin: 0 2px;
            font-weight: bold;
        }

        .pagination .active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        body[dir="rtl"] {
            direction: rtl;
            text-align: right;
            font-family: 'Tajawal', sans-serif;
        }

        body[dir="ltr"] {
            direction: ltr;
            text-align: left;
            font-family: 'Segoe UI', sans-serif;
        }

        .text-right-rtl {
            text-align: right;
        }

        .text-left-ltr {
            text-align: left;
        }

        .btn-language {
            background: linear-gradient(135deg, #4ca1af, #2c3e50);
            color: white !important;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            margin: 5px 5px 5px 0;
            transition: all 0.3s ease-in-out;
        }

        .btn-language:hover {
            background: linear-gradient(135deg, #2c3e50, #4ca1af);
            color: #fff !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-active-language {
            background: linear-gradient(135deg, #ff9800, #f44336) !important;
            color: #fff !important;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 8px 16px;
            margin: 5px 5px 5px 0;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
        }

        /* تأثير الصندوق عند التحديد */
        input[type="radio"]:checked+div {
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.2);
        }
    </style>


</head>


<body class="hold-transition sidebar-mini layout-fixed" style="direction: rtl; text-align: right;">

    <div class="wrapper">
        @include('admin.partials.navbar')
        @include('admin.partials.sidebar')

        <div class="content-wrapper p-3" style="margin-right: 250px; margin-left: 0;">
            @yield('content')
        </div>

        @include('admin.partials.footer')
    </div>
    <!-- Summernote JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-bs4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js" integrity="sha512-xxx"
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-uP4+1UQVskS5Wf9jq9V3roZ5qh6iL90HLX6sR3qz9KA=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeo+7H6tyA0CkTx6I91SdeH5c4qVjNUsZVVFIhvjP5dZLlGJ" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"
        integrity="sha384-JQdMROf1c0L9FRETL+TGEnxhj7Z0C9UFE9yP5FyE3KDY6F3UEXJ/F6RAA03j4k1N" crossorigin="anonymous">
    </script>
    <!-- Toast JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>

</html>
