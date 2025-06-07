@extends('layouts.frontend')

@section('title', 'Tất Cả Sản Phẩm')

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Tất Cả Sản Phẩm</li>
        </ol>
    </nav>

    <!-- Horizontal Categories Menu -->
    <div class="categories-nav mb-4">
        <div class="d-flex flex-wrap gap-2 align-items-center">
            <span class="text-muted me-3">
                <i class="fas fa-th-large me-1"></i>Danh mục:
            </span>
            <a href="{{ route('products.index') }}" 
               class="category-tab {{ !request('category') ? 'active' : '' }}">
                Tất Cả
                <span class="category-count">({{ $totalProducts ?? 0 }})</span>
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('products.category', $cat->slug) }}" 
                   class="category-tab">
                    {{ $cat->name }}
                    <span class="category-count">({{ $cat->products_count ?? 0 }})</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Full Width Content -->
    <div class="row">
        <div class="col-12">
            <!-- Compact Search and Sort Form -->
            <div class="card mb-4">
                <div class="card-header bg-light py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">
                            <i class="fas fa-filter me-2"></i>Tìm Kiếm & Sắp Xếp
                        </h6>
                        <button type="button" class="btn btn-sm btn-primary" id="toggleFilters">
                            <i class="fas fa-eye-slash me-1"></i>Ẩn Bộ Lọc
                        </button>
                    </div>
                </div>
                <div class="card-body" id="filtersContainer">
                    <form action="{{ route('products.index') }}" method="GET" class="row g-2" id="filterForm">
                        <!-- Search by name -->
                        <div class="col-md-4">
                            <input type="text" 
                                   class="form-control form-control-sm" 
                                   id="search" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Tìm kiếm sản phẩm...">
                        </div>

                        <!-- Sort Options -->
                        <div class="col-md-3">
                            <select class="form-select form-select-sm" name="sort">
                                <option value="">Sắp xếp theo</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Giá: Thấp đến Cao</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Giá: Cao đến Thấp</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mới Nhất</option>
                                <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Tên: A-Z</option>
                                <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Tên: Z-A</option>
                            </select>
                        </div>

                        <!-- Price Range -->
                        <div class="col-md-2">
                            <input type="number" 
                                   class="form-control form-control-sm" 
                                   name="min_price"
                                   value="{{ request('min_price') }}"
                                   placeholder="Giá từ...">
                        </div>
                        
                        <div class="col-md-2">
                            <input type="number" 
                                   class="form-control form-control-sm" 
                                   name="max_price"
                                   value="{{ request('max_price') }}"
                                   placeholder="Giá đến...">
                        </div>

                        <div class="col-md-1">
                            <div class="d-flex gap-1">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search"></i>
                                </button>
                                <a href="{{ route('products.index') }}" class="btn btn-primary btn-sm" style="background-color: #6c757d; border-color: #6c757d;">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">
                    <i class="fas fa-box-open me-2 text-primary"></i>
                    Tất Cả Sản Phẩm
                    <small class="text-muted">({{ $products->total() ?? 0 }} sản phẩm)</small>
                </h4>
            </div>

            <div class="row">
                @forelse($products as $product)
                    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 mb-4">
                        <div class="card h-100 product-card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $product->image) }}" 
                                     class="card-img-top" 
                                     alt="{{ $product->name }}"
                                     style="height: 180px; object-fit: cover;">
                                
                                @if($product->discount_price)
                                    <div class="position-absolute top-0 end-0 m-2">
                                        <span class="badge bg-danger">
                                            -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title" title="{{ $product->name }}">
                                    {{ Str::limit($product->name, 40) }}
                                </h6>
                                
                                <!-- Highlight Attributes -->
                                @if($product->attributes->where('attribute.is_highlight', true)->count() > 0)
                                    <div class="highlight-attributes mb-2">
                                        @foreach($product->attributes->where('attribute.is_highlight', true)->take(2) as $productAttribute)
                                            @if($productAttribute->value && !($productAttribute->attribute->type === 'checkbox' && $productAttribute->value !== '1'))
                                                <span class="badge highlight-badge" 
                                                      style="background-color: {{ $productAttribute->attribute->highlight_color ?? '#2A83E9' }};">
                                                    @if($productAttribute->attribute->type === 'checkbox')
                                                        <i class="fas fa-check me-1"></i>{{ Str::limit($productAttribute->attribute->name, 10) }}
                                                    @else
                                                        {{ Str::limit($productAttribute->value, 12) }}
                                                    @endif
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                                
                                <p class="card-text flex-grow-1 small text-muted">{{ Str::limit($product->description, 80) }}</p>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div>
                                        @if($product->discount_price)
                                            <div class="price-group">
                                                <small class="text-muted text-decoration-line-through d-block">
                                                    {{ number_format($product->price) }}đ
                                                </small>
                                                <span class="text-danger fw-bold">{{ number_format($product->discount_price) }}đ</span>
                                            </div>
                                        @else
                                            <span class="text-primary fw-bold">{{ number_format($product->price) }}đ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card-footer bg-white border-top-0 p-2">
                                <div class="d-grid gap-1">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>Xem Chi Tiết
                                    </a>
                                    @if($product->is_active)
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                                <i class="fas fa-shopping-cart me-1"></i>Đặt Hàng
                                            </button>
                                        </form>
                                    @else
                                        <button class="btn btn-secondary btn-sm w-100" disabled>
                                            <i class="fas fa-times me-1"></i>Hết Hàng
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-search me-2"></i>
                            Không tìm thấy sản phẩm nào phù hợp với tiêu chí tìm kiếm.
                            <br>
                            <a href="{{ route('products.index') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-redo me-1"></i>Xem Tất Cả Sản Phẩm
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
/* ===== SIMPLE CATEGORY TABS ===== */
.categories-nav {
    background: linear-gradient(135deg, #f8f9fa 0%, #e8f4fd 100%);
    border-radius: 8px;
    padding: 1rem;
    box-shadow: 0 2px 8px rgba(42, 131, 233, 0.1);
    border: 1px solid rgba(42, 131, 233, 0.1);
}

.category-tab {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 1rem;
    background: linear-gradient(135deg, #e3f2fd, #bbdefb);
    border: 1px solid #2A83E9;
    border-radius: 20px;
    text-decoration: none;
    color: #1565C0;
    font-weight: 500;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    white-space: nowrap;
}

.category-tab:hover {
    background: linear-gradient(135deg, #bbdefb, #90caf9);
    border-color: #1565C0;
    color: #0d47a1;
    text-decoration: none;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(42, 131, 233, 0.2);
}

.category-tab.active {
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    border-color: #2A83E9;
    color: white;
    box-shadow: 0 2px 8px rgba(42, 131, 233, 0.3);
}

.category-count {
    font-size: 0.8rem;
    opacity: 0.8;
}

/* ===== COMPACT FILTERS ===== */
.card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 1px solid #dee2e6;
}

/* Hide/Show filters animation */
#filtersContainer {
    transition: all 0.3s ease;
    overflow: hidden;
}

#filtersContainer.collapsed {
    max-height: 0;
    padding-top: 0;
    padding-bottom: 0;
    opacity: 0;
}

/* Product cards */
.highlight-attributes {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

.highlight-badge {
    font-size: 0.75rem;
    padding: 3px 8px;
    border-radius: 12px;
    color: white !important;
    font-weight: 500;
    text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    border: none;
}

.product-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.product-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(42, 131, 233, 0.15);
}

/* Responsive */
@media (max-width: 768px) {
    .categories-nav {
        padding: 0.75rem;
    }
    
    .category-tab {
        padding: 0.375rem 0.75rem;
        font-size: 0.8rem;
        margin-bottom: 0.25rem;
    }
    
    .category-count {
        display: none;
    }
}

/* ===== BLUE BUTTONS THEME ===== */
.btn-primary {
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    border-color: #2A83E9;
    color: white;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1565C0, #0d47a1);
    border-color: #1565C0;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(42, 131, 233, 0.3);
}

.btn-primary:active {
    transform: translateY(0);
    box-shadow: 0 2px 4px rgba(42, 131, 233, 0.2);
}

.btn-outline-primary {
    border-color: #2A83E9;
    color: #2A83E9;
    background: white;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: linear-gradient(135deg, #2A83E9, #1565C0);
    border-color: #2A83E9;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(42, 131, 233, 0.2);
}

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
    // Toggle filters functionality
    const toggleBtn = document.getElementById('toggleFilters');
    const filtersContainer = document.getElementById('filtersContainer');
    let filtersVisible = true;

    if (toggleBtn && filtersContainer) {
        toggleBtn.addEventListener('click', function() {
            filtersVisible = !filtersVisible;
            
            if (filtersVisible) {
                filtersContainer.classList.remove('collapsed');
                this.innerHTML = '<i class="fas fa-eye-slash me-1"></i>Ẩn Bộ Lọc';
            } else {
                filtersContainer.classList.add('collapsed');
                this.innerHTML = '<i class="fas fa-eye me-1"></i>Hiện Bộ Lọc';
            }
        });
    }

    // Auto-submit form when filters change
    const filterForm = document.getElementById('filterForm');
    const filterInputs = filterForm.querySelectorAll('select, input[type="number"]');
    
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Add small delay for better UX
            setTimeout(() => {
                filterForm.submit();
            }, 300);
        });
    });

    // Search input with debounce
    const searchInput = document.getElementById('search');
    let searchTimeout;
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                filterForm.submit();
            }, 1000); // 1 second delay
        });
    }

    // Clear search on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && searchInput) {
            searchInput.value = '';
            filterForm.submit();
        }
    });

    // Add to cart functionality
    const addToCartForms = document.querySelectorAll('form[action*="cart.add"]');
    
    addToCartForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const button = this.querySelector('button[type="submit"]');
            const originalContent = button.innerHTML;
            
            // Show loading state
            button.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Đang thêm...';
            button.disabled = true;
            
            // Simulate loading time
            setTimeout(() => {
                button.innerHTML = '<i class="fas fa-check me-1"></i>Đã thêm!';
                button.classList.remove('btn-primary');
                button.classList.add('btn-success');
                
                // Submit the form after showing success
                setTimeout(() => {
                    this.submit();
                }, 500);
            }, 800);
        });
    });
});
</script>
@endpush 