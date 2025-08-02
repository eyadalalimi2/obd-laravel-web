@extends('admin.layouts.admin')

@section('content')
<div class="container">
  <h1>تعديل الاشتراك #{{ $subscription->id }}</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.subscriptions.update', $subscription) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
      <label for="user_id">المستخدم</label>
      <select name="user_id" id="user_id" class="form-control" required>
        @foreach($users as $user)
          <option value="{{ $user->id }}" {{ old('user_id', $subscription->user_id) == $user->id ? 'selected' : '' }}>
            {{ $user->username }} ({{ $user->email }})
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="plan_id">الباقة</label>
      <select name="plan_id" id="plan_id" class="form-control" required>
        @foreach($plans as $plan)
          <option value="{{ $plan->id }}" {{ old('plan_id', $subscription->plan_id) == $plan->id ? 'selected' : '' }}>
            {{ $plan->name }}
          </option>
        @endforeach
      </select>
    </div>

    <div class="form-group">
      <label for="start_at">تاريخ البدء</label>
      <input type="datetime-local" name="start_at" id="start_at" class="form-control"
             value="{{ old('start_at', $subscription->start_at->format('Y-m-d\TH:i')) }}" required>
    </div>

    <div class="form-group">
      <label for="end_at">تاريخ الانتهاء</label>
      <input type="datetime-local" name="end_at" id="end_at" class="form-control"
             value="{{ old('end_at', $subscription->end_at->format('Y-m-d\TH:i')) }}" required>
    </div>

     <div class="form-row">
      <div class="form-group col-md-4">
        <label for="status">الحالة</label>
        <select name="status" id="status"
          class="form-control @error('status') is-invalid @enderror">
          @foreach(['active'=>'نشط','expired'=>'منتهي','canceled'=>'ملغي'] as $value => $label)
            <option value="{{ $value }}"
              {{ old('status', $subscription->status) == $value ? 'selected' : '' }}>
              {{ $label }}
            </option>
          @endforeach
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group col-md-4">
        <label for="platform">المنصة</label>
        <input type="text" name="platform" id="platform"
          class="form-control @error('platform') is-invalid @enderror"
          value="{{ old('platform', $subscription->platform) }}">
        @error('platform')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
      <div class="form-group col-md-4">
        <label for="txn_token">رمز الدفع</label>
        <input type="text" name="txn_token" id="txn_token"
          class="form-control @error('txn_token') is-invalid @enderror"
          value="{{ old('txn_token', $subscription->txn_token) }}">
        @error('txn_token')<div class="invalid-feedback">{{ $message }}</div>@enderror
      </div>
    </div>
    <button class="btn btn-primary">تحديث</button>
    <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-secondary">إلغاء</a>
  </form>
</div>
@endsection
