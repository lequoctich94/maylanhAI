@extends('layouts.frontend')

@section('title', 'Tìm kiếm: ' . $query)

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Tìm kiếm: {{ $query }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Danh mục sản phẩm</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($categories as $category)
                            <a href="{{ route('products.category', $category->slug) }}" 
                               class="list-group-item list-group-item-action d-flex align-items-center">
                                <img src="{{ asset('storage/' . $category->image) }}" 
                                     alt="{{ $category->name }}"
                                     class="me-3"
                                     style="width: 40px; height: 40px; object-fit: cover;">
                                <div class="flex-grow-1">
                                    {{ $category->name }}
                                    <small class="text-muted d-block">({{ $category->products_count ?? 0 }} sản phẩm)</small>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-body">
                    <h4 class="mb-4">Kết quả tìm kiếm cho: "{{ $query }}"</h4>
                    
                    <div class="row">
                        @forelse($products as $product)
                            <div class="col-md-4 mb-4">
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
                                        
                                        <!-- Highlight Attributes -->
                                        @if($product->attributes->where('attribute.is_highlight', true)->count() > 0)
                                            <div class="highlight-attributes mb-2">
                                                @foreach($product->attributes->where('attribute.is_highlight', true) as $productAttribute)
                                                    @if($productAttribute->value && !($productAttribute->attribute->type === 'checkbox' && $productAttribute->value !== '1'))
                                                        <span class="badge highlight-badge" 
                                                              style="background-color: {{ $productAttribute->attribute->highlight_color ?? '#007bff' }};">
                                                            @if($productAttribute->attribute->type === 'checkbox')
                                                                Có {{ $productAttribute->attribute->name }}
                                                            @else
                                                                {{ $productAttribute->attribute->name }}: {{ $productAttribute->value }}
                                                            @endif
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                        
                                        <div class="product-price mb-3">
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
                                        @auth
                                            <form action="{{ route('cart.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit" class="btn btn-primary btn-sm w-100">
                                                    <i class="fas fa-shopping-cart me-1"></i>Đặt hàng
                                                </button>
                                            </form>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="alert alert-info">
                                    Không tìm thấy sản phẩm nào phù hợp với từ khóa "{{ $query }}".
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
        </div>
    </div>
@endsection

@push('styles')
<style>
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
</style>
@endpush 