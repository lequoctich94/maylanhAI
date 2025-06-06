@extends('layouts.frontend')

@section('title', 'Products')

@section('content')
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Tất cả sản phẩm</h2>
                <div class="btn-group">
                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                        Sort By
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="?sort=price_asc">Price: Low to High</a></li>
                        <li><a class="dropdown-item" href="?sort=price_desc">Price: High to Low</a></li>
                        <li><a class="dropdown-item" href="?sort=newest">Newest First</a></li>
                    </ul>
                </div>
            </div>

            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $product->image) }}" 
                                 class="card-img-top" 
                                 alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                
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
                                
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        @if($product->discount_price)
                                            <span class="text-muted text-decoration-line-through">
                                                ${{ $product->price }}
                                            </span>
                                            <span class="text-danger">${{ $product->discount_price }}</span>
                                        @else
                                            <span class="text-primary">${{ $product->price }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-white border-top-0">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('products.show', $product->slug) }}" 
                                       class="btn btn-primary">View Details</a>
                                    @auth
                                        <form action="{{ route('cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-outline-primary w-100">
                                                Add to Cart
                                            </button>
                                        </form>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No products found.
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $products->links() }}
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