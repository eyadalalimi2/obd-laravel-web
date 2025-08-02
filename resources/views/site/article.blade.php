<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap + الخطوط -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
            direction: rtl;
            text-align: right;
        }
        .article-title {
            font-size: 26px;
            font-weight: bold;
        }
        .article-meta {
            font-size: 14px;
            color: #777;
        }
        .article-image {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .article-content {
            font-size: 18px;
            line-height: 2;
        }
    </style>
</head>
<body>

<div class="container py-5">

    <div class="mb-4">
        <a href="/" class="btn btn-secondary btn-sm">الرجوع إلى الرئيسية</a>
    </div>

    <div class="card shadow-sm p-4">
        <h1 class="article-title">{{ $post->title }}</h1>
        <div class="article-meta mb-2">
            التصنيف: {{ $post->category->name ?? 'غير مصنف' }} |
            الكاتب: {{ $post->author->username ?? 'غير معروف' }} |
            التاريخ: {{ $post->created_at->format('Y-m-d') }}
        </div>

        @if($post->image)
            <img src="{{ asset('storage/' . $post->image) }}" class="article-image" alt="صورة المقال">
        @endif

        <div class="article-content">
            {!! $post->content !!}
        </div>
    </div>

</div>

</body>
</html>
