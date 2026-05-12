<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Fadino Web</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">{{ __('Dashboard') }}</li>
            <li class="dropdown active">
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