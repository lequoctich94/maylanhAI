<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = auth()->user()->carts()
            ->with('product')
            ->get();

        return view('frontend.cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Product::findOrFail($request->product_id);
        
        if (!$product->is_active) {
            return back()->with('error', 'Product is not available.');
        }

        $cart = Cart::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'product_id' => $product->id
            ],
            [
                'quantity' => $request->quantity
            ]
        );

        return back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->update([
            'quantity' => $request->quantity
        ]);

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function remove(Cart $cart)
    {
        if ($cart->user_id !== auth()->id()) {
            abort(403);
        }

        $cart->delete();

        return back()->with('success', 'Product removed from cart successfully.');
    }
} 