<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>المدونة | OBD Codes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + خط جميل -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f9f9f9;
            direction: rtl;
            text-align: right;
        }
        .card {
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .card-img-top {
            height: 180px;
            object-fit: cover;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }
        .card-title {
            font-size: 20px;
            font-weight: bold;
        }
        .card-text {
            font-size: 15px;
            color: #555;
        }
        .meta {
            font-size: 13px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <h2 class="mb-4 text-center">أحدث المقالات</h2>

    <div class="row">
        @forelse($posts as $post)
            <div class="col-md-4">
                <div class="card shadow-sm">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="صورة المقال">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="meta">
                            التصنيف: {{ $post->category->name ?? 'بدون تصنيف' }}<br>
                            الكاتب: {{ $post->author->username ?? 'غير معروف' }}<br>
                            {{ $post->created_at->format('Y-m-d') }}
                        </p>
                        <a href="{{ url('/article/' . $post->slug) }}" class="btn btn-sm btn-primary mt-2">قراءة المزيد</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">لا توجد مقالات حاليًا.</div>
        @endforelse
    </div>

</div>

</body>
</html>
