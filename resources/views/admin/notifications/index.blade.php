@extends('admin.layouts.admin')

@section('content')
<div class="container">
    <h1 class="mb-4">الإشعارات الذكية</h1>

    {{-- 1) نموذج إنشاء إشعار جديد --}}
    <div class="card mb-5">
        <div class="card-header">إنشاء إشعار جديد</div>
        <div class="card-body">
            <form action="{{ route('admin.notifications.store') }}" method="POST">
                @csrf

                {{-- عنوان الإشعار --}}
                <div class="form-group">
                    <label for="title">العنوان</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        class="form-control @error('title') is-invalid @enderror"
                        value="{{ old('title') }}"
                        required
                    >
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- نصّ الإشعار --}}
                <div class="form-group">
                    <label for="message">الرسالة</label>
                    <textarea
                        name="message"
                        id="message"
                        class="form-control @error('message') is-invalid @enderror"
                        rows="3"
                        required
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- اختيار نوع الإشعار (مربعات ملونة) --}}
                <div class="form-group">
                    <label>نوع الإشعار</label>
                    <div class="d-flex flex-wrap">
                        @foreach($types as $key => $type)
                            <label class="type-box mr-2 mb-2" style="background: {{ $type['color'] }}">
                                <input
                                    type="radio"
                                    name="type"
                                    value="{{ $key }}"
                                    {{ old('type') === (string)$key ? 'checked' : '' }}
                                >
                                <span>{{ $type['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('type')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                {{-- خيار الإرسال لكل المستخدمين --}}
                <div class="form-group form-check">
                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="send_to_all"
                        id="send_to_all"
                        value="1"
                        {{ old('send_to_all') ? 'checked' : '' }}
                    >
                    <label class="form-check-label" for="send_to_all">
                        أرسل إلى جميع المستخدمين
                    </label>
                </div>

                {{-- اختيار مستخدمين محدّدين --}}
                <div
                    class="form-group"
                    id="user-selector"
                    style="{{ old('send_to_all') ? 'display:none' : '' }}"
                >
                    <label for="user_ids">اختر المستخدمين</label>
                    <select
                        name="user_ids[]"
                        id="user_ids"
                        class="form-control @error('user_ids') is-invalid @enderror"
                        multiple
                    >
                        @foreach($users as $user)
                            <option
                                value="{{ $user->id }}"
                                {{ in_array($user->id, old('user_ids', [])) ? 'selected' : '' }}
                            >
                                {{ $user->username }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_ids')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">حفظ الإشعار</button>
            </form>
        </div>
    </div>

    {{-- 2) قائمة الإشعارات الموجودة --}}
    <div class="card">
        <div class="card-header">قائمة الإشعارات</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>العنوان</th>
                        <th>الرسالة</th>
                        <th>النوع</th>
                        <th>المستخدمون</th>
                        <th>تاريخ الإنشاء</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notifications as $notif)
                        <tr>
                            <td>{{ $notif->title }}</td>
                            <td>{{ Str::limit($notif->message, 50) }}</td>
                            <td>
                                <span
                                    class="badge"
                                    style="background: {{ $types[$notif->type]['color'] }}"
                                >
                                    {{ $types[$notif->type]['label'] }}
                                </span>
                            </td>
                            <td>
                                @if($notif->send_to_all)
                                    الجميع
                                @else
                                    {{ $notif->users->pluck('username')->join('، ') }}
                                @endif
                            </td>
                            <td>{{ $notif->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form
                                    action="{{ route('admin.notifications.destroy', $notif->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('هل أنت متأكد؟')"
                                >
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-danger">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center">لا توجد إشعارات</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
    .type-box {
        position: relative;
        padding: 10px 15px;
        border-radius: 4px;
        color: #fff;
        cursor: pointer;
        user-select: none;
    }
    .type-box input {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        opacity: 0;
        cursor: pointer;
    }
    .type-box input:checked + span {
        box-shadow: 0 0 0 3px rgba(0,0,0,0.3);
    }
</style>
@endpush

@push('scripts')
<script>
    document.getElementById('send_to_all').addEventListener('change', function(){
        document.getElementById('user-selector').style.display = this.checked ? 'none' : 'block';
    });
</script>
@endpush
