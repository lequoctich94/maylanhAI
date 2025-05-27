<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cartItems))->get();
        $total = 0;
        
        foreach ($products as $product) {
            $product->quantity = $cartItems[$product->id];
            $total += $product->price * $product->quantity;
        }

        // Get user info if logged in
        $user = auth()->user();
        $userData = $user ? [
            'name' => $user->name,
            'phone' => $user->phone
        ] : null;

        return view('frontend.checkout.index', compact('products', 'total', 'userData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'payment_method' => 'required|in:cod,bank_transfer',
        ]);

        $cartItems = session('cart', []);
        if (empty($cartItems)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $products = Product::whereIn('id', array_keys($cartItems))->get();
        $total = 0;
        $orderItems = [];

        foreach ($products as $product) {
            $quantity = $cartItems[$product->id];
            $subtotal = $product->price * $quantity;
            $total += $subtotal;
            
            $orderItems[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'subtotal' => $subtotal
            ];
        }

        try {
            DB::beginTransaction();

            $order = Order::create([
                'name' => $request->name,
                'shipping_phone' => $request->phone,
                'shipping_address' => $request->address,
                'payment_method' => $request->payment_method,
                'total_amount' => $total,
                'status' => 'pending',
                'user_id' => auth()->id()
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);
            }

            DB::commit();

            // Clear the cart
            session()->forget('cart');

            return redirect()->route('checkout.success', $order);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());
            return back()->with('error', 'There was an error processing your order. Please try again.');
        }
    }

    public function success(Order $order)
    {
        return view('frontend.checkout.success', compact('order'));
    }
} 