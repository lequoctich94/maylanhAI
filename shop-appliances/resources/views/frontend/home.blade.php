@extends('layouts.frontend')

@section('title', 'Home')

@section('content')
    <!-- Slider Section -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($slides as $key => $slide)
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $key }}" 
                class="{{ $key == 0 ? 'active' : '' }}" aria-current="true" aria-label="Slide {{ $key + 1 }}">
            </button>
            @endforeach
        </div>
        
        <div class="carousel-inner">
            @foreach($slides as $key => $slide)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $slide->image) }}" class="d-block w-100" alt="{{ $slide->title }}">
                <div class="carousel-caption d-none d-md-block">
                    <h2>{{ $slide->title }}</h2>
                    <p>{{ $slide->subtitle }}</p>
                    @if($slide->link)
                    <a href="{{ $slide->link }}" class="btn btn-primary">Xem thêm</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Categories Section -->
    <section class="mb-5 categories-section">
        <div class="container">
            <div class="section-title">
                <h2 class="text-center">Danh Mục Sản Phẩm</h2>
                <div class="title-line"></div>
            </div>
            <div class="row">
                @foreach($categories as $category)
                    <div class="col-md-3 mb-3">
                        <div class="card category-card h-100">
                            <div class="category-img-wrapper">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $category->name }}">
                                @else
                                    <img src="{{ asset('images/no-image.avif') }}" 
                                         class="card-img-top" 
                                         alt="No Image">
                                @endif
                                <div class="category-overlay">
                                    <a href="{{ route('products.category', $category->slug) }}" 
                                       class="btn btn-light btn-sm">
                                        Xem Sản Phẩm
                                    </a>
                                </div>
                            </div>
                            <div class="card-body text-center p-2">
                                <h6 class="card-title mb-0">{{ $category->name }}</h6>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="mb-5 featured-section">
        <div class="container">
            <div class="section-title">
                <h2 class="text-center">Sản Phẩm Mới Nhất</h2>
                <div class="title-line"></div>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md-3 mb-4">
                        <div class="card product-card h-100">
                            <div class="product-img-wrapper">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}">
                                @if($product->discount_price)
                                    <div class="discount-badge">
                                        -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </div>
                                @endif
                                <div class="product-overlay">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="btn btn-light btn-sm">
                                        Chi Tiết
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h6 class="card-title mb-2">
                                    <a href="{{ route('products.show', $product->slug) }}" class="product-name">
                                        {{ $product->name }}
                                    </a>
                                </h6>
                                <div class="product-price mb-3">
                                    <div class="price-label text-danger mb-1">Giá rẻ quá!</div>
                                    @if($product->discount_price)
                                        <div class="current-price text-danger mb-1">
                                            {{ number_format($product->discount_price) }}đ
                                        </div>
                                        <div class="original-price">
                                            <span class="text-muted text-decoration-line-through">
                                                {{ number_format($product->price) }}đ
                                            </span>
                                        </div>
                                    @else
                                        <div class="current-price text-danger">
                                            {{ number_format($product->price) }}đ
                                        </div>
                                    @endif
                                </div>
                                <button class="btn btn-primary btn-sm w-100 add-to-cart">
                                    <i class="fas fa-shopping-cart me-1"></i>Đặt hàng
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
.carousel-item {
    height: 500px;
}
.carousel-item img {
    object-fit: cover;
    height: 100%;
}
.carousel-caption {
    background: rgba(0,0,0,0.5);
    padding: 20px;
    border-radius: 10px;
}

.category-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    overflow: hidden;
}

.category-card:hover {
    transform: translateY(-3px);
}

.category-img-wrapper {
    position: relative;
    height: 180px;
    overflow: hidden;
}

.category-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-img-wrapper img {
    transform: scale(1.1);
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover .category-overlay {
    opacity: 1;
}

.category-overlay .btn {
    padding: 5px 15px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.8rem;
    background-color: #2A83E9;
    color: white;
    border: none;
}

.category-overlay .btn:hover {
    background-color: #1565C0;
    color: white;
}

.card-title {
    margin: 8px 0;
    font-weight: 500;
    color: #2A83E9;
    font-size: 0.95rem;
}

.categories-section {
    padding-top: 60px;
    padding-bottom: 40px;
    background-color: #f8f9fa;
}

.section-title {
    margin-bottom: 30px;
    position: relative;
    text-align: center;
    width: 100%;
}

.section-title h2 {
    font-size: 1.8rem;
    font-weight: 600;
    color: #2A83E9;
    text-transform: uppercase;
    margin-bottom: 15px;
    letter-spacing: 0.5px;
    position: relative;
    display: inline-block;
    padding-bottom: 12px;
    margin-left: auto;
    margin-right: auto;
}

.title-line {
    width: 60px;
    height: 3px;
    background: linear-gradient(to right, #2A83E9, #1565C0);
    margin: 0 auto;
    border-radius: 2px;
    transition: width 0.3s ease;
}

.section-title:hover .title-line {
    width: 80px;
}

.featured-section {
    padding-top: 60px;
    padding-bottom: 40px;
    background-color: white;
}

.product-card {
    background: white;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    transition: transform 0.3s ease;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-3px);
}

.product-img-wrapper {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.product-img-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-img-wrapper img {
    transform: scale(1.1);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.4);
    display: flex;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-overlay .btn {
    padding: 5px 15px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.8rem;
    background-color: #2A83E9;
    color: white;
    border: none;
}

.product-overlay .btn:hover {
    background-color: #1565C0;
    color: white;
}

.product-card .card-title {
    text-align: left;
    margin-bottom: 8px;
}

.product-price {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
}

.price-label {
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
}

.current-price {
    font-size: 1.1rem;
    font-weight: 600;
}

.original-price {
    font-size: 0.9rem;
}

.add-to-cart {
    background-color: #2A83E9;
    border-color: #2A83E9;
    transition: all 0.3s ease;
}

.add-to-cart:hover {
    background-color: #1565C0;
    border-color: #1565C0;
    transform: translateY(-2px);
}

.product-name {
    color: #2A83E9;
    text-decoration: none;
    transition: color 0.2s ease;
}

.product-name:hover {
    color: #1565C0;
}

.discount-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background-color: #ff4444;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 0.8rem;
    font-weight: 500;
}

.product-card .card-body {
    text-align: left;
}
</style>
@endpush 