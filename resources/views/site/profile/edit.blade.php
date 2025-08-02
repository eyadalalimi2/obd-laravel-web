@extends('site.layouts.site')
@section('title', __('site.edit_profile'))

@section('content')
<div class="card">
  <div class="card-header">{{ __('site.edit_profile') }}</div>
  <div class="card-body">
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf
      @method('PUT')

      {{-- Username --}}
      <div class="mb-3">
        <label for="username" class="form-label">{{ __('site.username') }}</label>
        <input id="username" name="username" type="text"
               value="{{ old('username', $user->username) }}"
               class="form-control @error('username') is-invalid @enderror">
        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Email --}}
      <div class="mb-3">
        <label for="email" class="form-label">{{ __('site.email') }}</label>
        <input id="email" name="email" type="email"
               value="{{ old('email', $user->email) }}"
               class="form-control @error('email') is-invalid @enderror">
        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Phone --}}
      <div class="mb-3">
        <label for="phone" class="form-label">{{ __('site.phone') }}</label>
        <input id="phone" name="phone" type="text"
               value="{{ old('phone', $user->phone) }}"
               class="form-control @error('phone') is-invalid @enderror">
        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Job Title --}}
      <div class="mb-3">
        <label for="job_title" class="form-label">{{ __('site.job_title') }}</label>
        <input id="job_title" name="job_title" type="text"
               value="{{ old('job_title', $user->job_title) }}"
               class="form-control @error('job_title') is-invalid @enderror">
        @error('job_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Profile Image --}}
      <div class="mb-3">
        <label for="profile_image" class="form-label">{{ __('site.profile_image') }}</label>
        <input id="profile_image" name="profile_image" type="file"
               class="form-control @error('profile_image') is-invalid @enderror">
        @error('profile_image') <div class="invalid-feedback">{{ $message }}</div> @enderror

        @if($user->profile_image)
          <img src="{{ asset('storage/'.$user->profile_image) }}"
               class="mt-2" width="100" alt="Current Image">
        @endif
      </div>

      {{-- Password --}}
      <div class="mb-3">
        <label for="password" class="form-label">{{ __('site.password') }}</label>
        <input id="password" name="password" type="password"
               class="form-control @error('password') is-invalid @enderror">
        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
      </div>

      {{-- Password Confirmation --}}
      <div class="mb-3">
        <label for="password_confirmation" class="form-label">{{ __('site.confirm_password') }}</label>
        <input id="password_confirmation" name="password_confirmation" type="password"
               class="form-control">
      </div>

      <button type="submit" class="btn btn-success">
        {{ __('site.save') }}
      </button>
    </form>
  </div>
</div>
@endsection