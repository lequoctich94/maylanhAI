@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
<!-- Hero Slider Wrapper to prevent horizontal scroll -->
<div class="hero-slider-wrapper">
    <!-- Full-Screen Modern Hero Slider -->
    <div id="heroCarousel" class="carousel slide hero-slider" data-bs-ride="carousel" data-bs-interval="5000">
        <!-- Custom Indicators -->
        <div class="hero-indicators">
                @foreach($slides as $key => $slide)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $key }}" 
                class="hero-indicator {{ $key == 0 ? 'active' : '' }}" 
                aria-current="true" aria-label="Slide {{ $key + 1 }}">
                <span class="indicator-line"></span>
                <span class="indicator-text">0{{ $key + 1 }}</span>
                </button>
                @endforeach
            </div>
            
        <!-- Slides Container -->
        <div class="carousel-inner hero-inner">
                @foreach($slides as $key => $slide)
            <div class="carousel-item hero-slide {{ $key == 0 ? 'active' : '' }}">
                <!-- Background with Parallax Effect -->
                <div class="hero-background" data-bg="{{ asset('storage/' . $slide->image) }}">
                    <div class="hero-image-container">
                        <img src="{{ asset('storage/' . $slide->image) }}" 
                             class="hero-image" 
                             alt="{{ $slide->title }}">
                    </div>
                    <!-- Animated Overlay -->
                    <div class="hero-overlay-animated"></div>
                    <!-- Gradient Overlay -->
                    <div class="hero-gradient-overlay">
                        <div class="hero-particles">
                            <div class="particle"></div>
                            <div class="particle"></div>
                            <div class="particle"></div>
                            <div class="particle"></div>
                            <div class="particle"></div>
                        </div>
                    </div>
                </div>

                <!-- Content Container -->
                <div class="hero-content-wrapper">
                    <div class="container">
                        <div class="row align-items-center min-vh-100">
                            <div class="col-lg-8 col-xl-7">
                                <div class="hero-content-inner">
                                    <!-- Badge -->
                                    <div class="hero-badge">
                                        <span class="badge-icon">✨</span>
                                        <span class="badge-text">Chào mừng đến với MayLanhAI</span>
                                    </div>
                                    
                                    <!-- Main Title -->
                                    <h1 class="hero-main-title">
                                        <span class="title-line title-line-1">{{ explode(' ', $slide->title)[0] ?? '' }}</span>
                                        <span class="title-line title-line-2">{{ implode(' ', array_slice(explode(' ', $slide->title), 1)) }}</span>
                                    </h1>
                                    
                                    <!-- Subtitle -->
                                    <p class="hero-description">{{ $slide->subtitle }}</p>
                                    
                                    <!-- CTA Buttons -->
                        @if($slide->link)
                                    <div class="hero-cta-group">
                                        <a href="{{ $slide->link }}" class="btn btn-hero-primary">
                                            <span class="btn-text">Khám Phá Ngay</span>
                                            <span class="btn-icon">
                                                <i class="fas fa-arrow-right"></i>
                                            </span>
                                            <div class="btn-ripple"></div>
                                        </a>
                                        <a href="#featured-products" class="btn btn-hero-secondary">
                                            <span class="btn-text">Xem Sản Phẩm</span>
                                            <span class="btn-icon">
                                                <i class="fas fa-play"></i>
                                            </span>
                                        </a>
                                    </div>
                        @endif
                                    
                                    <!-- Stats/Features Quick Info -->
                                    <div class="hero-stats">
                                        <div class="stat-item">
                                            <div class="stat-number">1000+</div>
                                            <div class="stat-label">Khách hàng</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-number">50+</div>
                                            <div class="stat-label">Sản phẩm</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-number">24/7</div>
                                            <div class="stat-label">Hỗ trợ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>

        <!-- Custom Navigation Controls -->
        <div class="hero-navigation">
            <button class="hero-nav-btn hero-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="nav-icon">
                    <i class="fas fa-chevron-left"></i>
                </span>
                <span class="nav-text">Prev</span>
            </button>
            <button class="hero-nav-btn hero-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="nav-text">Next</span>
                <span class="nav-icon">
                    <i class="fas fa-chevron-right"></i>
                </span>
            </button>
        </div>

        <!-- Scroll Down Indicator -->
        <div class="scroll-indicator">
            <div class="scroll-text">Scroll Down</div>
            <div class="scroll-arrow">
                <i class="fas fa-chevron-down"></i>
            </div>
        </div>
    </div>
</div>

<!-- Resume main structure for other sections -->
<main class="main-content">
    <div class="container">
        <!-- Features Section -->
        <section class="features-section py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                            <h5 class="feature-title">Giao Hàng Nhanh</h5>
                            <p class="feature-text">Miễn phí giao hàng<br>trong nội thành</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-tools"></i>
                            </div>
                            <h5 class="feature-title">Lắp Đặt Miễn Phí</h5>
                            <p class="feature-text">Đội ngũ kỹ thuật<br>chuyên nghiệp</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-shield-alt"></i>
                            </div>
                            <h5 class="feature-title">Bảo Hành Chính Hãng</h5>
                            <p class="feature-text">Cam kết bảo hành<br>từ nhà sản xuất</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card text-center">
                            <div class="feature-icon">
                                <i class="fas fa-headset"></i>
                            </div>
                            <h5 class="feature-title">Hỗ Trợ 24/7</h5>
                            <p class="feature-text">Tư vấn miễn phí<br>mọi lúc mọi nơi</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    <!-- Categories Section -->
        <section class="categories-section py-5">
        <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">
                        <span class="title-highlight">Danh Mục</span> Sản Phẩm
                    </h2>
                    <p class="section-subtitle">Khám phá các dòng sản phẩm chất lượng cao</p>
                    <div class="title-decoration">
                        <div class="title-line"></div>
                        <div class="title-dot"></div>
                <div class="title-line"></div>
            </div>
                </div>
                <div class="row g-3">
                @foreach($categories as $category)
                        <div class="col-lg-2 col-md-4 col-sm-6">
                            <a href="{{ route('products.category', $category->slug) }}" class="category-card-link">
                                <div class="category-card-compact">
                                    <div class="category-content-left">
                                        <h6 class="category-name">{{ $category->name }}</h6>
                                        <p class="category-description">{{ $category->products_count ?? 0 }} sản phẩm</p>
                                    </div>
                                    <div class="category-image-right">
                                    @if($category->image)
                                        <img src="{{ asset('storage/' . $category->image) }}" 
                                                 class="category-image-compact" 
                                             alt="{{ $category->name }}">
                                    @else
                                            <div class="category-placeholder-compact">
                                                <i class="fas fa-box"></i>
                                            </div>
                                    @endif
                                        <div class="category-badge">{{ $category->products_count ?? 0 }}</div>
                                    </div>
                                </div>
                            </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
        <section id="featured-products" class="featured-section py-5">
        <div class="container">
                <div class="section-header text-center mb-5">
                    <h2 class="section-title">
                        <span class="title-highlight">Sản Phẩm</span> Mới Nhất
                    </h2>
                    <p class="section-subtitle">Những sản phẩm chất lượng cao được khách hàng tin tưởng</p>
                    <div class="title-decoration">
                        <div class="title-line"></div>
                        <div class="title-dot"></div>
                <div class="title-line"></div>
            </div>
                </div>
                <div class="row g-4">
                @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="product-card modern-card">
                                <div class="product-image-wrapper">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                         class="product-image" 
                                     alt="{{ $product->name }}">
                                    
                                @if($product->discount_price)
                                    <div class="discount-badge">
                                            <span class="discount-percent">
                                        -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                            </span>
                                    </div>
                                @endif
                                    
                                <div class="product-overlay">
                                        <div class="product-actions">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                               class="action-btn" title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($product->is_active)
                                                <button type="button" class="action-btn quick-add-cart" 
                                                        data-product-id="{{ $product->id }}" title="Thêm vào giỏ">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </button>
                                            @endif
                                </div>
                            </div>
                                </div>
                                
                                <div class="product-content">
                                    <h6 class="product-name">
                                        <a href="{{ route('products.show', $product->slug) }}">
                                        {{ $product->name }}
                                    </a>
                                </h6>
                                    
                                    <!-- Highlight Attributes -->
                                    @if($product->attributes->where('attribute.is_highlight', true)->count() > 0)
                                        <div class="product-features mb-2">
                                            @foreach($product->attributes->where('attribute.is_highlight', true) as $productAttribute)
                                                @if($productAttribute->value && !($productAttribute->attribute->type === 'checkbox' && $productAttribute->value !== '1'))
                                                    <span class="feature-badge" 
                                                          style="background-color: {{ $productAttribute->attribute->highlight_color ?? '#007bff' }};">
                                                        @if($productAttribute->attribute->type === 'checkbox')
                                                            <i class="fas fa-check"></i> {{ $productAttribute->attribute->name }}
                                                        @else
                                                            {{ $productAttribute->attribute->name }}: {{ $productAttribute->value }}
                                                        @endif
                                            </span>
                                                @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    
                                    <div class="product-rating mb-2">
                                        <div class="stars">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-text">(5.0)</span>
                                    </div>
                                    
                                    <div class="product-price">
                                        @if($product->discount_price)
                                            <div class="price-group">
                                                <span class="current-price">{{ number_format($product->discount_price) }}đ</span>
                                                <span class="original-price">{{ number_format($product->price) }}đ</span>
                                            </div>
                                        @else
                                            <span class="current-price">{{ number_format($product->price) }}đ</span>
                                    @endif
                                </div>
                                    
                                    <div class="product-actions-bottom mt-3">
                                @if($product->is_active)
                                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-add-cart">
                                                    <i class="fas fa-shopping-cart me-2"></i>Đặt Hàng
                                        </button>
                                    </form>
                                @else
                                            <div class="out-of-stock">
                                                <i class="fas fa-times-circle me-2"></i>Hết Hàng
                                    </div>
                                @endif
                                    </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
                
                <div class="text-center mt-5">
                    <a href="{{ route('products.index') }}" class="btn btn-view-all">
                        <span>Xem Tất Cả Sản Phẩm</span>
                        <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
        </div>
    </section>

    <!-- Blog Section -->
    @if($posts->count() > 0)
    <section class="blog-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h2 class="section-title">
                    <span class="title-highlight">Tin Tức</span> & Blog
                </h2>
                <p class="section-subtitle">Cập nhật thông tin mới nhất về sản phẩm và công nghệ</p>
                <div class="title-decoration">
                    <div class="title-line"></div>
                    <div class="title-dot"></div>
                    <div class="title-line"></div>
                </div>
            </div>
            <div class="row g-4">
                @foreach($posts as $post)
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card modern-card">
                        <div class="blog-image-wrapper">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     class="blog-image" 
                                     alt="{{ $post->title }}">
                            @else
                                <div class="blog-placeholder">
                                    <i class="fas fa-newspaper"></i>
                                </div>
                            @endif
                            <div class="blog-overlay">
                                <div class="blog-overlay-content">
                                    <i class="fas fa-eye"></i>
                                    <span>Đọc Bài Viết</span>
                                </div>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span class="blog-category">{{ $post->category->name }}</span>
                                <span class="blog-date">{{ $post->published_at->format('d/m/Y') }}</span>
                            </div>
                            <h5 class="blog-title">
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    {{ $post->title }}
                                </a>
                            </h5>
                            @if($post->excerpt)
                                <p class="blog-excerpt">{{ Str::limit($post->excerpt, 120) }}</p>
                            @endif
                            <div class="blog-footer">
                                <div class="blog-author">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $post->author->name }}</span>
                                </div>
                                <a href="{{ route('blog.show', $post->slug) }}" class="blog-read-more">
                                    Đọc thêm <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-5">
                <a href="{{ route('blog.index') }}" class="btn btn-view-all">
                    <span>Xem Tất Cả Bài Viết</span>
                    <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </section>
    @endif

        <!-- Newsletter Section -->
        <section class="newsletter-section py-5">
            <div class="container">
                <div class="newsletter-wrapper">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <div class="newsletter-content">
                                <h3 class="newsletter-title">Đăng Ký Nhận Thông Tin</h3>
                                <p class="newsletter-text">Nhận thông báo về sản phẩm mới và ưu đãi đặc biệt</p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="newsletter-form">
                                <form class="d-flex">
                                    <input type="email" class="form-control newsletter-input" 
                                           placeholder="Nhập email của bạn...">
                                    <button type="submit" class="btn btn-newsletter">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection

@push('styles')
<style>
/* ===== FIX HORIZONTAL SCROLL ===== */
html, body {
    overflow-x: hidden;
    max-width: 100%;
    box-sizing: border-box;
}

*, *::before, *::after {
    box-sizing: border-box;
}

/* ===== FULL SCREEN HERO SLIDER ===== */
.hero-slider {
    position: relative;
    width: 100vw;
    height: 100vh;
    z-index: 100;
    margin: 0;
    margin-left: calc(-50vw + 50%);
    overflow: hidden;
    background: #000;
}

/* Container wrapper to prevent overflow */
.hero-slider-wrapper {
    position: relative;
    width: 100%;
    overflow: hidden;
}

.container, .container-fluid {
    max-width: 100%;
    overflow-x: hidden;
}

/* Ensure no elements exceed viewport width */
.row {
    margin-left: 0;
    margin-right: 0;
    max-width: 100%;
}

.hero-inner {
    height: 100vh;
}

.hero-slide {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

/* Background with Ken Burns Effect */
.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    overflow: hidden;
}

.hero-image-container {
    position: absolute;
    top: -10%;
    left: -10%;
    width: 120%;
    height: 120%;
    transition: transform 15s ease-in-out;
}

.hero-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    opacity: 0;
    transition: opacity 0.5s ease;
    /* Image optimization for different sizes */
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
}

/* Responsive image sizing */
@media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
    .hero-image {
        image-rendering: auto;
    }
}

/* Aspect ratio enforcement */
.hero-image-container::before {
    content: '';
    display: block;
    aspect-ratio: 16/9;
    width: 100%;
}

/* Optimized for different image dimensions */
.hero-image.portrait {
    object-fit: cover;
    object-position: center top;
}

.hero-image.landscape {
    object-fit: cover;
    object-position: center center;
}

.hero-image.square {
    object-fit: cover;
    object-position: center center;
    transform: scale(1.2);
}

/* Loading state */
.hero-image.loading {
    opacity: 0;
    filter: blur(5px);
}

.hero-slide.loaded .hero-image {
    opacity: 1;
    filter: none;
}

/* Ken Burns Animation */
.carousel-item.active .hero-image-container {
    transform: scale(1.1) translate(2%, -2%);
}

.carousel-item:nth-child(even).active .hero-image-container {
    transform: scale(1.1) translate(-2%, 2%);
}

/* Overlays */
.hero-overlay-animated {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, 
        rgba(42, 131, 233, 0.3) 0%,
        transparent 30%,
        transparent 70%,
        rgba(21, 101, 192, 0.3) 100%);
    opacity: 0;
    animation: overlayPulse 8s ease-in-out infinite;
}

@keyframes overlayPulse {
    0%, 100% { opacity: 0.3; transform: scale(1); }
    50% { opacity: 0.6; transform: scale(1.02); }
}

.hero-gradient-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, 
        rgba(0, 0, 0, 0.1) 0%,
        rgba(0, 0, 0, 0.05) 30%,
        rgba(0, 0, 0, 0) 50%,
        rgba(0, 0, 0, 0.05) 70%,
        rgba(0, 0, 0, 0.1) 100%);
    z-index: 1;
}

/* Particles */
.hero-particles {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
    z-index: 2;
}

.particle {
    position: absolute;
    width: 4px;
    height: 4px;
    background: rgba(255, 255, 255, 0.6);
    border-radius: 50%;
    animation: float 6s ease-in-out infinite;
}

.particle:nth-child(1) { top: 20%; left: 20%; animation-delay: 0s; animation-duration: 6s; }
.particle:nth-child(2) { top: 60%; left: 80%; animation-delay: 2s; animation-duration: 8s; }
.particle:nth-child(3) { top: 80%; left: 40%; animation-delay: 4s; animation-duration: 7s; }
.particle:nth-child(4) { top: 40%; left: 70%; animation-delay: 1s; animation-duration: 9s; }
.particle:nth-child(5) { top: 10%; left: 60%; animation-delay: 3s; animation-duration: 5s; }

@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.6; }
    50% { transform: translateY(-20px) rotate(180deg); opacity: 1; }
}

/* Content */
.hero-content-wrapper {
    position: relative;
    z-index: 5;
    height: 100%;
    display: flex;
    align-items: center;
}

.hero-content-inner {
    animation: heroContentSlideIn 1.2s ease-out;
}

@keyframes heroContentSlideIn {
    from { opacity: 0; transform: translateY(50px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Badge */
.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    padding: 8px 20px;
    margin-bottom: 2rem;
    animation: badgeGlow 2s ease-in-out infinite alternate;
}

@keyframes badgeGlow {
    from { box-shadow: 0 0 20px rgba(42, 131, 233, 0.3); }
    to { box-shadow: 0 0 30px rgba(42, 131, 233, 0.6); }
}

.badge-icon {
    font-size: 1.2rem;
    animation: badgeIconSpin 3s linear infinite;
}

@keyframes badgeIconSpin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.badge-text {
    color: white;
    font-size: 0.9rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Title */
.hero-main-title {
    font-size: 4.5rem;
    font-weight: 800;
    line-height: 1.1;
    margin-bottom: 1.5rem;
    letter-spacing: -2px;
    color: white;
}

.title-line {
    display: block;
    overflow: hidden;
}

.title-line-1 {
    color: white;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    animation: titleSlideUp 1s ease-out 0.3s both;
}

.title-line-2 {
    color: white;
    text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
    animation: titleSlideUp 1s ease-out 0.6s both;
    background: none;
    -webkit-background-clip: unset;
    -webkit-text-fill-color: unset;
}

@keyframes titleSlideUp {
    from { transform: translateY(100%); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

/* Description */
.hero-description {
    font-size: 1.3rem;
    color: rgba(255, 255, 255, 1);
    line-height: 1.6;
    margin-bottom: 3rem;
    max-width: 500px;
    font-weight: 300;
    animation: fadeInUp 1s ease-out 0.9s both;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Layout adjustments for full screen */
.main-content {
    position: relative;
    z-index: 1;
    background: #fff;
}

/* Performance */
.hero-slider * {
    will-change: transform;
}

/* Hide navbar when hero is active */
body.hero-active .navbar {
    opacity: 0;
    transform: translateY(-100%);
    transition: all 0.3s ease;
    width: 100vw;
    left: 0;
    right: 0;
    position: fixed;
    margin: 0;
    padding: 0;
    top: 0;
    z-index: 9999;
}

body:not(.hero-active) .navbar {
    opacity: 1 !important;
    transform: translateY(0) !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    width: 100vw !important;
    z-index: 9999 !important;
    transition: all 0.3s ease;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 0;
    padding: 0;
}

body.hero-active .navbar-fixed {
    opacity: 1;
    transform: translateY(0);
    width: 100vw;
    left: 0;
    right: 0;
    margin: 0;
    padding: 0;
}

.navbar {
    width: 100vw;
    left: 0;
    right: 0;
    position: fixed;
    top: 0;
    z-index: 9999;
    background: white;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin: 0;
    padding: 0;
}

.navbar-container {
    width: 100%;
    max-width: 1320px;
    margin: 0 auto;
    padding: 0.5rem 1rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

/* Hero exit trigger */
.hero-exit-trigger {
    position: absolute;
    top: 90vh;
    left: 0;
    width: 100%;
    height: 10vh;
    z-index: 5;
    pointer-events: none;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .hero-main-title {
        font-size: 2.8rem;
        letter-spacing: -1px;
    }
    
    .hero-description {
        font-size: 1.1rem;
        margin-bottom: 2rem;
    }
    
    .hero-particles {
        display: none;
    }
}

@media (max-width: 576px) {
    .hero-main-title {
        font-size: 2.2rem;
    }
    
    .hero-description {
        font-size: 1rem;
    }
}

/* ===== HERO BUTTONS & CONTROLS ===== */
.hero-cta-group {
    display: flex;
    gap: 20px;
    margin-bottom: 4rem;
    flex-wrap: wrap;
    animation: fadeInUp 1s ease-out 1.2s both;
}

.btn-hero-primary,
.btn-hero-secondary {
    position: relative;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 16px 32px;
    border-radius: 50px;
    font-size: 1.1rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.4s ease;
    overflow: hidden;
    border: 2px solid transparent;
}

.btn-hero-primary {
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    color: white;
    box-shadow: 0 8px 25px rgba(42, 131, 233, 0.4);
}

.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(42, 131, 233, 0.6);
    color: white;
}

.btn-hero-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 2px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(10px);
}

.btn-hero-secondary:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-3px);
    color: white;
}

.btn-ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-hero-primary:active .btn-ripple {
    width: 300px;
    height: 300px;
}

.btn-icon {
    transition: transform 0.3s ease;
}

.btn-hero-primary:hover .btn-icon {
    transform: translateX(5px);
}

.btn-hero-secondary:hover .btn-icon {
    transform: scale(1.2);
}

/* Stats */
.hero-stats {
    display: flex;
    gap: 3rem;
    animation: fadeInUp 1s ease-out 1.5s both;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: white;
    margin-bottom: 0.5rem;
    background: none;
    -webkit-background-clip: unset;
    -webkit-text-fill-color: unset;
}

.stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 1);
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 500;
}

/* Indicators */
.hero-indicators {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 15px;
    z-index: 15;
    animation: fadeInUp 1s ease-out 2s both;
}

.hero-indicator {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 25px;
    padding: 8px 16px;
    cursor: pointer;
    transition: all 0.4s ease;
}

.hero-indicator:hover,
.hero-indicator.active {
    background: rgba(42, 131, 233, 0.8);
    border-color: rgba(42, 131, 233, 0.9);
    transform: translateY(-2px);
}

.indicator-line {
    width: 30px;
    height: 2px;
    background: rgba(255, 255, 255, 0.5);
    border-radius: 1px;
    transition: all 0.4s ease;
}

.hero-indicator.active .indicator-line {
    background: white;
    width: 40px;
}

.indicator-text {
    color: white;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 1px;
}

/* Navigation */
.hero-navigation {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
    padding: 0 50px;
    z-index: 15;
    pointer-events: none;
}

.hero-nav-btn {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50px;
    padding: 15px 25px;
    color: white;
    cursor: pointer;
    transition: all 0.4s ease;
    pointer-events: auto;
    font-weight: 500;
}

.hero-nav-btn:hover {
    background: rgba(42, 131, 233, 0.8);
    border-color: rgba(42, 131, 233, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(42, 131, 233, 0.4);
}

.hero-prev {
    flex-direction: row;
}

.hero-next {
    flex-direction: row-reverse;
}

.nav-icon {
    font-size: 1.1rem;
    transition: transform 0.3s ease;
}

.hero-nav-btn:hover .nav-icon {
    transform: scale(1.2);
}

.nav-text {
    font-size: 0.9rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Scroll Indicator */
.scroll-indicator {
    position: absolute;
    bottom: 30px;
    right: 50px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    color: white;
    z-index: 15;
    animation: fadeInUp 1s ease-out 2.5s both;
    cursor: pointer;
}

.scroll-text {
    font-size: 0.8rem;
    letter-spacing: 1px;
    text-transform: uppercase;
    writing-mode: vertical-rl;
    font-weight: 500;
}

.scroll-arrow {
    width: 30px;
    height: 30px;
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
    40% { transform: translateY(-10px); }
    60% { transform: translateY(-5px); }
}

/* Mobile responsive */
@media (max-width: 768px) {
    .hero-cta-group {
        flex-direction: column;
        align-items: center;
        gap: 15px;
        margin-bottom: 3rem;
    }
    
    .btn-hero-primary,
    .btn-hero-secondary {
        width: 100%;
        max-width: 280px;
        justify-content: center;
    }
    
    .hero-stats {
        justify-content: center;
        gap: 1.5rem;
        flex-wrap: wrap;
    }
    
    .hero-navigation {
        padding: 0 20px;
    }
    
    .hero-nav-btn {
        padding: 12px 20px;
    }
    
    .nav-text {
        display: none;
    }
    
    .scroll-indicator {
        display: none;
    }
    
    .hero-indicators {
        bottom: 20px;
        gap: 10px;
    }
    
    .hero-indicator {
        padding: 6px 12px;
    }
    
    .indicator-line {
    width: 20px;
    }
    
    .hero-indicator.active .indicator-line {
        width: 25px;
    }
}

@media (max-width: 576px) {
    .stat-number {
        font-size: 2rem;
    }
    
    .hero-badge {
        padding: 6px 16px;
    }
    
    .badge-text {
        font-size: 0.8rem;
    }
}

/* ===== OTHER SECTIONS ===== */
.features-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
}

/* ===== CATEGORIES SECTION WITH BLUE BACKGROUND ===== */
.categories-section {
    background: linear-gradient(135deg, #2A83E9 0%, #1565C0 100%);
    position: relative;
    overflow: hidden;
}

.categories-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="pattern" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23pattern)"/></svg>');
    opacity: 0.3;
    pointer-events: none;
}

.categories-section .section-title {
    color: white !important;
}

.categories-section .title-highlight {
    color: rgba(255, 255, 255, 0.9) !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.categories-section .section-subtitle {
    color: rgba(255, 255, 255, 0.85) !important;
}

.categories-section .title-line {
    background: rgba(255, 255, 255, 0.8);
}

.categories-section .title-dot {
    background: rgba(255, 255, 255, 0.9);
}

.feature-card {
    background: white;
    padding: 2rem 1.5rem;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(42, 131, 233, 0.1);
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(42, 131, 233, 0.15);
}

.feature-icon {
    width: 70px;
    height: 70px;
    background: linear-gradient(45deg, #2A83E9, #1565C0);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    font-size: 1.8rem;
    color: white;
    box-shadow: 0 4px 15px rgba(42, 131, 233, 0.3);
}

.feature-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2A83E9;
    margin-bottom: 0.5rem;
}

.feature-text {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.5;
    margin-bottom: 0;
}

/* Section Headers */
.section-header .section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1rem;
    line-height: 1.2;
}

.title-highlight {
    color: #2A83E9;
    position: relative;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 2rem;
    font-weight: 300;
}

.title-decoration {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}

.title-line {
    width: 50px;
    height: 3px;
    background: linear-gradient(45deg, #2A83E9, #1565C0);
    border-radius: 2px;
}

.title-dot {
    width: 8px;
    height: 8px;
    background: #2A83E9;
    border-radius: 50%;
}

/* Modern Cards */
.modern-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
    transition: all 0.4s ease;
    border: 1px solid rgba(0,0,0,0.05);
    height: 100%;
}

.modern-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 40px rgba(42, 131, 233, 0.15);
}

/* Product cards and other styling */
.product-card {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    background: white;
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    border-radius: 20px 20px 0 0;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.product-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 0.75rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.4;
}

.product-name a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-name a:hover {
    color: #2A83E9;
}

.product-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.feature-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    color: white;
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
}

.feature-badge i {
    font-size: 0.75rem;
}

.product-rating {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.stars {
    color: #ffc107;
    display: flex;
    gap: 0.2rem;
}

.rating-text {
    color: #6c757d;
    font-size: 0.9rem;
}

.product-price {
    margin-bottom: 1.25rem;
}

.price-group {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.current-price {
    font-size: 1.25rem;
    font-weight: 700;
    color: #2A83E9;
}

.original-price {
    font-size: 1rem;
    color: #6c757d;
    text-decoration: line-through;
}

.discount-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: #dc3545;
    color: white;
    padding: 0.4rem 0.75rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
}

.product-actions-bottom {
    margin-top: auto;
}

.btn-add-cart {
    width: 100%;
    padding: 0.8rem;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    color: white;
    border: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(42, 131, 233, 0.2);
}

.btn-add-cart:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(42, 131, 233, 0.3);
}

.btn-add-cart:active {
    transform: translateY(0);
}

.out-of-stock {
    width: 100%;
    padding: 0.8rem;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    background: #f8f9fa;
    color: #dc3545;
    border: 1px solid #dc3545;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    border-radius: 20px 20px 0 0;
}

.product-actions {
    display: flex;
    gap: 1rem;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.action-btn {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #2A83E9;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.action-btn:hover {
    background: #2A83E9;
    color: white;
    transform: scale(1.1);
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-card:hover .product-actions {
    transform: translateY(0);
}

.product-card:hover .product-image {
    transform: scale(1.1);
}

/* Category Card Styles */
.category-card {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

/* ===== COMPACT CATEGORY CARDS ===== */
.category-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
    transition: all 0.3s ease;
}

.category-card-compact {
    background: rgba(255, 255, 255, 0.98);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    transition: all 0.4s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    height: 90px;
    display: flex;
    align-items: center;
    padding: 1rem;
    position: relative;
    backdrop-filter: blur(10px);
    cursor: pointer;
}

.category-card-link:hover .category-card-compact {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.25);
    border-color: rgba(255, 255, 255, 0.6);
    background: rgba(255, 255, 255, 1);
}

.category-card-compact::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1), rgba(255, 255, 255, 0.05));
    pointer-events: none;
    border-radius: 15px;
}

.category-card-compact::after {
    content: '';
    position: absolute;
    top: 50%;
    right: 1rem;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid #2A83E9;
    border-top: 4px solid transparent;
    border-bottom: 4px solid transparent;
    opacity: 0;
    transition: all 0.3s ease;
    z-index: 4;
}

.category-card-link:hover .category-card-compact::after {
    opacity: 1;
    right: 0.75rem;
}

.category-content-left {
    flex: 1;
    padding-right: 0.75rem;
    position: relative;
    z-index: 2;
}

.category-content-left .category-name {
    font-size: 1rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 0.25rem;
    line-height: 1.2;
    transition: color 0.3s ease;
}

.category-card-link:hover .category-name {
    color: #2A83E9;
}

.category-content-left .category-description {
    color: #6c757d;
    font-size: 0.75rem;
    margin-bottom: 0;
    line-height: 1.3;
    font-weight: 500;
    transition: color 0.3s ease;
}

.category-card-link:hover .category-description {
    color: #495057;
}

.category-image-right {
    position: relative;
    width: 50px;
    height: 50px;
    flex-shrink: 0;
    z-index: 2;
}

.category-image-compact {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.category-placeholder-compact {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    color: #6c757d;
    font-size: 1rem;
    border-radius: 10px;
    border: 2px solid rgba(255, 255, 255, 0.8);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.category-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.2rem 0.4rem;
    border-radius: 10px;
    min-width: 20px;
    text-align: center;
    box-shadow: 0 3px 10px rgba(220, 53, 69, 0.4);
    border: 2px solid white;
    line-height: 1;
    z-index: 3;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .category-card-compact {
        height: 80px;
        padding: 0.75rem;
    }
    
    .category-card-compact::after {
        border-left: 5px solid #2A83E9;
        border-top: 3px solid transparent;
        border-bottom: 3px solid transparent;
        right: 0.75rem;
    }
    
    .category-card-link:hover .category-card-compact::after {
        right: 0.5rem;
    }
    
    .category-content-left .category-name {
        font-size: 0.9rem;
    }
    
    .category-content-left .category-description {
        font-size: 0.7rem;
    }
    
    .category-image-right {
        width: 40px;
        height: 40px;
    }
    
    .category-badge {
        top: -4px;
        right: -4px;
        font-size: 0.65rem;
        padding: 0.1rem 0.25rem;
        min-width: 16px;
    }
    
    .categories-section .section-title {
        font-size: 2rem;
    }
    
    .categories-section .section-subtitle {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .category-card-compact {
        height: 70px;
        padding: 0.6rem;
    }
    
    .category-card-compact::after {
        border-left: 4px solid #2A83E9;
        border-top: 2px solid transparent;
        border-bottom: 2px solid transparent;
        right: 0.5rem;
    }
    
    .category-card-link:hover .category-card-compact::after {
        right: 0.3rem;
    }
    
    .category-content-left .category-name {
        font-size: 0.85rem;
        margin-bottom: 0.2rem;
    }
    
    .category-content-left .category-description {
        font-size: 0.65rem;
    }
    
    .category-image-right {
        width: 35px;
        height: 35px;
    }
    
    .categories-section .section-title {
        font-size: 1.8rem;
    }
    
    .categories-section .section-subtitle {
        font-size: 0.9rem;
    }
}

/* Blog Card Styles */
.blog-section {
    background: #f8f9fa;
}

.blog-card {
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.blog-image-wrapper {
    position: relative;
    width: 100%;
    height: 220px;
    overflow: hidden;
    border-radius: 20px 20px 0 0;
}

.blog-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.4s ease;
}

.blog-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #e9ecef, #f8f9fa);
    color: #adb5bd;
    font-size: 2.5rem;
}

.blog-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(42, 131, 233, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.3s ease;
    border-radius: 20px 20px 0 0;
}

.blog-overlay-content {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    color: white;
    font-weight: 600;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.blog-overlay-content i {
    font-size: 1.5rem;
}

.blog-card:hover .blog-overlay {
    opacity: 1;
}

.blog-card:hover .blog-overlay-content {
    transform: translateY(0);
}

.blog-card:hover .blog-image {
    transform: scale(1.1);
}

.blog-content {
    padding: 1.5rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.blog-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.blog-category {
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.blog-date {
    color: #6c757d;
    font-size: 0.85rem;
}

.blog-title {
    margin-bottom: 1rem;
}

.blog-title a {
    color: #2c3e50;
    text-decoration: none;
    font-weight: 600;
    font-size: 1.1rem;
    line-height: 1.4;
    transition: color 0.3s ease;
}

.blog-title a:hover {
    color: #2A83E9;
}

.blog-excerpt {
    color: #6c757d;
    font-size: 0.9rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
    flex: 1;
}

.blog-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.blog-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #6c757d;
    font-size: 0.85rem;
}

.blog-author i {
    color: #2A83E9;
}

.blog-read-more {
    color: #2A83E9;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.blog-read-more:hover {
    color: #1565C0;
    gap: 0.75rem;
}

.blog-read-more i {
    font-size: 0.8rem;
    transition: transform 0.3s ease;
}

.blog-read-more:hover i {
    transform: translateX(3px);
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced Hero Slider Functionality
    const heroSlider = document.getElementById('heroCarousel');
    const heroSlides = document.querySelectorAll('.hero-slide');
    const heroIndicators = document.querySelectorAll('.hero-indicator');
    const scrollIndicator = document.querySelector('.scroll-indicator');
    
    // Add hero-active class to body
    document.body.classList.add('hero-active');
    
    // Monitor scroll to show/hide navbar
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        clearTimeout(scrollTimeout);
        
        const scrollTop = window.pageYOffset;
        const heroHeight = window.innerHeight;
        
        if (scrollTop > heroHeight * 0.8) {
            document.body.classList.remove('hero-active');
            // Force show navbar when scrolling down
            const navbar = document.querySelector('.navbar');
            if (navbar) {
                navbar.style.opacity = '1';
                navbar.style.transform = 'translateY(0)';
                navbar.style.position = 'fixed';
                navbar.style.top = '0';
                navbar.style.zIndex = '9999';
                navbar.style.width = '100vw';
                navbar.style.left = '0';
                navbar.style.right = '0';
            }
        } else {
            document.body.classList.add('hero-active');
            // Hide navbar when at top
            const navbar = document.querySelector('.navbar');
            if (navbar && scrollTop < heroHeight * 0.1) {
                navbar.style.opacity = '0';
                navbar.style.transform = 'translateY(-100%)';
            }
        }
    });
    
    // Initialize slider
    if (heroSlider) {
        heroSlider.classList.add('loaded');
        
        // Parallax effect on scroll
        let ticking = false;
        
        function updateParallax() {
            const scrollTop = window.pageYOffset;
            const rate = scrollTop * -0.5;
            
            heroSlides.forEach(slide => {
                const heroImage = slide.querySelector('.hero-image-container');
                if (heroImage) {
                    heroImage.style.transform = `translateY(${rate}px) scale(1.1)`;
                }
            });
            
            ticking = false;
        }
        
        function requestTick() {
            if (!ticking) {
                requestAnimationFrame(updateParallax);
                ticking = true;
            }
        }
        
        window.addEventListener('scroll', requestTick);
        
        // Interactive particles
        function createInteractiveParticles() {
            heroSlides.forEach(slide => {
                const particlesContainer = slide.querySelector('.hero-particles');
                if (particlesContainer) {
                    slide.addEventListener('mousemove', function(e) {
                        const rect = this.getBoundingClientRect();
                        const x = (e.clientX - rect.left) / rect.width;
                        const y = (e.clientY - rect.top) / rect.height;
                        
                        const particles = this.querySelectorAll('.particle');
                        particles.forEach((particle, index) => {
                            const speed = (index + 1) * 0.5;
                            const xOffset = (x - 0.5) * speed * 10;
                            const yOffset = (y - 0.5) * speed * 10;
                            
                            particle.style.transform = `translate(${xOffset}px, ${yOffset}px)`;
                        });
                    });
                    
                    slide.addEventListener('mouseleave', function() {
                        const particles = this.querySelectorAll('.particle');
                        particles.forEach(particle => {
                            particle.style.transform = 'translate(0px, 0px)';
                        });
                    });
                }
            });
        }
        
        createInteractiveParticles();
        
        // Enhanced indicator functionality
        heroIndicators.forEach((indicator, index) => {
            indicator.addEventListener('click', function() {
                heroIndicators.forEach(ind => ind.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Auto-play enhancement
        let autoPlayInterval;
        
        function startAutoPlay() {
            autoPlayInterval = setInterval(() => {
                const nextButton = document.querySelector('.hero-next');
                if (nextButton) {
                    nextButton.click();
                }
            }, 6000);
        }
        
        function stopAutoPlay() {
            if (autoPlayInterval) {
                clearInterval(autoPlayInterval);
            }
        }
        
        heroSlider.addEventListener('mouseenter', stopAutoPlay);
        heroSlider.addEventListener('mouseleave', startAutoPlay);
        startAutoPlay();
        
        // Smooth scroll for scroll indicator
        if (scrollIndicator) {
            scrollIndicator.addEventListener('click', function() {
                const nextSection = document.querySelector('.main-content');
                if (nextSection) {
                    nextSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        }
        
        // Slide change detection
        heroSlider.addEventListener('slide.bs.carousel', function(e) {
            heroIndicators.forEach((indicator, index) => {
                indicator.classList.toggle('active', index === e.to);
            });
        });
        
        // Touch/Swipe support for mobile
        let startX = 0;
        let startY = 0;
        let endX = 0;
        let endY = 0;
        
        heroSlider.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
        });
        
        heroSlider.addEventListener('touchend', function(e) {
            endX = e.changedTouches[0].clientX;
            endY = e.changedTouches[0].clientY;
            
            const deltaX = endX - startX;
            const deltaY = endY - startY;
            
            if (Math.abs(deltaX) > Math.abs(deltaY) && Math.abs(deltaX) > 50) {
                if (deltaX > 0) {
                    document.querySelector('.hero-prev').click();
                } else {
                    document.querySelector('.hero-next').click();
                }
            }
        });
        
        // Progressive image loading
        function loadHeroImages() {
            heroSlides.forEach(slide => {
                const img = slide.querySelector('.hero-image');
                const bgElement = slide.querySelector('.hero-background');
                const bgData = bgElement.dataset.bg;
                
                if (img && bgData) {
                    // Set background-image for .hero-background
                    bgElement.style.backgroundImage = `url(${bgData})`;
                    bgElement.style.backgroundSize = 'cover';
                    bgElement.style.backgroundPosition = 'center';
                    bgElement.style.backgroundRepeat = 'no-repeat';
                    
                    // Add loading class
                    img.classList.add('loading');
                    
                    const tempImg = new Image();
                    tempImg.onload = function() {
                        // Detect image aspect ratio and apply appropriate class
                        const aspectRatio = this.width / this.height;
                        
                        if (aspectRatio > 1.8) {
                            img.classList.add('landscape');
                        } else if (aspectRatio < 1.2) {
                            img.classList.add('portrait');
                        } else if (aspectRatio >= 0.9 && aspectRatio <= 1.1) {
                            img.classList.add('square');
                        } else {
                            img.classList.add('landscape');
                        }
                        
                        // Remove loading and show image
                        img.classList.remove('loading');
                        img.style.opacity = '1';
                        slide.classList.add('loaded');
                        
                        console.log(`Image loaded: ${this.width}x${this.height}, ratio: ${aspectRatio.toFixed(2)}`);
                    };
                    
                    tempImg.onerror = function() {
                        console.error('Failed to load image:', bgData);
                        img.classList.remove('loading');
                        slide.classList.add('loaded');
                    };
                    
                    tempImg.src = bgData;
                }
            });
        }
        
        loadHeroImages();
    }
    
    // Enhanced add to cart functionality
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    const quickAddButtons = document.querySelectorAll('.quick-add-cart');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.btn-add-cart');
            const originalText = button.innerHTML;
            
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm...';
            button.disabled = true;
            
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm!';
            
            setTimeout(() => {
                this.submit();
            }, 500);
            }, 800);
        });
    });
    
    // Quick add to cart
    quickAddButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            
            icon.className = 'fas fa-spinner fa-spin';
            
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("cart.add") }}';
            form.innerHTML = `
                @csrf
                <input type="hidden" name="product_id" value="${productId}">
                <input type="hidden" name="quantity" value="1">
            `;
            
            document.body.appendChild(form);
            
            setTimeout(() => {
                icon.className = 'fas fa-check';
                setTimeout(() => {
                    form.submit();
                }, 300);
            }, 800);
        });
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
@endpush 