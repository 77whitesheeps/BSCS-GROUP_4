<nav class="navbar navbar-expand-lg main-header">
    <div class="container-fluid">
        <!-- Desktop Sidebar Collapse Toggle -->
        <button class="sidebar-toggle sidebar-toggle-desktop me-2 d-none d-lg-inline btn btn-sm btn-outline-light px-2" type="button" title="Toggle sidebar (collapse)">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Sidebar Open Toggle -->
        <button class="sidebar-toggle-mobile d-inline d-lg-none btn btn-sm btn-outline-light px-2 me-2" type="button" title="Open menu">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Brand/Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('dashboard') }}">
            <i class="fas fa-seedling me-2"></i>
            Plant-O-Matic
        </a>

    <!-- Spacer for alignment -->

        <!-- Right Side Navbar -->
    <div class="navbar-nav ms-auto d-flex align-items-center gap-2">
            @auth
                <!-- Notifications Dropdown -->
                <div class="nav-item dropdown me-3" id="notifDropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge bg-danger badge-sm d-none" id="notifBadge">0</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" style="min-width: 280px;">
                        <li><h6 class="dropdown-header">Notifications</h6></li>
                        <div id="notifItems">
                            <li class="px-3 py-2 text-muted small">No notifications</li>
                        </div>
                        <li><hr class="dropdown-divider"></li>
                        <li class="d-flex">
                            <a class="dropdown-item text-center flex-fill" href="{{ route('notifications.index') }}">View all</a>
                            <a class="dropdown-item text-center flex-fill" href="#" id="markAllLink">Mark all read</a>
                        </li>
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
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('preferences') }}"><i class="fas fa-cog me-2"></i>Settings</a></li>
                        <li><a class="dropdown-item" href="{{ route('calculations.history') }}"><i class="fas fa-calculator me-2"></i>My Calculations</a></li>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
    const badge = document.getElementById('notifBadge');
    const itemsContainer = document.getElementById('notifItems');
    const markAll = document.getElementById('markAllLink');

    function render(items){
        itemsContainer.innerHTML = '';
        if(!items || items.length === 0){
            itemsContainer.innerHTML = '<li class="px-3 py-2 text-muted small">No notifications</li>';
            return;
        }
        items.forEach(n => {
            const icon = n.icon || 'info-circle';
            const url = n.url || '#';
            const li = document.createElement('li');
            li.innerHTML = `<a class="dropdown-item d-flex align-items-center" href="${url}" data-id="${n.id}">
                    <i class="fas fa-${icon} me-2"></i>
                    <span>${n.title}</span>
                </a>`;
            itemsContainer.appendChild(li);
            li.querySelector('a').addEventListener('click', function(e){
                // mark as read then follow link
                fetch(`{{ url('/notifications') }}/${n.id}/read`, {method:'POST', headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
                    .then(()=>{ if(url && url !== '#'){ window.location.href = url; } });
            });
        });
    }

    function load(){
        fetch('{{ route('notifications.fetch') }}')
            .then(r=>r.json())
            .then(data => {
                const unread = data.unread || 0;
                if(unread > 0){ badge.classList.remove('d-none'); badge.textContent = unread; } else { badge.classList.add('d-none'); }
                render(data.items || []);
            })
            .catch(()=>{});
    }

    load();
    // Refresh occasionally
    setInterval(load, 60000);

    markAll?.addEventListener('click', function(e){
        e.preventDefault();
        fetch('{{ route('notifications.readAll') }}', {method:'POST', headers:{'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content}})
            .then(()=>load());
    });
});
</script>
@endpush
