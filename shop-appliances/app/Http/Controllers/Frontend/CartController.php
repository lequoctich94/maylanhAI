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
        $cartItems = session('cart', []);
        $products = [];
        $total = 0;
        
        if (!empty($cartItems)) {
            $products = Product::whereIn('id', array_keys($cartItems))->get();
            foreach ($products as $product) {
                $product->quantity = $cartItems[$product->id];
                $total += $product->price * $product->quantity;
            }
        }

        return view('frontend.cart.index', compact('products', 'total'));
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

        $cart = session('cart', []);
        $cart[$product->id] = $request->quantity;
        session(['cart' => $cart]);

        return back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = session('cart', []);
        
        if (isset($cart[$productId])) {
            $cart[$productId] = $request->quantity;
            session(['cart' => $cart]);
        }

        return response()->json(['message' => 'Cart updated successfully']);
    }

    public function remove($productId)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Product removed from cart successfully.');
    }
} 