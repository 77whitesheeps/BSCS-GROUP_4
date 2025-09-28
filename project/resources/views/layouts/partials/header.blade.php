<nav class="navbar navbar-expand-lg main-header">
    <div class="container-fluid">
        <!-- Sidebar Toggle Button -->
        <button class="sidebar-toggle me-3">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <i class="fas fa-seedling me-2"></i>
            Plant-O-Matic
        </a>

        <!-- Mobile Sidebar Toggle -->
        <button class="navbar-toggler d-lg-none mobile-sidebar-toggle" type="button">
            <i class="fas fa-bars text-white"></i>
        </button>

        <!-- Right Side Navbar -->
        <div class="navbar-nav ms-auto d-flex align-items-center">
            @auth
                <!-- Notifications Dropdown -->
                <div class="nav-item dropdown me-3">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger badge-sm">3</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-info-circle me-2"></i>New calculation saved</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-leaf me-2"></i>Plant spacing updated</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-chart-line me-2"></i>Weekly report ready</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-center" href="#">View all notifications</a></li>
                    </ul>
                </div>

                <!-- User Profile Dropdown -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown">
                        <div class="user-avatar me-2">
                            <i class="fas fa-user-circle fa-lg"></i>
                        </div>
                        <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="dropdown-header">
                                <strong>{{ auth()->user()->name }}</strong><br>
                                <small class="text-muted">{{ auth()->user()->email }}</small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="fas fa-calculator me-2"></i>My Calculations</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="dropdown-item p-0">
                                @csrf
                                <button type="submit" class="btn btn-link dropdown-item text-start w-100 border-0 bg-transparent">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <!-- Guest Links -->
                <div class="navbar-nav">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Login
                    </a>
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
