@extends('layouts.frontend')

@section('title', 'Đặt hàng thành công')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-success">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="card-title mb-4">Đặt hàng thành công!</h2>
                    <p class="card-text">Cảm ơn bạn đã mua hàng tại cửa hàng chúng tôi.</p>
                    
                    <div class="alert alert-success">
                        <h5>Thông tin đơn hàng:</h5>
                        <p class="mb-1">Mã đơn hàng: <strong>{{ $order->order_number }}</strong></p>
                        <p class="mb-1">Tổng tiền: <strong>{{ number_format($order->total_amount) }} đ</strong></p>
                        <p class="mb-1">Phương thức thanh toán: 
                            <strong>
                                @if($order->payment_method == 'cod')
                                    Thanh toán khi nhận hàng
                                @else
                                    Chuyển khoản ngân hàng
                                @endif
                            </strong>
                        </p>
                    </div>

                    <div class="alert alert-info">
                        <p class="mb-1"><i class="fas fa-info-circle"></i> Chúng tôi sẽ sớm liên hệ với bạn để xác nhận đơn hàng.</p>
                        @if($order->payment_method == 'bank_transfer')
                            <p class="mb-1"><i class="fas fa-university"></i> Vui lòng chuyển khoản trong vòng 24h để đơn hàng được xử lý.</p>
                        @endif
                    </div>

                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="fas fa-home"></i> Về trang chủ
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-shopping-cart"></i> Tiếp tục mua sắm
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 