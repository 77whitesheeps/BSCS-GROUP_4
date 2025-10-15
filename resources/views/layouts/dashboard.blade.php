<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Plant-O-Matic</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Dark Theme CSS -->
    <link href="{{ asset('assets/css/dark-theme.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --plant-green: #68af2c;
            --plant-green-dark: #5a9625;
            --plant-green-light: #eaf5e1;
            --sidebar-width: 250px;
            --header-height: 85px; /* Increased to ensure header background covers profile icon */
            --footer-height: 50px;
            /* Light theme colors */
            --bg-color: #f8f9fa;
            --text-color: #212529;
            --card-bg: #ffffff;
            --sidebar-bg: #ffffff;
            --border-color: #dee2e6;
        }

        /* Dark theme colors */
        .dark-theme {
            --bg-color: #1a1a1a;
            --text-color: #ffffff;
            --card-bg: #2d2d2d;
            --sidebar-bg: #2d2d2d;
            --border-color: #404040;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Header Styles */
        .main-header {
            /* Use min-height so the green background always covers contents if they grow */
            min-height: var(--header-height);
            display: flex;
            align-items: center; /* vertically center icons/text */
            padding-top: 4px; /* small breathing space so icons fully sit inside */
            padding-bottom: 4px;
            background: linear-gradient(135deg, var(--plant-green), var(--plant-green-dark));
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        /* Keep header content on one straight line and allow safe shrinking */
        .main-header .container-fluid {
            display: flex;
            align-items: center;
            gap: .5rem;
            flex-wrap: nowrap; /* prevent wrapping under the header */
            min-width: 0; /* allow flex items to shrink */
        }

        .main-header .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
            white-space: nowrap; /* keep title in one line */
            margin-right: .25rem;
            /* Keep the brand visible and avoid being pushed out */
            flex: 0 0 auto;
        }

        .main-header .navbar-nav .nav-link {
            color: white !important;
            padding: .25rem .5rem; /* slightly tighter to save space */
        }

        .main-header .navbar-nav .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background: var(--card-bg);
            color: var(--text-color);
            z-index: 2000; /* ensure it appears above sidebar */
        }

        .main-header .navbar-nav .dropdown-menu .dropdown-item {
            color: var(--text-color);
        }

        .main-header .navbar-nav .dropdown-menu .dropdown-item:hover {
            background: var(--bg-color);
        }

        /* Sidebar Styles */
        .main-sidebar {
            position: fixed;
            top: var(--header-height);
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - var(--header-height));
            background: var(--sidebar-bg);
            border-right: 1px solid var(--border-color);
            overflow-y: auto;
            z-index: 1020;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .main-sidebar {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-menu li {
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-menu li a {
            display: block;
            padding: 15px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .sidebar-menu li a:hover,
        .sidebar-menu li.active a {
            background: var(--plant-green-light);
            color: var(--plant-green);
            border-right: 3px solid var(--plant-green);
        }

        .sidebar-menu li a i {
            width: 20px;
            margin-right: 10px;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: var(--header-height);
            min-height: calc(100vh - var(--header-height) - var(--footer-height));
            padding: 20px;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .main-content {
            margin-left: 0;
        }

        /* Footer Styles */
        .main-footer {
            margin-left: var(--sidebar-width);
            margin-top: 0;
            height: var(--footer-height);
            background: var(--card-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-color);
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .main-footer {
            margin-left: 0;
        }

        /* Toggle Button */
        .sidebar-toggle {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            padding: .25rem .5rem;
        }

        /* Sidebar overlay (mobile) */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.45);
            z-index: 1015;
            opacity: 0;
            pointer-events: none;
            transition: opacity .3s ease;
        }
        .sidebar-mobile-open .sidebar-overlay { opacity: 1; pointer-events: auto; }

        /* Responsive refinements */
        @media (max-width: 991.98px) { /* Bootstrap lg breakpoint */
            body { font-size: 15px; }
            .main-sidebar { margin-left: calc(-1 * var(--sidebar-width)); box-shadow: 4px 0 12px rgba(0,0,0,0.15); }
            .main-content, .main-footer { margin-left: 0; padding: 15px; }
            .sidebar-mobile-open .main-sidebar { margin-left: 0; }
            .main-header .navbar-brand { font-size: 1.25rem; }
            .breadcrumb { display: none; }
        }

        @media (max-width: 575.98px) { /* xs */
            h1, .h1 { font-size: 1.35rem; }
            h2, .h2 { font-size: 1.2rem; }
            .card-dashboard { margin-bottom: 1rem; }
        }

        /* Utility */
        .table-responsive { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        .responsive-grid { display: grid; gap: 1rem; }
        @media (min-width: 576px) { .responsive-grid.cols-sm-2 { grid-template-columns: repeat(2, 1fr); } }
        @media (min-width: 768px) { .responsive-grid.cols-md-3 { grid-template-columns: repeat(3, 1fr); } }
        @media (min-width: 992px) { .responsive-grid.cols-lg-4 { grid-template-columns: repeat(4, 1fr); } }

        /* Right-side nav should stay horizontal */
    .main-header .navbar-nav { flex-direction: row; align-items: center; justify-content: flex-end; flex: 1 1 auto; gap: .25rem; }
        .main-header .navbar-nav .nav-item { position: relative; }
        .main-header .navbar-nav .badge {
            position: absolute;
            top: 2px;
            right: 0;
            transform: translate(60%, -60%);
            font-size: .7rem;
        }

        /* Make dropdowns fully visible on very small screens */
        @media (max-width: 575.98px) {
            .main-header .navbar-brand { font-size: 1.05rem; }
            /* Use fixed positioning so the menu doesn't get clipped and fits the viewport */
            .main-header .dropdown-menu {
                position: fixed;
                top: calc(var(--header-height) - 2px);
                right: .5rem;
                left: .5rem;
                width: auto;
                max-width: calc(100vw - 1rem);
                max-height: calc(100vh - var(--header-height) - 1rem);
                overflow-y: auto;
            }
            /* Tighten spacing and scale icons so brand never disappears */
            .main-header .container-fluid { gap: .25rem; }
            .main-header .navbar-nav { gap: .15rem; }
            .main-header .navbar-nav .nav-link { padding: .15rem .35rem; }
            .main-header .navbar-nav .fa-bell,
            .main-header .navbar-nav .fa-user-circle { font-size: 1rem; }
            .main-header .navbar-nav .badge { transform: translate(40%, -60%); font-size: .6rem; }
            /* Hide the dropdown caret to save width */
            .main-header .nav-link.dropdown-toggle::after { display: none; }
            /* Reduce extra margin on notifications item */
            .main-header .navbar-nav .nav-item.me-3 { margin-right: .25rem !important; }
        }

        /* Custom Components */
        .card-dashboard {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            background: var(--card-bg);
            color: var(--text-color);
            transition: transform 0.2s ease;
        }
        .card-dashboard:hover { transform: translateY(-2px); }
        .btn-plant { background-color: var(--plant-green); border-color: var(--plant-green); color: #fff; }
        .btn-plant:hover { background-color: var(--plant-green-dark); border-color: var(--plant-green-dark); color: #fff; }
        .alert-dismissible .btn-close { padding: 0.5rem 0.5rem; }
        /* Breadcrumb Styles */
        .breadcrumb { background: transparent; margin-bottom: 1.5rem; padding: 0; }
        .breadcrumb-item a { color: var(--text-color); text-decoration: none; }
        .breadcrumb-item.active { color: var(--text-color); }
    </style>
    @php($viteManifest = public_path('build/manifest.json'))
    @if (file_exists($viteManifest))
        {{-- Vite (Tailwind & App Assets) --}}
        @vite(['resources/css/app.css','resources/js/app.js'])
    @else
        <!-- Vite manifest not found. Run: npm install && npm run build (or npm run dev) to generate assets. -->
    @endif
    
    @stack('styles')
</head>
<body class="{{ auth()->check() && auth()->user()->theme === 'dark' ? 'dark-theme' : '' }}">
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay d-lg-none"></div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="content-header mb-4">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            @yield('breadcrumb')
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Main Content Area -->
        @yield('content')
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Progressive enhancement if Vite JS not yet loaded
        (function(){
            function ready(fn){ if(document.readyState!=='loading'){ fn(); } else { document.addEventListener('DOMContentLoaded', fn); } }
            ready(function(){
                var body = document.body;
                var collapseBtn = document.querySelector('.sidebar-toggle-desktop');
                var mobileBtn = document.querySelector('.sidebar-toggle-mobile');
                var overlay = document.querySelector('.sidebar-overlay');
                if(collapseBtn){
                    collapseBtn.addEventListener('click', function(){
                        body.classList.toggle('sidebar-collapsed');
                        localStorage.setItem('sidebarCollapsed', body.classList.contains('sidebar-collapsed'));
                    });
                    if(localStorage.getItem('sidebarCollapsed') === 'true') { body.classList.add('sidebar-collapsed'); }
                }
                if(mobileBtn){
                    mobileBtn.addEventListener('click', function(){ body.classList.toggle('sidebar-mobile-open'); });
                }
                if(overlay){ overlay.addEventListener('click', function(){ body.classList.remove('sidebar-mobile-open'); }); }
            });
        })();
    </script>
    
    @stack('scripts')
</body>
</html>

