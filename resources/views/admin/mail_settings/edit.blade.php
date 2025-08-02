@extends('admin.layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">إعدادات البريد الإلكتروني</h2>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.mail.update') }}">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700">Mailer</label>
            <input type="text" name="mailer" value="{{ old('mailer', $settings->mailer ?? 'smtp') }}" class="w-full p-2 border rounded" />
            @error('mailer')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Host</label>
            <input type="text" name="host" value="{{ old('host', $settings->host ?? '') }}" class="w-full p-2 border rounded" />
            @error('host')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Port</label>
            <input type="number" name="port" value="{{ old('port', $settings->port ?? '') }}" class="w-full p-2 border rounded" />
            @error('port')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Username</label>
            <input type="text" name="username" value="{{ old('username', $settings->username ?? '') }}" class="w-full p-2 border rounded" />
            @error('username')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Password</label>
            <input type="password" name="password" value="{{ old('password', $settings->password ?? '') }}" class="w-full p-2 border rounded" />
            @error('password')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Encryption</label>
            <input type="text" name="encryption" value="{{ old('encryption', $settings->encryption ?? 'tls') }}" class="w-full p-2 border rounded" />
            @error('encryption')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">From Address</label>
            <input type="email" name="from_address" value="{{ old('from_address', $settings->from_address ?? '') }}" class="w-full p-2 border rounded" />
            @error('from_address')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">From Name</label>
            <input type="text" name="from_name" value="{{ old('from_name', $settings->from_name ?? '') }}" class="w-full p-2 border rounded" />
            @error('from_name')<p class="text-red-500 text-sm">{{ $message }}</p>@enderror
        </div>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">حفظ</button>
    </form>
</div>
@endsection