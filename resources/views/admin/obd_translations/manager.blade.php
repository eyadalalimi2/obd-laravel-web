@extends('admin.layouts.admin')

@section('title', 'إدارة الترجمة التفاعلية')

@section('content')
    <div class="container-fluid">
        <h4>إدارة الترجمة التفاعلية لأكواد الأعطال</h4>

        <!-- اختيار اللغة -->
        <div class="form-group">
            <label>اختر اللغة المستهدفة:</label>
            <select id="language" class="form-control w-25">
                @foreach ($languages as $lang)
                    <option value="{{ $lang->code }}">{{ $lang->name }} ({{ $lang->code }})</option>
                @endforeach
            </select>
        </div>

        <!-- زر بدء العملية -->
        <form method="POST" action="{{ route('admin.obd_translations.translate') }}">
            @csrf
            <select name="language_code">
                @foreach ($languages as $language)
                    <option value="{{ $language->code }}">{{ $language->name }} ({{ $language->code }})</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">بدء الترجمة</button>
        </form>


        <!-- عرض الحالات -->
        <div id="processStatus" class="alert alert-info d-none"></div>
    </div>
@endsection

@section('scripts')
    <script>
        document.getElementById('startProcess').addEventListener('click', function() {
            let lang = document.getElementById('language').value;
            let statusDiv = document.getElementById('processStatus');
            statusDiv.classList.remove('d-none');

            // مرحلة 1: استيراد البيانات
            statusDiv.innerHTML = '1/4 - جاري استيراد البيانات...';
            fetch('{{ route('admin.obd_translations.start_import') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') throw data.message;
                    statusDiv.innerHTML = `تم استيراد ${data.total} كود. جاري التحليل...`;

                    // مرحلة 2: تحليل النصوص
                    return fetch('{{ route('admin.obd_translations.analyze') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            language: lang
                        })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') throw data.message;
                    statusDiv.innerHTML = `عدد النصوص غير المترجمة: ${data.total}. جاري الترجمة...`;

                    // مرحلة 3: بدء الترجمة
                    return fetch('{{ route('admin.obd_translations.start_translation') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            language: lang
                        })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') throw data.message;
                    statusDiv.innerHTML = `تم إنشاء ملف ${data.file}. جاري التصدير لقاعدة البيانات...`;

                    // مرحلة 4: تصدير إلى قاعدة البيانات
                    return fetch('{{ route('admin.obd_translations.export') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            language: lang,
                            file: data.file
                        })
                    });
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status !== 'success') throw data.message;
                    statusDiv.innerHTML = '✅ تمت العملية بنجاح.';
                })
                .catch(error => {
                    statusDiv.innerHTML = '❌ حدث خطأ: ' + error;
                });
        });
    </script>
@endsection
