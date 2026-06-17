<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Fadino Web</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Search') }}</li>
            <li class="p-3">
                <form action="/search" method="GET">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="{{ __('Search movies') }}" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </form>
            </li>
            
            <li class="menu-header">{{ __('Dashboard') }}</li>
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-home"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="dropdown {{ Request::is('search') || Request::is('favorites') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown">
                    <i class="fas fa-fire"></i>
                    <span>{{ __('Movies') }}</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="/search">{{ __('Search Movie') }}</a></li>
                    <li><a class="nav-link" href="/favorites">{{ __('My Favorites') }}</a></li>
                </ul>
            </li>
        </ul>
    </aside>
</div>