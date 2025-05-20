@extends('layouts.frontend')

@section('title', 'Shopping Cart')

@section('content')
    <h1 class="mb-4">Shopping Cart</h1>

    @if($cartItems->count() > 0)
        <div class="row">
            <!-- Cart Items -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        @foreach($cartItems as $item)
                            <div class="row mb-4">
                                <div class="col-md-3">
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $item->product->name }}">
                                </div>
                                <div class="col-md-9">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <a href="{{ route('products.show', $item->product->slug) }}" 
                                               class="text-dark text-decoration-none">
                                                {{ $item->product->name }}
                                            </a>
                                        </h5>
                                        <form action="{{ route('cart.remove', $item->id) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-link text-danger" 
                                                    onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <div class="mt-2">
                                        <p class="text-muted mb-0">
                                            Price: ${{ $item->product->discount_price ?? $item->product->price }}
                                        </p>
                                        <div class="d-flex align-items-center mt-2">
                                            <label class="me-2">Quantity:</label>
                                            <input type="number" 
                                                   class="form-control" 
                                                   style="width: 80px;" 
                                                   value="{{ $item->quantity }}" 
                                                   min="1"
                                                   data-item-id="{{ $item->id }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @unless($loop->last)
                                <hr>
                            @endunless
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cart Summary</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Subtotal:</span>
                            <span>${{ $cartItems->sum(function($item) {
                                return ($item->product->discount_price ?? $item->product->price) * $item->quantity;
                            }) }}</span>
                        </div>
                        <hr>
                        <div class="d-grid">
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products.index') }}">Continue shopping</a>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Update quantity with AJAX
    document.querySelectorAll('input[type="number"]').forEach(input => {
        input.addEventListener('change', function() {
            const itemId = this.dataset.itemId;
            const quantity = this.value;
            
            fetch(`/cart/${itemId}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity })
            }).then(() => {
                window.location.reload();
            });
        });
    });
</script>
@endpush 