@extends('layouts.frontend')

@section('title', 'Checkout')

@section('content')
    <h1 class="mb-4">Checkout</h1>

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        
                        <!-- Shipping Information -->
                        <h5 class="card-title mb-4">Shipping Information</h5>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Shipping Address</label>
                            <textarea name="shipping_address" 
                                      id="shipping_address" 
                                      class="form-control @error('shipping_address') is-invalid @enderror" 
                                      rows="3" 
                                      required>{{ old('shipping_address') }}</textarea>
                            @error('shipping_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="shipping_phone" class="form-label">Phone Number</label>
                            <input type="text" 
                                   name="shipping_phone" 
                                   id="shipping_phone" 
                                   class="form-control @error('shipping_phone') is-invalid @enderror" 
                                   value="{{ old('shipping_phone') }}" 
                                   required>
                            @error('shipping_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Payment Method -->
                        <h5 class="card-title mb-4">Payment Method</h5>
                        <div class="mb-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="payment_method" 
                                       id="cod" 
                                       value="cod" 
                                       checked>
                                <label class="form-check-label" for="cod">
                                    Cash on Delivery (COD)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="radio" 
                                       name="payment_method" 
                                       id="bank_transfer" 
                                       value="bank_transfer">
                                <label class="form-check-label" for="bank_transfer">
                                    Bank Transfer
                                </label>
                            </div>
                            @error('payment_method')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Place Order
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Order Summary</h5>
                    
                    @foreach($cartItems as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h6 class="mb-0">{{ $item->product->name }}</h6>
                                <small class="text-muted">
                                    Quantity: {{ $item->quantity }}
                                </small>
                            </div>
                            <span>
                                ${{ ($item->product->discount_price ?? $item->product->price) * $item->quantity }}
                            </span>
                        </div>
                    @endforeach

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Subtotal:</span>
                        <span>${{ $cartItems->sum(function($item) {
                            return ($item->product->discount_price ?? $item->product->price) * $item->quantity;
                        }) }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                        <span>Shipping:</span>
                        <span>Free</span>
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong>${{ $cartItems->sum(function($item) {
                            return ($item->product->discount_price ?? $item->product->price) * $item->quantity;
                        }) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 