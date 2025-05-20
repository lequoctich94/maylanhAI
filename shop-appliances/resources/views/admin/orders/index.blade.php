@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Orders</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->total_amount }} đ</td>
                                <td>
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info">Processing</span>
                                            @break
                                        @case('completed')
                                            <span class="badge bg-success">Completed</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order) }}" 
                                       class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No orders found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection 