<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
            padding-top: 1rem;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,.8);
            padding: 0.8rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #0d6efd;
        }
        .sidebar .nav-link i {
            width: 1.5rem;
        }
        .main-content {
            min-height: 100vh;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        }
        
        /* Submenu styles */
        .sidebar .nav-link.dropdown-toggle::after {
            margin-left: auto;
        }
        
        .sidebar .collapse .nav-link {
            padding-left: 2.5rem;
            font-size: 0.9rem;
        }
        
        .sidebar .collapse .nav-link.active {
            background-color: rgba(13, 110, 253, 0.8);
        }
        
        .sidebar .collapse .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container-fluid">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="px-3 mb-4">
                    <h5 class="text-light">Admin Panel</h5>
                </div>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" 
                           href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-list"></i>
                            <span>Categories</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" 
                           href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Products</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" 
                           href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}" 
                           href="#settingsSubmenu" 
                           data-bs-toggle="collapse" 
                           role="button" 
                           aria-expanded="{{ request()->routeIs('admin.slides.*') ? 'true' : 'false' }}">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.slides.*') ? 'show' : '' }}" id="settingsSubmenu">
                            <ul class="nav flex-column ms-3">
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.slides.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.slides.index') }}">
                                        <i class="fas fa-images"></i>
                                        <span>Sliders</span>
                                    </a>
                                </li>
                                <!-- Add more settings items here -->
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.attributes.*') ? 'active' : '' }}" 
                           href="{{ route('admin.attributes.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Attributes</span>
                        </a>
                    </li>
                    <li class="nav-item mt-4">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View Site</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Main content -->
            <div class="col-md-9 col-lg-10 main-content">
                <!-- Top navbar -->
                <nav class="navbar navbar-expand-lg mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" 
                                       data-bs-toggle="dropdown">
                                        <i class="fas fa-user"></i>
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                                <i class="fas fa-user-cog"></i> Profile
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-sign-out-alt"></i> Logout
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                <div class="px-4">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 