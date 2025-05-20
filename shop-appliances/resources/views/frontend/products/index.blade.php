@extends('layouts.frontend')

@section('title', 'Products')

@section('content')
    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Categories</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($categories as $category)
                            <a href="{{ route('products.category', $category->slug) }}" 
                               class="list-group-item list-group-item-action">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>All Products</h2>
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