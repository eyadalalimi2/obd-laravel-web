<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('site.home') }}">
            <img src="{{ asset('images/logo_web.png') }}"
                 alt="{{ config('app.name') }}"
                 style="height: 40px; vertical-align: middle;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ app()->getLocale() == 'ar' ? 'العربية' : 'English' }}
                    </a>
                    <ul class="dropdown-menu">
                        @if (app()->getLocale() != 'en')
                            <li><a class="dropdown-item"
                                    href="{{ route('site.language.switch', ['locale' => 'en']) }}">English</a></li>
                        @endif
                        @if (app()->getLocale() != 'ar')
                            <li><a class="dropdown-item"
                                    href="{{ route('site.language.switch', ['locale' => 'ar']) }}">العربية</a></li>
                        @endif
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link"
                        href="{{ route('site.codes') }}">{{ __('site.start_search') }}</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="{{ route('site.categories') }}">{{ __('site.categories') }}</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.posts') }}">{{ __('site.blog') }}</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('site.faq') }}">{{ __('site.faq') }}</a></li>
                <li class="nav-item"><a class="nav-link"
                        href="{{ route('site.page.show', ['slug' => 'about']) }}">{{ __('site.about_us') }}</a></li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('site.login.form') }}">{{ __('site.login') }} / {{ __('site.register') }}</a>
                    </li>
                    
                @else
                <li class="nav-item">
        <a class="nav-link"
           href="{{ route('profile.show') }}">
           {{ __('site.profile') }}
        </a>
    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('site.logout') }}">
                            @csrf
                            <button type="submit" class="nav-link btn btn-link">{{ __('site.logout') }}</button>
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
