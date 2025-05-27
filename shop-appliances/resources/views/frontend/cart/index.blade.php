@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Shopping Cart</h2>

    @if(count($products) > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                        class="img-thumbnail" style="width: 80px; margin-right: 15px;">
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $product->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td>
                            <div class="input-group" style="width: 120px;">
                                <button class="btn btn-outline-secondary decrease-quantity" type="button" 
                                    data-product-id="{{ $product->id }}">-</button>
                                <input type="number" class="form-control text-center quantity-input" 
                                    value="{{ $product->quantity }}" min="1" 
                                    data-product-id="{{ $product->id }}">
                                <button class="btn btn-outline-secondary increase-quantity" type="button" 
                                    data-product-id="{{ $product->id }}">+</button>
                            </div>
                        </td>
                        <td>${{ number_format($product->price * $product->quantity, 2) }}</td>
                        <td>
                            <form action="{{ route('cart.remove', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Continue Shopping</a>
            <a href="{{ route('checkout.index') }}" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    @else
        <div class="text-center py-5">
            <h4>Your cart is empty</h4>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
        </div>
    @endif
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Update quantity
    function updateQuantity(productId, quantity) {
        fetch(`/cart/update/${productId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: quantity })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                window.location.reload();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Decrease quantity
    document.querySelectorAll('.decrease-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
            const currentValue = parseInt(input.value);
            if (currentValue > 1) {
                input.value = currentValue - 1;
                updateQuantity(productId, currentValue - 1);
            }
        });
    });

    // Increase quantity
    document.querySelectorAll('.increase-quantity').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const input = document.querySelector(`.quantity-input[data-product-id="${productId}"]`);
            const currentValue = parseInt(input.value);
            input.value = currentValue + 1;
            updateQuantity(productId, currentValue + 1);
        });
    });

    // Input change
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            const productId = this.dataset.productId;
            const quantity = parseInt(this.value);
            if (quantity > 0) {
                updateQuantity(productId, quantity);
            } else {
                this.value = 1;
                updateQuantity(productId, 1);
            }
        });
    });
});
</script>
@endpush
@endsection 