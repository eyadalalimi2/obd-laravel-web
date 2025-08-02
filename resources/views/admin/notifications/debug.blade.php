@extends('admin.layouts.admin')

@section('content')
    <div class="container mt-4">
        <h3 class="mb-4">🔔 قائمة الإشعارات (للتجربة والاختبار)</h3>
        <div class="mb-3 text-right">
            <a href="{{ route('admin.notifications.create') }}" class="btn btn-success">
                ➕ إرسال إشعار جديد
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($notifications->isEmpty())
            <div class="alert alert-info">لا توجد إشعارات حالياً.</div>
        @else
            <table class="table table-bordered table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>العنوان</th>
                        <th>المحتوى</th>
                        <th>النوع</th>
                        <th>عدد المستلمين</th>
                        <th>تاريخ الإرسال</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($notifications as $i => $notification)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $notification->title }}</td>
                            <td>{{ Str::limit($notification->message, 40) }}</td>
                            <td>
                                <span class="badge"
                                    style="background-color: {{ $notification->type === 'error' ? '#dc3545' : ($notification->type === 'warning' ? '#ffc107' : '#17a2b8') }}">
                                    {{ $notification->type ?? 'غير محدد' }}
                                </span>
                            </td>
                            <td>
                                <a href="#" data-toggle="modal" data-target="#usersModal{{ $notification->id }}">
                                    {{ $notification->users->count() }} مستخدم
                                </a>
                            </td>
                            <td>{{ $notification->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                    onsubmit="return confirm('هل أنت متأكد من حذف هذا الإشعار؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">🗑 حذف</button>
                                </form>
                            </td>
                        </tr>

                        <!-- Modal - المستخدمين -->
                        <div class="modal fade" id="usersModal{{ $notification->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="usersModalLabel{{ $notification->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">المستخدمين المستلمين</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="إغلاق">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group">
                                            @foreach ($notification->users as $user)
                                                <li class="list-group-item">
                                                    👤 {{ $user->username ?? ($user->email ?? 'غير معروف') }}
                                                    <span
                                                        class="badge badge-secondary float-right">{{ $user->id }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
