<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'status',
        'shipping_address',
        'shipping_phone',
        'payment_method'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        // Tự động tạo order_number trước khi lưu
        static::creating(function ($order) {
            $order->order_number = static::generateOrderNumber();
        });
    }

    // Tạo mã đơn hàng theo định dạng: ORD-YYYYMMDD-XXX
    public static function generateOrderNumber()
    {
        $date = Carbon::now()->format('Ymd');
        $lastOrder = static::whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

        $sequence = $lastOrder ? (intval(substr($lastOrder->order_number, -3)) + 1) : 1;
        return sprintf("ORD-%s-%03d", $date, $sequence);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
} 