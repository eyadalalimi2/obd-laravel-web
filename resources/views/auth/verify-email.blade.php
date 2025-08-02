<!DOCTYPE html>
<html lang="ar">
<head>
  <meta charset="UTF-8">
  <title>تفعيل البريد الإلكتروني</title>
  <style>
    body { font-family: sans-serif; direction: rtl; text-align: center; padding: 40px; }
    .card { max-width: 400px; margin: auto; padding: 24px; background: #fff; border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .btn { margin-top: 16px; padding: 12px 24px; background: #007bff; color: #fff;
           border: none; border-radius: 4px; cursor: pointer; }
    .message { margin-top: 16px; color: #333; }
  </style>
</head>
<body>
  <div class="card">
    <h2>تفعيل البريد الإلكتروني</h2>

    @if(isset($message) && $message)
      {{-- إذا وصلت رسالة نجاح/فشل --}}
      <div class="message">{{ $message }}</div>

    @else
      {{-- عرض الزر مع تضمين كل معاملات المسار --}}
      <p>اضغط على الزر لتفعيل بريدك.</p>
      <form method="POST"
            action="{{ route('verification.verify', [
              'id'        => $id,
              'hash'      => $hash,
              'expires'   => request()->query('expires'),
              'signature' => request()->query('signature'),
            ]) }}">
        @csrf
        <button type="submit" class="btn">تفعيل البريد</button>
      </form>
    @endif
  </div>
</body>
</html>
