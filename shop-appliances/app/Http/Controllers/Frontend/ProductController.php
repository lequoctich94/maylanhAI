<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::active()->withCount('products')->get();
        $products = Product::active()
            ->with('category')
            ->when(request('sort'), function($query) {
                switch(request('sort')) {
                    case 'price_asc':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_desc':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'newest':
                        $query->latest();
                        break;
                }
            })
            ->paginate(12);

        return view('frontend.products.index', compact('categories', 'products'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return view('frontend.products.show', compact('product'));
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $categories = Category::active()->withCount('products')->get();
        $products = $category->products()
            ->active()
            ->paginate(12);

        return view('frontend.products.category', compact('category', 'products', 'categories'));
    }
} 