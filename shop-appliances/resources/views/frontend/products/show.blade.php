@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
            <li class="breadcrumb-item">
                <a href="{{ route('products.category', $product->category->slug) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-lg-6 mb-4">
            <div class="product-image-container">
                <img src="{{ asset('storage/' . $product->image) }}" 
                     class="img-fluid rounded product-main-image" 
                     alt="{{ $product->name }}">
                
                @if($product->discount_price)
                    <div class="discount-badge-large">
                        <span class="discount-text">GIẢM GIÁ</span>
                        <span class="discount-percent">
                            -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                        </span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Product Basic Info -->
        <div class="col-lg-6">
            <div class="product-info-card">
                <h1 class="product-title">{{ $product->name }}</h1>
                
                <!-- Highlight Attributes -->
                @if($product->attributes->where('attribute.is_highlight', true)->count() > 0)
                    <div class="highlight-features mb-4">
                        @foreach($product->attributes->where('attribute.is_highlight', true) as $productAttribute)
                            @if($productAttribute->value && !($productAttribute->attribute->type === 'checkbox' && $productAttribute->value !== '1'))
                                <span class="feature-highlight" 
                                      style="background-color: {{ $productAttribute->attribute->highlight_color ?? '#2A83E9' }};">
                                    @if($productAttribute->attribute->type === 'checkbox')
                                        <i class="fas fa-check me-2"></i>{{ $productAttribute->attribute->name }}
                                    @else
                                        <i class="fas fa-star me-2"></i>{{ $productAttribute->attribute->name }}: {{ $productAttribute->value }}
                                    @endif
                                </span>
                            @endif
                        @endforeach
                    </div>
                @endif
                
                <!-- Price -->
                <div class="price-section mb-4">
                    @if($product->discount_price)
                        <div class="price-group">
                            <span class="current-price">{{ number_format($product->discount_price) }}đ</span>
                            <span class="original-price">{{ number_format($product->price) }}đ</span>
                            <span class="savings">
                                Tiết kiệm {{ number_format($product->price - $product->discount_price) }}đ
                            </span>
                        </div>
                    @else
                        <span class="current-price">{{ number_format($product->price) }}đ</span>
                    @endif
                </div>

                <!-- Availability -->
                <div class="availability-section mb-4">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        <span class="fw-bold">Tình trạng:</span>
                        @if($product->is_active)
                            <span class="badge bg-success ms-2">
                                <i class="fas fa-check me-1"></i>Còn Hàng
                            </span>
                        @else
                            <span class="badge bg-danger ms-2">
                                <i class="fas fa-times me-1"></i>Hết Hàng
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Quick Info -->
                <div class="quick-info mb-4">
                    <div class="info-item">
                        <i class="fas fa-truck text-primary"></i>
                        <span>Miễn phí vận chuyển nội thành</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-tools text-primary"></i>
                        <span>Lắp đặt miễn phí</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-shield-alt text-primary"></i>
                        <span>Bảo hành chính hãng</span>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-headset text-primary"></i>
                        <span>Hỗ trợ 24/7</span>
                    </div>
                </div>

                <!-- Add to Cart -->
                @if($product->is_active)
                    <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <label class="form-label mb-0 fw-bold">Số lượng:</label>
                            <input type="number" 
                                   name="quantity" 
                                   class="form-control quantity-input" 
                                   value="1" 
                                   min="1" 
                                   style="width: 100px;">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg add-cart-btn">
                                <i class="fas fa-shopping-cart me-2"></i>Thêm Vào Giỏ Hàng
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-phone me-2"></i>Gọi Tư Vấn: 0123 456 789
                            </button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Sản phẩm này hiện đang hết hàng.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Product Description Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="product-details-section">
                <ul class="nav nav-tabs product-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                                data-bs-target="#description" type="button" role="tab">
                            <i class="fas fa-file-alt me-2"></i>Mô Tả Sản Phẩm
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                                data-bs-target="#specifications" type="button" role="tab">
                            <i class="fas fa-list me-2"></i>Thông Số Kỹ Thuật
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="warranty-tab" data-bs-toggle="tab" 
                                data-bs-target="#warranty" type="button" role="tab">
                            <i class="fas fa-shield-alt me-2"></i>Bảo Hành & Hỗ Trợ
                        </button>
                    </li>
                </ul>
                
                <div class="tab-content product-tab-content" id="productTabsContent">
                    <!-- Description Tab -->
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="description-content">
                            <h4 class="section-title">
                                <i class="fas fa-info-circle text-primary me-2"></i>
                                Mô Tả Chi Tiết
                            </h4>
                            <div class="description-text">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    </div>
                    
                    <!-- Specifications Tab -->
                    <div class="tab-pane fade" id="specifications" role="tabpanel">
                        <div class="specifications-content">
                            <h4 class="section-title">
                                <i class="fas fa-cog text-primary me-2"></i>
                                Thông Số Kỹ Thuật
                            </h4>
                            <div class="specifications-table">
                                <table class="table table-striped">
                                    <tbody>
                                        <tr>
                                            <td class="spec-label">Danh mục:</td>
                                            <td>{{ $product->category->name }}</td>
                                        </tr>
                                        @foreach($product->attributes as $productAttribute)
                                            @if($productAttribute->value)
                                                <tr>
                                                    <td class="spec-label">{{ $productAttribute->attribute->name }}:</td>
                                                    <td>
                                                        @if($productAttribute->attribute->type === 'checkbox')
                                                            @if($productAttribute->value === '1')
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check me-1"></i>Có
                                                                </span>
                                                            @else
                                                                <span class="badge bg-secondary">
                                                                    <i class="fas fa-times me-1"></i>Không
                                                                </span>
                                                            @endif
                                                        @else
                                                            {{ $productAttribute->value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Warranty Tab -->
                    <div class="tab-pane fade" id="warranty" role="tabpanel">
                        <div class="warranty-content">
                            <h4 class="section-title">
                                <i class="fas fa-shield-alt text-primary me-2"></i>
                                Chính Sách Bảo Hành
                            </h4>
                            <div class="warranty-info">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="warranty-item">
                                            <h6><i class="fas fa-clock text-success me-2"></i>Thời Gian Bảo Hành</h6>
                                            <p>12 tháng bảo hành chính hãng từ nhà sản xuất</p>
                                        </div>
                                        <div class="warranty-item">
                                            <h6><i class="fas fa-tools text-info me-2"></i>Dịch Vụ Lắp Đặt</h6>
                                            <p>Miễn phí lắp đặt tại nhà trong vòng 24h</p>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="warranty-item">
                                            <h6><i class="fas fa-phone text-primary me-2"></i>Hỗ Trợ Khách Hàng</h6>
                                            <p>Hotline: <strong>0123 456 789</strong> (24/7)</p>
                                        </div>
                                        <div class="warranty-item">
                                            <h6><i class="fas fa-exchange-alt text-warning me-2"></i>Chính Sách Đổi Trả</h6>
                                            <p>Đổi trả trong 7 ngày nếu có lỗi từ nhà sản xuất</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* ===== PRODUCT DETAIL STYLES ===== */
.product-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 15px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.product-main-image {
    width: 100%;
    height: auto;
    border-radius: 15px;
    transition: transform 0.3s ease;
}

.product-main-image:hover {
    transform: scale(1.05);
}

.discount-badge-large {
    position: absolute;
    top: 20px;
    right: 20px;
    background: linear-gradient(135deg, #dc3545, #c82333);
    color: white;
    padding: 12px 16px;
    border-radius: 15px;
    text-align: center;
    box-shadow: 0 4px 15px rgba(220, 53, 69, 0.4);
    border: 3px solid white;
}

.discount-text {
    display: block;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 1px;
}

.discount-percent {
    display: block;
    font-size: 1.2rem;
    font-weight: 800;
    margin-top: 2px;
}

.product-info-card {
    padding: 2rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    height: fit-content;
}

.product-title {
    font-size: 2rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    line-height: 1.3;
}

/* Highlight Features */
.highlight-features {
    display: flex;
    flex-wrap: wrap;
    gap: 0.75rem;
}

.feature-highlight {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    color: white;
    font-size: 0.9rem;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

/* Price Section */
.price-section {
    padding: 1.5rem;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 15px;
    border: 2px solid #2A83E9;
}

.current-price {
    font-size: 1.8rem;
    font-weight: 800;
    color: #2A83E9;
    display: block;
}

.original-price {
    font-size: 1.2rem;
    color: #6c757d;
    text-decoration: line-through;
    display: block;
    margin-top: 0.5rem;
}

.savings {
    display: inline-block;
    background: #dc3545;
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 0.5rem;
}

/* Quick Info */
.quick-info {
    background: #f8f9fa;
    padding: 1.5rem;
    border-radius: 15px;
    border-left: 4px solid #2A83E9;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 0.75rem;
    font-size: 0.95rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item i {
    width: 20px;
    text-align: center;
}

/* Buttons */
.add-cart-btn {
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    border: none;
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.add-cart-btn:hover {
    background: linear-gradient(135deg, #1565C0, #0d47a1);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(42, 131, 233, 0.4);
}

.quantity-input {
    border: 2px solid #2A83E9;
    border-radius: 10px;
    text-align: center;
    font-weight: 600;
}

/* Product Details Section */
.product-details-section {
    margin-top: 3rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    overflow: hidden;
}

.product-tabs {
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-bottom: 3px solid #2A83E9;
}

.product-tabs .nav-link {
    color: #6c757d;
    font-weight: 600;
    padding: 1.25rem 2rem;
    border: none;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
}

.product-tabs .nav-link:hover {
    color: #2A83E9;
    background: rgba(42, 131, 233, 0.1);
}

.product-tabs .nav-link.active {
    color: #2A83E9;
    background: white;
    border-bottom-color: #2A83E9;
}

.product-tab-content {
    padding: 2rem;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 1.5rem;
    padding-bottom: 0.75rem;
    border-bottom: 2px solid #e9ecef;
}

.description-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #495057;
    text-align: justify;
}

/* Specifications Table */
.specifications-table .table {
    margin-bottom: 0;
}

.spec-label {
    font-weight: 600;
    color: #2c3e50;
    width: 30%;
    background: #f8f9fa;
}

/* Warranty Content */
.warranty-item {
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 10px;
    border-left: 4px solid #2A83E9;
}

.warranty-item h6 {
    margin-bottom: 0.5rem;
    color: #2c3e50;
}

.warranty-item p {
    margin-bottom: 0;
    color: #6c757d;
}

/* Responsive */
@media (max-width: 768px) {
    .product-title {
        font-size: 1.5rem;
    }
    
    .current-price {
        font-size: 1.5rem;
    }
    
    .original-price {
        font-size: 1rem;
    }
    
    .product-info-card {
        padding: 1.5rem;
    }
    
    .product-tab-content {
        padding: 1.5rem;
    }
    
    .product-tabs .nav-link {
        padding: 1rem;
        font-size: 0.9rem;
    }
}

/* Breadcrumb Styling */
.breadcrumb {
    background: transparent;
    padding: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    color: #2A83E9;
}

.breadcrumb-item a {
    color: #2A83E9;
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: #1565C0;
    text-decoration: underline;
}

.breadcrumb-item.active {
    color: #6c757d;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add to cart functionality
    const addToCartForm = document.querySelector('.add-to-cart-form');
    
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('.add-cart-btn');
            const originalContent = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang thêm vào giỏ...';
            button.disabled = true;
            
            // Simulate loading time
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check me-2"></i>Đã thêm thành công!';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                
                // Submit the form after showing success
                setTimeout(() => {
                    this.submit();
                }, 1000);
            }, 1200);
        });
    }
    
    // Smooth scroll for tabs
    const tabButtons = document.querySelectorAll('.product-tabs .nav-link');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            setTimeout(() => {
                document.querySelector('.product-details-section').scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }, 100);
        });
    });
});
</script>
@endpush 