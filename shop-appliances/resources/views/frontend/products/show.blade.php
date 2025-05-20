@extends('layouts.frontend')

@section('title', $product->name)

@section('content')
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
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
        <div class="col-md-6 mb-4">
            <img src="{{ asset('storage/' . $product->image) }}" 
                 class="img-fluid rounded" 
                 alt="{{ $product->name }}">
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <div class="mb-4">
                @if($product->discount_price)
                    <h3>
                        <span class="text-danger">${{ $product->discount_price }}</span>
                        <small class="text-muted text-decoration-line-through">
                            ${{ $product->price }}
                        </small>
                    </h3>
                @else
                    <h3 class="text-primary">${{ $product->price }}</h3>
                @endif
            </div>

            <div class="mb-4">
                <h5>Description:</h5>
                <p>{{ $product->description }}</p>
            </div>

            @auth
                <form action="{{ route('cart.add') }}" method="POST" class="mb-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <div class="row g-3">
                        <div class="col-auto">
                            <input type="number" 
                                   name="quantity" 
                                   class="form-control" 
                                   value="1" 
                                   min="1" 
                                   style="width: 100px;">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-info">
                    Please <a href="{{ route('login') }}">login</a> to add items to cart.
                </div>
            @endauth

            <!-- Additional Product Information -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Product Information</h5>
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Category:</td>
                            <td>{{ $product->category->name }}</td>
                        </tr>
                        <tr>
                            <td>Availability:</td>
                            <td>
                                @if($product->is_active)
                                    <span class="badge bg-success">In Stock</span>
                                @else
                                    <span class="badge bg-danger">Out of Stock</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection 