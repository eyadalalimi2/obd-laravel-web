@extends('site.layouts.site')

@section('title', __('site.profile'))

@section('content')
<div class="card">
  <div class="card-header">
    {{ __('site.profile') }}
    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary float-end">
      {{ __('site.edit_profile') }}
    </a>
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-3">
        @if($user->profile_image)
          <img src="{{ asset('storage/'.$user->profile_image) }}"
               class="img-fluid rounded"
               alt="Profile Image">
        @else
          <img src="{{ asset('images/default-avatar.png') }}"
               class="img-fluid rounded"
               alt="Default Avatar">
        @endif
      </div>
      <div class="col-md-9">
        <p><strong>{{ __('site.username') }}:</strong> {{ $user->username }}</p>
        <p><strong>{{ __('site.email') }}:</strong> {{ $user->email }}</p>
        <p><strong>{{ __('site.phone') }}:</strong> {{ $user->phone ?? '-' }}</p>
        <p><strong>{{ __('site.job_title') }}:</strong> {{ $user->job_title ?? '-' }}</p>
      </div>
    </div>
  </div>
</div>
@endsection