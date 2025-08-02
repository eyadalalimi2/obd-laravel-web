@extends('admin.layouts.admin')

@section('title', 'إضافة مستخدم جديد')

@section('content')
<div class="container-fluid">

    <h4 class="mb-4">إضافة مستخدم جديد</h4>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label>الاسم</label>
                    <input type="text" name="username" class="form-control" required value="{{ old('username') }}">
                </div>

                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                </div>

                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label>المسمى الوظيفي</label>
                    <input type="text" name="job_title" class="form-control" value="{{ old('job_title') }}">
                </div>

                <div class="form-group">
                    <label>اسم الباقة</label>
                    <input type="text" name="package_name" class="form-control" value="{{ old('package_name') }}">
                </div>

                <div class="form-group">
                    <label>الخطة الحالية</label>
                    <input type="text" name="current_plan" class="form-control" value="{{ old('current_plan') }}">
                </div>

                <div class="form-group">
                    <label>تاريخ بدء الخطة</label>
                    <input type="date" name="plan_start_date" class="form-control" value="{{ old('plan_start_date') }}">
                </div>

                <div class="form-group">
                    <label>تاريخ تجديد الخطة</label>
                    <input type="date" name="plan_renewal_date" class="form-control" value="{{ old('plan_renewal_date') }}">
                </div>

                <div class="form-group">
                    <label>وضع المستخدم</label>
                    <select name="user_mode" class="form-control">
                        <option value="guest" {{ old('user_mode') == 'guest' ? 'selected' : '' }}>زائر</option>
                        <option value="subscriber" {{ old('user_mode') == 'subscriber' ? 'selected' : '' }}>مشترك</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>الصورة الشخصية</label>
                    <input type="file" name="profile_image" class="form-control-file">
                </div>

                <div class="form-group">
                    <label>كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>الدور</label>
                    <select name="role" class="form-control">
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>مدير</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>مستخدم</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>نوع المستخدم</label>
                    <select name="is_admin" class="form-control" required>
                        <option value="0" {{ old('is_admin') == '0' ? 'selected' : '' }}>مستخدم عادي</option>
                        <option value="1" {{ old('is_admin') == '1' ? 'selected' : '' }}>مسؤول</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>حالة الحساب</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>موقوف</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>تم التحقق من البريد الإلكتروني؟</label>
                    <select name="email_verified_at" class="form-control">
                        <option value="" {{ old('email_verified_at') == '' ? 'selected' : '' }}>لم يتم التحقق</option>
                        <option value="{{ now() }}" {{ old('email_verified_at') ? 'selected' : '' }}>تم التحقق</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-block">إضافة المستخدم</button>
            </form>
        </div>
    </div>

</div>
@endsection
