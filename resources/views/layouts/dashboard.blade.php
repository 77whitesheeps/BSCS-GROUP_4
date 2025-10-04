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
            --header-height: 60px;
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
            height: var(--header-height);
            background: linear-gradient(135deg, var(--plant-green), var(--plant-green-dark));
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
        }

        .main-header .navbar-brand {
            color: white !important;
            font-weight: bold;
            font-size: 1.5rem;
        }

        .main-header .navbar-nav .nav-link {
            color: white !important;
        }

        .main-header .navbar-nav .dropdown-menu {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background: var(--card-bg);
            color: var(--text-color);
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
        }

        /* Responsive */
        @media (max-width: 768px) {
            .main-sidebar {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            
            .main-content,
            .main-footer {
                margin-left: 0;
            }
            
            .sidebar-mobile-open .main-sidebar {
                margin-left: 0;
            }
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

        .card-dashboard:hover {
            transform: translateY(-2px);
        }

        .btn-plant {
            background-color: var(--plant-green);
            border-color: var(--plant-green);
            color: white;
        }

        .btn-plant:hover {
            background-color: var(--plant-green-dark);
            border-color: var(--plant-green-dark);
            color: white;
        }

        .alert-dismissible .btn-close {
            padding: 0.5rem 0.5rem;
        }

        /* Breadcrumb Styles */
        .breadcrumb {
            background: transparent;
            margin-bottom: 1.5rem;
            padding: 0;
        }

        .breadcrumb-item a {
            color: var(--text-color);
            text-decoration: none;
        }

        .breadcrumb-item.active {
            color: var(--text-color);
        }
    </style>
    
    @stack('styles')
</head>
<body class="{{ auth()->check() && auth()->user()->theme === 'dark' ? 'dark-theme' : '' }}">
    <!-- Header -->
    @include('layouts.partials.header')

    <!-- Sidebar -->
    @include('layouts.partials.sidebar')

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        // Sidebar Toggle Functionality
        $(document).ready(function() {
            $('.sidebar-toggle').on('click', function() {
                $('body').toggleClass('sidebar-collapsed');
                
                // Store sidebar state in localStorage
                if ($('body').hasClass('sidebar-collapsed')) {
                    localStorage.setItem('sidebarCollapsed', 'true');
                } else {
                    localStorage.setItem('sidebarCollapsed', 'false');
                }
            });

            // Restore sidebar state from localStorage
            if (localStorage.getItem('sidebarCollapsed') === 'true') {
                $('body').addClass('sidebar-collapsed');
            }

            // Mobile sidebar toggle
            $('.mobile-sidebar-toggle').on('click', function() {
                $('body').toggleClass('sidebar-mobile-open');
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').alert('close');
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>

