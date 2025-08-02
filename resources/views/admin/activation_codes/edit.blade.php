@extends('admin.layouts.admin')
@section('content')
<div class="container">
  <h1>تعديل رمز: {{ $activationCode->code }}</h1>

  @if ($errors->any())
    <div class="alert alert-danger">
      <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
  @endif

  <form action="{{ route('admin.activation_codes.update',$activationCode) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="plan_id">الباقة</label>
      <select name="plan_id" id="plan_id" class="form-control" required>
        <option value="">اختر الباقة</option>
        @foreach($plans as $plan)
          <option value="{{ $plan->id }}" {{ old('plan_id',$activationCode->plan_id) == $plan->id ? 'selected' : '' }}>{{ $plan->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="form-group">
      <label for="code">الرمز</label>
      <input type="text" name="code" id="code" class="form-control" value="{{ old('code',$activationCode->code) }}" required>
    </div>
    <div class="form-group">
      <label for="uses_left">مرات الاستخدام</label>
      <input type="number" name="uses_left" id="uses_left" class="form-control" value="{{ old('uses_left',$activationCode->uses_left) }}" min="1" required>
    </div>
    <div class="form-group">
      <label for="expires_at">تاريخ الانتهاء</label>
      <input type="date" name="expires_at" id="expires_at" class="form-control" value="{{ old('expires_at',$activationCode->expires_at?->format('Y-m-d')) }}">
    </div>
    <button class="btn btn-primary">تحديث</button>
  </form>
</div>
@endsection
