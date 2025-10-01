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
                
                <li class="{{ request()->routeIs('planting.calculator') ? 'active' : '' }}">
                    <a href="{{ route('planting.calculator') }}">
                        <i class="fas fa-calculator"></i>
                        <span>Planting Calculator</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#plantsMenu" aria-expanded="false">
                        <i class="fas fa-seedling"></i>
                        <span>Plants</span>
                        <i class="fas fa-chevron-right float-end mt-1"></i>
                    </a>
                    <div class="collapse" id="plantsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="#" class="d-block py-2"><i class="fas fa-plus-circle me-2"></i>Add Plant</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-list me-2"></i>Plant Library</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-chart-bar me-2"></i>Plant Statistics</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#calculationsMenu" aria-expanded="false">
                        <i class="fas fa-chart-line"></i>
                        <span>Calculations</span>
                        <i class="fas fa-chevron-right float-end mt-1"></i>
                    </a>
                    <div class="collapse" id="calculationsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="#" class="d-block py-2"><i class="fas fa-history me-2"></i>History</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-save me-2"></i>Saved Calculations</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-download me-2"></i>Export</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#reportsMenu" aria-expanded="false">
                        <i class="fas fa-file-alt"></i>
                        <span>Reports</span>
                        <i class="fas fa-chevron-right float-end mt-1"></i>
                    </a>
                    <div class="collapse" id="reportsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="#" class="d-block py-2"><i class="fas fa-chart-pie me-2"></i>Usage Statistics</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-calendar me-2"></i>Monthly Report</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-print me-2"></i>Print Reports</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Garden Planner</span>
                    </a>
                </li>

                <li>
                    <a href="#">
                        <i class="fas fa-tools"></i>
                        <span>Tools</span>
                    </a>
                </li>

                <li>
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#settingsMenu" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                        <i class="fas fa-chevron-right float-end mt-1"></i>
                    </a>
                    <div class="collapse" id="settingsMenu">
                        <ul class="list-unstyled ps-4">
                            <li><a href="#" class="d-block py-2"><i class="fas fa-user me-2"></i>Profile</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-key me-2"></i>Change Password</a></li>
                            <li><a href="#" class="d-block py-2"><i class="fas fa-sliders-h me-2"></i>Preferences</a></li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#">
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

.sidebar-menu li a[data-bs-toggle="collapse"] .fa-chevron-right {
    transition: transform 0.3s ease;
}

.sidebar-menu li a[data-bs-toggle="collapse"][aria-expanded="true"] .fa-chevron-right {
    transform: rotate(90deg);
}

.user-panel {
    background: linear-gradient(135deg, var(--plant-green-light), #f8f9fa);
}
</style>
