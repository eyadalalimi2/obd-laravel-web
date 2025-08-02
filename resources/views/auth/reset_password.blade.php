<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>إعادة ضبط كلمة المرور</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 20px; }
        .container { max-width: 400px; margin: auto; background: #fff; padding: 20px; border-radius: 5px; direction: rtl; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #0867ec; color: #fff; border: none; cursor: pointer; }
        button:disabled { background: #ccc; }
        #message { margin-top: 15px; color: red; white-space: pre-line; }
    </style>
</head>
<body>
    <div class="container">
        <h2>إعادة ضبط كلمة المرور</h2>

        <form id="resetForm">
            <input type="hidden" id="token" name="token" value="{{ request()->query('token') }}">

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" value="{{ request()->query('email') }}" required>
            </div>

            <div class="form-group">
                <label for="password">كلمة المرور الجديدة</label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>

            <button type="submit" id="btnSubmit">إعادة ضبط</button>
        </form>

        <div id="message"></div>
    </div>

    <script>
    document.getElementById('resetForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = document.getElementById('btnSubmit');
        btn.disabled = true;
        document.getElementById('message').textContent = '';

        const payload = {
            token: document.getElementById('token').value,
            email: document.getElementById('email').value,
            password: document.getElementById('password').value,
            password_confirmation: document.getElementById('password_confirmation').value
        };

        try {
            const res = await fetch('{{ url("/api/password/reset") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify(payload)
            });

            const data = await res.json();
            if (res.ok) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').textContent = data.message || 'تمت إعادة ضبط كلمة المرور بنجاح';
            } else {
                let msg = '';
                if (data.errors) {
                    for (let field in data.errors) {
                        msg += data.errors[field].join(', ') + '\n';
                    }
                } else if (data.message) {
                    msg = data.message;
                }
                document.getElementById('message').textContent = msg;
            }
        } catch (err) {
            document.getElementById('message').textContent = 'حدث خطأ غير متوقع';
        } finally {
            btn.disabled = false;
        }
    });
    </script>
</body>
</html>
