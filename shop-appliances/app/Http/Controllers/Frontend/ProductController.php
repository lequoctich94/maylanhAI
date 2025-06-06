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
            ->with(['category', 'attributes.attribute'])
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

        // Load attributes với thông tin attribute
        $product->load(['attributes.attribute']);
        
        return view('frontend.products.show', compact('product'));
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $categories = Category::active()->withCount('products')->get();
        
        // Load attributes của category
        $category->load('attributes');
        
        $products = $category->products()
            ->active()
            ->with(['attributes.attribute'])
            ->when(request('search'), function($query) {
                $query->where('name', 'like', '%' . request('search') . '%');
            })
            ->when(request('attributes'), function($query) {
                foreach(request('attributes') as $attributeId => $value) {
                    if ($value) {
                        $query->whereHas('attributes', function($q) use ($attributeId, $value) {
                            $q->where('attribute_id', $attributeId)
                              ->where('value', 'like', '%' . $value . '%');
                        });
                    }
                }
            })
            ->paginate(12);

        return view('frontend.products.category', compact('category', 'products', 'categories'));
    }
} 