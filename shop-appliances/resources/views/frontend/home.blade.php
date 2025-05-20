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
                <img src="{{ asset('images/slides/' . $slide->image) }}" class="d-block w-100" alt="{{ $slide->title }}">
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
    <section class="mb-5">
        <h2 class="text-center mb-4">Shop by Category</h2>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $category->name }}</h5>
                            <p class="card-text">{{ $category->description }}</p>
                            <a href="{{ route('products.category', $category->slug) }}" class="btn btn-primary">
                                View Products
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="mb-5">
        <h2 class="text-center mb-4">Featured Products</h2>
        <div class="row">
            @foreach($products as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if($product->discount_price)
                                        <span class="text-muted text-decoration-line-through">${{ $product->price }}</span>
                                        <span class="text-danger">${{ $product->discount_price }}</span>
                                    @else
                                        <span class="text-primary">${{ $product->price }}</span>
                                    @endif
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
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
</style>
@endpush 