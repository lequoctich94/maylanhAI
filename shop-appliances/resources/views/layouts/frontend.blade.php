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
        /* ===== GLOBAL STYLES TO PREVENT HORIZONTAL SCROLL ===== */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
            box-sizing: border-box;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        .container, .container-fluid, .container-sm, .container-md, .container-lg, .container-xl, .container-xxl {
            max-width: 100%;
            overflow-x: hidden;
        }

        .nav-item.dropdown .dropdown-toggle::after {
            display: none; /* Ẩn mũi tên dropdown mặc định */
        }
        
        .navbar {
            transition: all 0.3s ease;
        }

        .navbar .container {
            padding-right: 2rem;
        }

        /* Responsive navbar padding */
        @media (max-width: 768px) {
            .navbar .container {
                padding-right: 1rem;
            }
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

        /* ===== FOOTER STYLES ===== */
        .footer-main {
            background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
        }

        .footer-main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.02)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .footer-content {
            padding: 4rem 0 2rem;
            position: relative;
            z-index: 1;
        }

        .footer-section {
            height: 100%;
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .footer-logo-img {
            height: 50px;
            width: auto;
        }

        .footer-brand-name {
            color: #ffd700;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .footer-description {
            color: #bdc3c7;
            line-height: 1.6;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .footer-title {
            color: #ffffff;
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
        }

        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #2A83E9, #1565C0);
            border-radius: 2px;
        }

        .footer-social-title {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .social-links {
            display: flex;
            gap: 15px;
        }

        .social-link {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .social-link.facebook {
            background: #3b5998;
        }

        .social-link.youtube {
            background: #ff0000;
        }

        .social-link.zalo {
            background: #0068ff;
        }

        .social-link.instagram {
            background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%);
        }

        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            border-color: rgba(255,255,255,0.3);
        }

        .contact-info {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #2A83E9, #1565C0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(42, 131, 233, 0.3);
        }

        .contact-content h6 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .contact-content p {
            color: #bdc3c7;
            margin: 0;
            line-height: 1.5;
            font-size: 0.9rem;
        }

        .contact-content a {
            color: #bdc3c7;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .contact-content a:hover {
            color: #2A83E9;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: #bdc3c7;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            position: relative;
            padding-left: 15px;
        }

        .footer-links a::before {
            content: '▸';
            position: absolute;
            left: 0;
            color: #2A83E9;
            transition: transform 0.3s ease;
        }

        .footer-links a:hover {
            color: #ffffff;
            transform: translateX(5px);
        }

        .footer-links a:hover::before {
            transform: translateX(3px);
        }

        .footer-certify-title {
            color: #ffffff;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .certify-images {
            display: flex;
            gap: 10px;
        }

        .certify-img {
            height: 40px;
            width: auto;
            background: white;
            padding: 5px;
            border-radius: 8px;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .certify-img:hover {
            opacity: 1;
        }

        .footer-highlight {
            background: rgba(42, 131, 233, 0.1);
            border-top: 1px solid rgba(255,255,255,0.1);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 2rem 0;
            position: relative;
            z-index: 1;
        }

        .highlight-item {
            display: flex;
            align-items: center;
            gap: 15px;
            text-align: left;
        }

        .highlight-icon {
            width: 55px;
            height: 55px;
            background: linear-gradient(135deg, #2A83E9, #1565C0);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.3rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(42, 131, 233, 0.4);
        }

        .highlight-icon.emergency {
            background: linear-gradient(135deg, #ff4757, #ff3742);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4); }
            50% { box-shadow: 0 4px 25px rgba(255, 71, 87, 0.7); }
            100% { box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4); }
        }

        .highlight-content h6 {
            color: #ffffff;
            font-weight: 600;
            margin-bottom: 0.25rem;
            font-size: 1rem;
        }

        .highlight-content p {
            color: #bdc3c7;
            margin: 0;
            font-size: 0.9rem;
        }

        .highlight-content a {
            color: #2A83E9;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .highlight-content a:hover {
            color: #ffffff;
        }

        .footer-bottom {
            background: rgba(0,0,0,0.3);
            padding: 1.5rem 0;
            border-top: 1px solid rgba(255,255,255,0.1);
            position: relative;
            z-index: 1;
        }

        .copyright {
            color: #bdc3c7;
            margin: 0;
            font-size: 0.9rem;
        }

        .copyright strong {
            color: #ffd700;
        }

        .footer-bottom-links {
            display: flex;
            gap: 20px;
            justify-content: flex-end;
        }

        .footer-bottom-links a {
            color: #bdc3c7;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .footer-bottom-links a:hover {
            color: #2A83E9;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .footer-content {
                padding: 3rem 0 1.5rem;
            }
            
            .footer-logo {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .footer-brand-name {
                font-size: 1.3rem;
            }
            
            .social-links {
                justify-content: center;
            }
            
            .highlight-item {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                margin-bottom: 1.5rem;
            }
            
            .footer-bottom-links {
                justify-content: center;
                margin-top: 1rem;
            }
            
            .footer-bottom .row {
                text-align: center;
            }
            
            /* Contact info mobile optimization */
            .contact-item {
                margin-bottom: 1.5rem;
            }
            
            .contact-icon {
                width: 35px;
                height: 35px;
                font-size: 0.9rem;
            }
            
            .contact-content h6 {
                font-size: 0.85rem;
                margin-bottom: 0.3rem;
            }
            
            .contact-content p {
                font-size: 0.8rem;
                line-height: 1.4;
            }
            
            /* Footer highlight mobile - 3 items responsive */
            .footer-highlight {
                padding: 1.5rem 0;
            }
            
            .footer-highlight .row {
                justify-content: center;
            }
            
            .footer-highlight .col-md-4 {
                flex: 0 0 auto;
                width: 33.33333%;
                margin-bottom: 0;
            }
            
            .highlight-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
                margin: 0 auto;
            }
            
            .highlight-content h6 {
                font-size: 0.85rem;
                margin-bottom: 0.2rem;
            }
            
            .highlight-content p {
                font-size: 0.75rem;
                line-height: 1.3;
            }
        }

        @media (max-width: 576px) {
            .footer-content {
                padding: 2rem 0 1rem;
            }
            
            .footer-description {
                font-size: 0.9rem;
                margin-bottom: 1.5rem;
            }
            
            .footer-title {
                font-size: 1.1rem;
                margin-bottom: 1rem;
            }
            
            .footer-links a {
                font-size: 0.85rem;
            }
            
            .footer-bottom-links {
                flex-direction: column;
                gap: 10px;
            }
            
            /* Contact items mobile optimization - keep horizontal layout */
            .contact-item {
                display: flex;
                align-items: flex-start;
                gap: 12px;
                margin-bottom: 1.2rem;
                text-align: left;
            }
            
            .contact-icon {
                width: 30px;
                height: 30px;
                font-size: 0.8rem;
                flex-shrink: 0;
            }
            
            .contact-content h6 {
                font-size: 0.8rem;
                margin-bottom: 0.2rem;
            }
            
            .contact-content p {
                font-size: 0.75rem;
                line-height: 1.3;
                margin: 0;
            }
            
            /* Footer highlight extra small mobile - stack vertically */
            .footer-highlight .col-md-4 {
                width: 100%;
                margin-bottom: 1rem;
            }
            
            .highlight-item {
                flex-direction: row;
                text-align: left;
                gap: 15px;
                justify-content: center;
                align-items: center;
                max-width: 280px;
                margin: 0 auto 1rem;
            }
            
            .highlight-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
                margin: 0;
                flex-shrink: 0;
            }
            
            .highlight-content {
                flex: 1;
            }
            
            .highlight-content h6 {
                font-size: 0.9rem;
                margin-bottom: 0.1rem;
            }
            
            .highlight-content p {
                font-size: 0.8rem;
                margin: 0;
            }
            
            /* Compact social links */
            .social-link {
                width: 40px;
                height: 40px;
                font-size: 0.9rem;
            }
            
            .footer-brand-name {
                font-size: 1.2rem;
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
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('blog.index') }}">Blog</a>
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
    <footer class="footer-main">
        <!-- Main Footer Content -->
        <div class="footer-content">
        <div class="container">
            <div class="row">
                    <!-- Thông tin công ty -->
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="footer-section">
                            <div class="footer-logo mb-3">
                                <img src="{{ asset('img/logo.png') }}" alt="{{ config('app.name') }} Logo" class="footer-logo-img">
                                <h4 class="footer-brand-name">ĐIỆN LẠNH 100V</h4>
                            </div>
                            <p class="footer-description">
                                Chuyên cung cấp các thiết bị điện lạnh chất lượng cao với dịch vụ lắp đặt, bảo hành uy tín. 
                                Cam kết mang đến sự hài lòng tuyệt đối cho khách hàng.
                            </p>
                            <div class="footer-social">
                                <h6 class="footer-social-title">Kết nối với chúng tôi</h6>
                                <div class="social-links">
                                    <a href="#" class="social-link facebook" title="Facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" class="social-link youtube" title="YouTube">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                    <a href="#" class="social-link zalo" title="Zalo">
                                        <i class="fas fa-comments"></i>
                                    </a>
                                    <a href="#" class="social-link instagram" title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Thông tin liên hệ -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-title">Thông Tin Liên Hệ</h5>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h6>Địa chỉ</h6>
                                        <p>123 Đường ABC, Phường XYZ<br>Quận 1, TP. Hồ Chí Minh</p>
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h6>Hotline</h6>
                                        <p>
                                            <a href="tel:0123456789">0123 456 789</a><br>
                                            <a href="tel:0987654321">0987 654 321</a>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="contact-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="contact-content">
                                        <h6>Email</h6>
                                        <p>
                                            <a href="mailto:info@dienlanh100v.com">info@dienlanh100v.com</a><br>
                                            <a href="mailto:support@dienlanh100v.com">support@dienlanh100v.com</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Dịch vụ & Sản phẩm -->
                    <div class="col-lg-2 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-title">Dịch Vụ</h5>
                            <ul class="footer-links">
                                <li><a href="{{ route('products.index') }}">Tất cả sản phẩm</a></li>
                                <li><a href="#">Máy lạnh</a></li>
                                <li><a href="#">Tủ lạnh</a></li>
                                <li><a href="#">Máy giặt</a></li>
                                <li><a href="#">Lắp đặt</a></li>
                                <li><a href="#">Bảo hành</a></li>
                                <li><a href="#">Sửa chữa</a></li>
                                <li><a href="#">Vệ sinh máy lạnh</a></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Hỗ trợ khách hàng -->
                    <div class="col-lg-3 col-md-6 mb-4">
                        <div class="footer-section">
                            <h5 class="footer-title">Hỗ Trợ Khách Hàng</h5>
                            <ul class="footer-links">
                                <li><a href="#">Chính sách bảo hành</a></li>
                                <li><a href="#">Chính sách đổi trả</a></li>
                                <li><a href="#">Hướng dẫn mua hàng</a></li>
                                <li><a href="#">Phương thức thanh toán</a></li>
                                <li><a href="#">Chính sách vận chuyển</a></li>
                                <li><a href="{{ route('blog.index') }}">Tin tức & Blog</a></li>
                                <li><a href="#">FAQ</a></li>
                            </ul>
                            
                            <div class="footer-certify mt-4">
                                <h6 class="footer-certify-title">Chứng nhận</h6>
                                <div class="certify-images">
                                    <img src="{{ asset('img/certify-1.png') }}" alt="Chứng nhận" class="certify-img">
                                    <img src="{{ asset('img/certify-2.png') }}" alt="Chứng nhận" class="certify-img">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Working Hours & Emergency -->
        <div class="footer-highlight">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="highlight-content">
                                <h6>Giờ làm việc</h6>
                                <p>T2-CN: 8:00 - 21:00</p>
                            </div>
                        </div>
                    </div>
                <div class="col-md-4">
                        <div class="highlight-item">
                            <div class="highlight-icon emergency">
                                <i class="fas fa-tools"></i>
                            </div>
                            <div class="highlight-content">
                                <h6>Sửa chữa khẩn cấp</h6>
                                <p><a href="tel:0909123456">0909 123 456</a></p>
                            </div>
                        </div>
                </div>
                <div class="col-md-4">
                        <div class="highlight-item">
                            <div class="highlight-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <div class="highlight-content">
                                <h6>Giao hàng</h6>
                                <p>Miễn phí nội thành</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="copyright">
                            © {{ date('Y') }} <strong>ĐIỆN LẠNH 100V</strong>. Tất cả quyền được bảo lưu.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-bottom-links">
                            <a href="#">Điều khoản sử dụng</a>
                            <a href="#">Chính sách bảo mật</a>
                            <a href="#">Sitemap</a>
                        </div>
                    </div>
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