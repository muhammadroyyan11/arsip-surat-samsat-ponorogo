<nav id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-archive text-primary me-2"></i> Arsip Surat
    </div>
    <ul class="list-unstyled components">
        <li class="{{ request()->is('/') || request()->is('dashboard') ? 'active' : '' }}">
            <a href="/"><i class="fas fa-home"></i> Dashboard</a>
        </li>
        @if(isset($sidebar_sections))
            @foreach($sidebar_sections as $section)
                @if($section->menus->count() > 0)
                    <li class="menu-section">{{ $section->section_name }}</li>
                    @foreach($section->menus as $menu)
                        @php $routePrefix = explode('.', $menu->url)[0]; @endphp
                        <li class="{{ request()->is($routePrefix.'*') ? 'active' : '' }}">
                            <a href="{{ Route::has($menu->url) ? route($menu->url) : url($routePrefix) }}">
                                <i class="{{ $menu->icon ?? 'fas fa-circle' }}"></i> {{ $menu->menu_name }}
                            </a>
                        </li>
                    @endforeach
                @endif
            @endforeach
        @endif
    </ul>
</nav>
