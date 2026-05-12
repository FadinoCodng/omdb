<nav class="navbar navbar-expand-lg main-navbar">
    <form class="form-inline mr-auto">
        <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
        </ul>
    </form>
    <ul class="navbar-nav navbar-right">

        {{-- Dropdown Bahasa --}}
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user" aria-expanded="false">
                <div class="d-sm-none d-lg-inline-block">
                    <i class="fas fa-globe"></i>
                    {{ strtoupper(app()->getLocale()) }}
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('lang.switch', 'en') }}"
                   class="dropdown-item has-icon {{ app()->getLocale() == 'en' ? 'text-primary' : '' }}">
                    <i class="fas fa-check-circle"></i> English
                </a>
                <a href="{{ route('lang.switch', 'id') }}"
                   class="dropdown-item has-icon {{ app()->getLocale() == 'id' ? 'text-primary' : '' }}">
                    <i class="fas fa-check-circle"></i> Bahasa Indonesia
                </a>
            </div>
        </li>

        {{-- Dropdown User --}}
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}" class="rounded-circle mr-1">
                <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <div class="dropdown-title">{{ __('Logged in') }} 5 min ago</div>
                <a href="features-profile.html" class="dropdown-item has-icon">
                    <i class="far fa-user"></i> {{ __('Profile') }}
                </a>
                <a href="features-activities.html" class="dropdown-item has-icon">
                    <i class="fas fa-bolt"></i> {{ __('Activities') }}
                </a>
                <a href="features-settings.html" class="dropdown-item has-icon">
                    <i class="fas fa-cog"></i> {{ __('Settings') }}
                </a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item has-icon text-danger"
                            style="background:none; border:none; width:100%; text-align:left; cursor:pointer;">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </li>

    </ul>
</nav>