<footer class="bg-light py-4 mt-5">
    <div class="container text-center">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('site.all_rights_reserved') }}</p>
        <p>
            <a href="{{ route('site.page.show', ['slug' => 'privacy-policy']) }}">{{ __('site.privacy_policy') }}</a>
        </p>
        
    </div>
</footer>
