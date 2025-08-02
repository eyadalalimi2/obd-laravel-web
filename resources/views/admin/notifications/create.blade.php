@extends('admin.layouts.admin')

@section('content')
<div class="card">
  <div class="card-header">
    <h3>إنشاء إشعار جديد</h3>
  </div>
  <div class="card-body">
    <form action="{{ route('admin.notifications.store') }}" method="POST">
      @csrf

      {{-- عنوان الإشعار --}}
      <div class="form-group">
        <label for="title">العنوان</label>
        <input type="text" name="title" id="title"
               class="form-control @error('title') is-invalid @enderror"
               value="{{ old('title') }}">
        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- نص الإشعار --}}
      <div class="form-group">
        <label for="message">النص</label>
        <textarea name="message" id="message" rows="4"
                  class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>

      {{-- اختيار نوع الإشعار --}}
      <div class="form-group">
        <label>نوع الإشعار</label>
        <div class="d-flex gap-2 mb-3">
          @php
            $types = [
              'info'    => ['label'=>'معلومة','color'=>'#2196F3'],
              'warning' => ['label'=>'تحذير','color'=>'#FFC107'],
              'success' => ['label'=>'نجاح','color'=>'#4CAF50'],
              'error'   => ['label'=>'خطأ','color'=>'#F44336'],
            ];
          @endphp

          @foreach($types as $key=>$cfg)
            <label style="flex:1; cursor:pointer;">
              <input type="radio" name="type" value="{{ $key }}" class="d-none"
                     {{ old('type')=== $key ? 'checked':'' }}>
              <div class="p-3 text-center rounded"
                   style="border:2px solid {{ $cfg['color'] }};
                          background: {{ old('type')===$key ? $cfg['color'].'33':'' }};">
                {{ $cfg['label'] }}
              </div>
            </label>
          @endforeach
        </div>
        @error('type')<div class="text-danger">{{ $message }}</div>@enderror
      </div>

      {{-- إرسال إلى جميع المستخدمين --}}
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox"
                 value="1" id="send_to_all" name="send_to_all"
                 {{ old('send_to_all') ? 'checked' : '' }}>
          <label class="form-check-label" for="send_to_all">
            إرسال إلى جميع المستخدمين
            <span class="text-muted">(إذا تم تحديده، سيتم تجاهل اختيار المستخدمين)</span>
          </label>
        </div>
      </div>

      {{-- اختيار مستخدمين محددين --}}
      <div class="form-group" id="user-selector"
           style="{{ old('send_to_all') ? 'display:none' : '' }}">
        <label for="users">اختيار مستخدمين:</label>
        
        <select name="users[]" id="users" class="form-control" multiple>
          @foreach(\App\Models\User::orderBy('username')->get() as $user)
            <option value="{{ $user->id }}"
              {{ in_array($user->id, old('users', [])) ? 'selected':'' }}>
              {{ $user->username }} ({{ $user->email }})
            </option>
          @endforeach
        </select>
        @error('users')<div class="text-danger">{{ $message }}</div>@enderror
      </div>

      <button class="btn btn-primary">حفظ</button>
    </form>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.getElementById('send_to_all')
    .addEventListener('change', function(){
      document.getElementById('user-selector')
              .style.display = this.checked ? 'none' : 'block';
    });
</script>
@endpush
