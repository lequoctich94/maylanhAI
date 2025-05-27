@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order #{{ $order->id }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Orders
        </a>
    </div>

    <div class="row">
        <!-- Order Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Order ID:</td>
                            <td>#{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td>Date:</td>
                            <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Status:</td>
                            <td>
                                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" class="form-select" onchange="this.form.submit()">
                                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>
                                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>
                                            Processing
                                        </option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                            Completed
                                        </option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                            Cancelled
                                        </option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>Payment Method:</td>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Customer Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless mb-0">
                        <tr>
                            <td>Name:</td>
                            <td>{{ $order->user ? $order->user->name : $order->name  }}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{ $order->user ? $order->user->email : '' }}</td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td>{{ $order->shipping_phone }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Shipping Information</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Order Items</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             width="50" 
                                             class="me-3">
                                        {{ $item->product->name }}
                                    </div>
                                </td>
                                <td>${{ $item->price }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td class="text-end">${{ $item->price * $item->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Subtotal:</strong></td>
                            <td class="text-end">${{ $order->total }}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Shipping:</strong></td>
                            <td class="text-end">Free</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total:</strong></td>
                            <td class="text-end"><strong>${{ $order->total }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection 