{{-- resources/views/admin/subscriptions/create.blade.php --}}
@extends('admin.layouts.admin')

@section('content')
<div class="container-fluid">
  <h1 class="mb-4">إضافة اشتراك جديد</h1>

  <form action="{{ route('admin.subscriptions.store') }}" method="POST">
    @csrf

    <div class="form-group">
      <label for="user_id">المستخدم</label>
      <select name="user_id" id="user_id"
              class="form-control @error('user_id') is-invalid @enderror" required>
        <option value="">اختر مستخدمًا</option>
        @foreach($users as $user)
          <option value="{{ $user->id }}"
            {{ old('user_id') == $user->id ? 'selected' : '' }}>
            {{ $user->username }} ({{ $user->email }})
          </option>
        @endforeach
      </select>
      @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label for="plan_id">الباقة</label>
      <select name="plan_id" id="plan_id"
              class="form-control @error('plan_id') is-invalid @enderror" required>
        <option value="">اختر باقة</option>
        @foreach($plans as $plan)
          <option value="{{ $plan->id }}"
            {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
            {{ $plan->name }}
          </option>
        @endforeach
      </select>
      @error('plan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="start_at">تاريخ البدء</label>
        <input type="datetime-local" name="start_at" id="start_at"
               class="form-control @error('start_at') is-invalid @enderror"
               value="{{ old('start_at') }}" required>
        @error('start_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group col-md-6">
        <label for="end_at">تاريخ الانتهاء</label>
        <input type="datetime-local" name="end_at" id="end_at"
               class="form-control @error('end_at') is-invalid @enderror"
               value="{{ old('end_at') }}" required>
        @error('end_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="form-group">
      <label for="status">حالة الاشتراك</label>
      <select name="status" id="status"
              class="form-control @error('status') is-invalid @enderror" required>
        <option value="active"   {{ old('status')=='active'   ? 'selected':'' }}>Active</option>
        <option value="expired"  {{ old('status')=='expired'  ? 'selected':'' }}>Expired</option>
        <option value="canceled" {{ old('status')=='canceled' ? 'selected':'' }}>Canceled</option>
      </select>
      @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label for="platform">المنصة</label>
      <input type="text" name="platform" id="platform"
             class="form-control @error('platform') is-invalid @enderror"
             value="{{ old('platform') }}" placeholder="مثلاً stripe أو google_play" required>
      @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
      <label for="txn_token">رمز التحقق (اختياري)</label>
      <input type="text" name="txn_token" id="txn_token"
             class="form-control @error('txn_token') is-invalid @enderror"
             value="{{ old('txn_token') }}">
      @error('txn_token')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <button type="submit" class="btn btn-success">حفظ الاشتراك</button>
    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">إلغاء</a>
  </form>
</div>
@endsection
