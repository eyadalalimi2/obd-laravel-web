@extends('admin.layouts.admin')

@section('title', 'قوالب البريد الإلكتروني')

@section('content')
<div class="container-fluid">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3">قوالب البريد الإلكتروني</h1>
    <a href="{{ route('admin.email_templates.create') }}" class="btn btn-primary">
      <i class="fas fa-plus"></i> إضافة قالب جديد
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-striped table-hover align-middle">
      <thead class="thead-light">
        <tr>
          <th>#</th>
          <th>Key</th>
          <th>الموضوع</th> {{-- العمود المضاف --}}
          <th>الترجمات</th>
          <th class="text-center">الإجراءات</th>
        </tr>
      </thead>
      <tbody>
        @foreach($templates as $template)
          <tr>
            <td>{{ $template->id }}</td>
            <td><code>{{ $template->key }}</code></td>

            {{-- عمود الموضوع --}}
            <td>{{ Str::limit($template->subject, 50) }}</td>

            {{-- عمود الترجمات --}}
            <td>
              @foreach($locales as $code => $label)
                @php
                  $has = $template->translations->firstWhere('locale', $code);
                @endphp
                <a href="{{ route('admin.email_templates.show', ['template'=>$template, 'locale'=>$code]) }}"
                   class="badge badge-{{ $has ? 'success' : 'secondary' }}"
                   title="عرض الترجمة {{ $label }}">
                  {{ strtoupper($code) }}
                </a>
                <a href="{{ route('admin.email_templates.edit_translation', ['template'=>$template,'locale'=>$code]) }}"
                   class="badge badge-{{ $has ? 'warning' : 'dark' }}"
                   title="{{ $has ? 'تعديل' : 'إضافة' }} ترجمة {{ $label }}">
                  ✎
                </a>
              @endforeach
            </td>

            {{-- عمود الإجراءات العام --}}
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group">
                {{-- عرض عام للقالب (لغة افتراضية) --}}
                <a href="{{ route('admin.email_templates.show', ['template'=>$template,'locale'=>app()->getLocale()]) }}"
                   class="btn btn-info" title="معاينة القالب">
                  <i class="fas fa-eye"></i>
                </a>
                {{-- تعديل بيانات القالب الرئيسي --}}
                <a href="{{ route('admin.email_templates.edit', $template) }}"
                   class="btn btn-warning" title="تعديل القالب">
                  <i class="fas fa-edit"></i>
                </a>
                {{-- حذف القالب بالكامل --}}
                <form action="{{ route('admin.email_templates.destroy', $template) }}"
                      method="POST" onsubmit="return confirm('هل تريد حذف هذا القالب؟')" class="d-inline">
                  @csrf @method('DELETE')
                  <button class="btn btn-danger" title="حذف">
                    <i class="fas fa-trash-alt"></i>
                  </button>
                </form>
                {{-- نموذج تجربة القالب --}}
                <a href="{{ route('admin.email_templates.show_test', ['template'=>$template,'locale'=>app()->getLocale()]) }}"
                   class="btn btn-secondary" title="تجربة إرسال">
                  <i class="fas fa-paper-plane"></i>
                </a>
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  {{ $templates->links() }}
</div>
@endsection
