@extends('admin.layouts.admin')

@section('title', 'قائمة المستخدمين')

@section('content')
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>قائمة المستخدمين</h4>
            <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i>أنشاء مستخدم جديد</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-bordered table-striped m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>رقم الهاتف</th>
                            <th>البريد الإلكتروني</th>
                            <th>نوع المستخدم</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email ?? '-' }}</td>
                                <td>{{ $user->is_admin ? 'أدمن' : 'مستخدم' }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="btn btn-sm btn-primary">تعديل</a>

                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-sm btn-info">عرض</a>

                                    @if (auth()->user()->is_admin)<form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('هل تريد حذف هذا المستخدم؟');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">لم يتم العثور على بيانات</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
