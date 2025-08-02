@extends('admin.layouts.admin')

@section('title','تعديل قالب: '.$template->key)

@section('content')
<div class="container-fluid">
  <h1 class="mb-4">تعديل قالب: <code>{{ $template->key }}</code></h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif

  <form action="{{ route('admin.email_templates.update', $template) }}" method="POST">
    @csrf @method('PUT')

    {{-- Key --}}
    <div class="form-group">
      <label for="key">المعرّف (Key)</label>
      <input name="key" id="key"
             class="form-control @error('key') is-invalid @enderror"
             value="{{ old('key',$template->key) }}">
      @error('key')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Subject --}}
    <div class="form-group">
      <label for="subject">عنوان الرسالة (Subject)</label>
      <input name="subject" id="subject"
             class="form-control @error('subject') is-invalid @enderror"
             value="{{ old('subject',$template->subject) }}">
      @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Body --}}
    <div class="form-group">
      <label for="body">محتوى الرسالة (Body) — HTML مدعوم</label>
      <textarea name="body" id="body" rows="8"
                class="form-control @error('body') is-invalid @enderror">{{ old('body',$template->body) }}</textarea>
      @error('body')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    {{-- Placeholders --}}
    <div class="form-group">
      <label>المتغيّرات الحالية:</label>
      <div class="mb-2">
        @foreach($template->placeholders ?? [] as $ph)
          <span class="badge badge-info mr-1">{{ $ph }}</span>
        @endforeach
      </div>
      <label for="placeholders">تعديل مصفوفة المتغيّرات (JSON Array)</label>
      <input name="placeholders" id="placeholders"
             class="form-control @error('placeholders') is-invalid @enderror"
             value="{{ old('placeholders', json_encode($template->placeholders)) }}">
      @error('placeholders')<div class="invalid-feedback">{{ $message }}</div>@enderror
      <small class="form-text text-muted">مثال: ["user_name","order_id","tracking_url"]</small>
    </div>

    <button class="btn btn-primary"><i class="fas fa-save"></i> حفظ</button>
    <a href="{{ route('admin.email_templates.index') }}" class="btn btn-secondary">إلغاء</a>
  </form>
</div>
@endsection
