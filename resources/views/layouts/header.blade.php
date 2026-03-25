<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-light d-md-none">
            <i class="fas fa-align-left"></i>
        </button>
        <div class="ms-auto d-flex align-items-center">
            @auth
            <div class="dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center text-dark text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=007bff&color=fff" class="rounded-circle me-2" width="32" height="32" alt="User Avatar">
                    <span class="d-none d-md-inline fw-semibold">{{ auth()->user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" aria-labelledby="userDropdown">
                    <li><h6 class="dropdown-header">Welcome, {{ auth()->user()->name }}!</h6></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-muted"></i> Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ Route::has('logout') ? route('logout') : '/logout' }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2"></i> Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth
        </div>
    </div>
</nav>
