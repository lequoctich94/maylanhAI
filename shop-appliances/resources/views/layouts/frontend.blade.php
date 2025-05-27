<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ config('app.name') }}</title>
    
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
    <style>
        .nav-item.dropdown .dropdown-toggle::after {
            display: none; /* Ẩn mũi tên dropdown mặc định */
        }
        
        .navbar {
            transition: all 0.3s ease;
        }

        .navbar-fixed {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            animation: slideDown 0.35s ease-out;
        }

        .navbar-hidden {
            transform: translateY(-100%);
        }

        @keyframes slideDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }

        /* Thêm padding-top cho body khi navbar fixed */
        body.has-fixed-nav {
            padding-top: 56px; /* Điều chỉnh theo chiều cao của navbar */
        }

        /* Styles cho thanh tìm kiếm */
        .navbar .search-form {
            min-width: 400px; /* Tăng độ rộng tối thiểu */
        }

        .navbar .search-form .form-control {
            border-radius: 20px 0 0 20px; /* Bo tròn góc trái */
            border: none;
            padding-left: 20px; /* Thêm padding bên trái */
        }

        .navbar .search-form .btn {
            border-radius: 0 20px 20px 0; /* Bo tròn góc phải */
            border: none;
            padding: 0 20px; /* Thêm padding 2 bên */
        }

        /* Style cho logo */
        .navbar-brand img {
            height: 40px; /* Điều chỉnh chiều cao của logo */
            width: auto;
            margin-right: 10px;
        }

        .category-dropdown {
            position: static;
        }

        .category-menu {
            width: 100%;
            padding: 20px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 0 0 10px 10px;
            margin-top: 0;
        }

        .category-item {
            margin-bottom: 15px;
        }

        .category-item .dropdown-item {
            display: flex;
            align-items: center;
            padding: 10px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .category-item .dropdown-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }

        .category-icon {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 12px;
        }

        .category-icon-fallback {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #e9ecef;
            border-radius: 8px;
            margin-right: 12px;
            color: #2A83E9;
            font-size: 1.2rem;
        }

        .category-info {
            display: flex;
            flex-direction: column;
        }

        .category-name {
            font-weight: 500;
            color: #2A83E9;
            margin-bottom: 2px;
        }

        .category-count {
            font-size: 0.8rem;
        }

        /* Animation cho dropdown */
        .dropdown-menu.show {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hover effect cho nút danh mục */
        .nav-link.dropdown-toggle {
            position: relative;
            padding-right: 20px !important;
        }

        .nav-link.dropdown-toggle:after {
            content: '\f107';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            transition: transform 0.3s ease;
        }

        .nav-link.dropdown-toggle[aria-expanded="true"]:after {
            transform: translateY(-50%) rotate(180deg);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ff4444;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            animation: bounce 0.5s ease;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2A83E9;">
            <div class="container">
                <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('home') }}">
                    <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }} Logo">
                    <span style="font-size: 20px; font-weight: bold; color: yellow;">ĐIỆN LẠNH 100V</span>
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item dropdown category-dropdown">
                            <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bars me-2"></i> Danh mục sản phẩm
                            </a>
                            <div class="dropdown-menu category-menu">
                                <div class="container">
                                    <div class="row">
                                        @foreach($categories->chunk(4) as $categoryGroup)
                                            <div class="col-md-3">
                                                @foreach($categoryGroup as $category)
                                                    <div class="category-item">
                                                        <a class="dropdown-item" href="{{ route('products.category', $category->slug) }}">
                                                            @if($category->image)
                                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="category-icon">
                                                            @else
                                                                <i class="fas fa-box category-icon-fallback"></i>
                                                            @endif
                                                            <div class="category-info">
                                                                <span class="category-name">{{ $category->name }}</span>
                                                                <small class="category-count text-muted">
                                                                    {{ $category->products_count ?? 0 }} sản phẩm
                                                                </small>
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('products.index') }}">Sản Phẩm</a>
                        </li>
                        
                        <!-- Thêm form tìm kiếm -->
                        <li class="nav-item">
                            <form class="d-flex ms-3 search-form" action="{{ route('products.search') }}" method="GET">
                                <div class="input-group">
                                    <input class="form-control" 
                                           type="search" 
                                           name="q"
                                           value="{{ request('q') }}"
                                           placeholder="Tìm kiếm sản phẩm..." 
                                           aria-label="Search">
                                    <button class="btn btn-light" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                    
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white position-relative" href="{{ route('cart.index') }}">
                                <i class="fas fa-shopping-cart"></i> Giỏ hàng
                                @if($cartCount > 0)
                                    <span class="cart-badge">{{ $cartCount }}</span>
                                @endif
                            </a>
                        </li>
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i> {{ auth()->user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    @if(auth()->user()->is_admin)
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                                <i class="fas fa-tachometer-alt"></i> Quản trị
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                    @endif
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user-edit"></i> Thông tin cá nhân
                                        </a>
                                    </li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('login') }}">Đăng Nhập</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" href="{{ route('register') }}">Đăng Ký</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
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
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Us</h5>
                    <p>Your trusted source for home appliances.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white">Home</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-white">Products</a></li>
                        <li><a href="#" class="text-white">About Us</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Info</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-phone"></i> +1234567890</li>
                        <li><i class="fas fa-envelope"></i> info@example.com</li>
                        <li><i class="fas fa-map-marker-alt"></i> 123 Street, City, Country</li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Hiển thị navbar khi scroll xuống
        document.addEventListener('DOMContentLoaded', function() {
            let navbar = document.querySelector('.navbar');
            let lastScroll = 0;
            let scrollThreshold = 100; // Ngưỡng scroll để bắt đầu fixed
            let scrollTimeout;

            window.addEventListener('scroll', function() {
                clearTimeout(scrollTimeout);
                
                let currentScroll = window.pageYOffset;
                
                // Khi scroll xuống và vượt qua ngưỡng
                if (currentScroll > scrollThreshold) {
                    document.body.classList.add('has-fixed-nav');
                    navbar.classList.add('navbar-fixed');
                    
                    // Nếu scroll xuống
                    if (currentScroll > lastScroll) {
                        scrollTimeout = setTimeout(() => {
                            navbar.classList.add('navbar-hidden');
                        }, 500); // Đợi 500ms trước khi ẩn navbar
                    } 
                    // Nếu scroll lên
                    else {
                        navbar.classList.remove('navbar-hidden');
                    }
                } 
                // Khi scroll về đầu trang
                else {
                    document.body.classList.remove('has-fixed-nav');
                    navbar.classList.remove('navbar-fixed', 'navbar-hidden');
                }
                
                lastScroll = currentScroll;
            });
        });
        // KẾT THÚC HIỂN THỊ NAVBAR KHI SCROLL XUỐNG
    </script>
    
    @stack('scripts')
</body>
</html> 