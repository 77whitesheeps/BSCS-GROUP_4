<aside class="main-sidebar">
    <div class="sidebar-content">
        <!-- User Panel -->
        @auth
        <div class="user-panel p-3 border-bottom">
            <div class="d-flex align-items-center">
                <div class="user-image me-3">
                    <i class="fas fa-user-circle fa-2x text-muted"></i>
                </div>
                <div class="user-info">
                    <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                    <small class="text-muted">Online</small>
                </div>
            </div>
        </div>
        @endauth

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#plantingCalculatorMenu" aria-expanded="{{ request()->routeIs('planting.calculator') || request()->routeIs('quincunx.calculator') || request()->routeIs('triangular.calculator') ? 'true' : 'false' }}">
                        <i class="fas fa-calculator"></i>
                        <span>Planting Calculator</span>
                        <i class="fas fa-chevron-down float-end mt-1"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('planting.calculator') || request()->routeIs('quincunx.calculator') || request()->routeIs('triangular.calculator') ? 'show' : '' }}" id="plantingCalculatorMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="{{ route('planting.calculator') }}" class="d-block py-2 {{ request()->routeIs('planting.calculator') ? 'text-primary' : '' }}"><i class="fas fa-th me-2"></i>Square</a></li>
                            <li><a href="{{ route('quincunx.calculator') }}" class="d-block py-2 {{ request()->routeIs('quincunx.calculator') ? 'text-primary' : '' }}"><i class="fas fa-th-large me-2"></i>Quincunx</a></li>
                            <li><a href="{{ route('triangular.calculator') }}" class="d-block py-2 {{ request()->routeIs('triangular.calculator') ? 'text-primary' : '' }}"><i class="fas fa-play me-2"></i>Triangular</a></li>
                        </ul>
                    </div>
                </li>



                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#calculationsMenu" aria-expanded="{{ request()->routeIs('calculations.*') ? 'true' : 'false' }}">
                        <i class="fas fa-chart-line"></i>
                        <span>Calculations</span>
                        <i class="fas fa-chevron-down float-end mt-1"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('calculations.*') ? 'show' : '' }}" id="calculationsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="{{ route('calculations.history') }}" class="d-block py-2 {{ request()->routeIs('calculations.history') ? 'text-primary' : '' }}"><i class="fas fa-history me-2"></i>History</a></li>
                            <li><a href="{{ route('calculations.saved') }}" class="d-block py-2 {{ request()->routeIs('calculations.saved') ? 'text-primary' : '' }}"><i class="fas fa-save me-2"></i>Saved Calculations</a></li>
                            <li><a href="{{ route('calculations.export') }}" class="d-block py-2 {{ request()->routeIs('calculations.export') ? 'text-primary' : '' }}"><i class="fas fa-download me-2"></i>Export</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu" aria-expanded="false">
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                        <i class="fas fa-chevron-down float-end mt-1"></i>
                    </a>
                    <div class="collapse" id="reportsMenu">
                        <ul class="list-unstyled ps-4">
                                            <li><a href="{{ route('monthly-reports.index') }}" class="d-block py-2"><i class="fas fa-calendar me-2"></i>Monthly Report</a></li>
                        </ul>
                    </div>
                </li>

                <li class="{{ request()->routeIs('garden.planner') ? 'active' : '' }}">
                    <a href="{{ route('garden.planner') }}">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Garden Planner</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#toolsMenu" aria-expanded="{{ request()->routeIs('tools.*') ? 'true' : 'false' }}">
                        <i class="fas fa-tools"></i>
                        <span>Tools</span>
                        <i class="fas fa-chevron-down float-end mt-1"></i>
                    </a>
                    <div class="collapse {{ request()->routeIs('tools.*') ? 'show' : '' }}" id="toolsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="{{ route('tools.weather') }}" class="d-block py-2 {{ request()->routeIs('tools.weather') ? 'text-primary' : '' }}"><i class="fas fa-cloud-sun me-2"></i>Current Weather</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#settingsMenu" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                        <i class="fas fa-chevron-down float-end mt-1"></i>
                    </a>
                    <div class="collapse" id="settingsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="{{ route('profile.edit') }}" class="d-block py-2"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a href="{{ route('preferences') }}" class="d-block py-2"><i class="fas fa-sliders-h me-2"></i>Preferences</a></li>
                        </ul>
                    </div>
                </li>

                <li class="{{ request()->routeIs('help.support') ? 'active' : '' }}">
                    <a href="{{ route('help.support') }}">
                        <i class="fas fa-question-circle"></i>
                        <span>Help & Support</span>
                    </a>
                </li>

                <!-- Logout for Mobile -->
                <li class="d-lg-none border-top">
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link text-start w-100 border-0 bg-transparent p-3">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<style>
/* Additional sidebar styles */
.sidebar-menu .collapse .list-unstyled a {
    color: #6c757d;
    text-decoration: none;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.sidebar-menu .collapse .list-unstyled a:hover {
    color: var(--plant-green);
    background-color: var(--plant-green-light);
    border-radius: 5px;
    margin: 0 10px;
}

.sidebar-menu li a[data-bs-toggle="collapse"] .fa-chevron-down {
    transition: transform 0.3s ease;
}

.sidebar-menu li a[data-bs-toggle="collapse"][aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
}

.user-panel {
    background: linear-gradient(135deg, var(--plant-green-light), #f8f9fa);
}
</style>