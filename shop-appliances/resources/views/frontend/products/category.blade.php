@extends('layouts.frontend')

@section('title', $category->name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Category Info -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title">{{ $category->name }}</h1>
                    <p class="card-text">{{ $category->description }}</p>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-12">
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
                            No products found in this category.
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