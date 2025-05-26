<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;

class SearchController extends Controller
{
    public function search()
    {
        $query = request('q');
        $categories = Category::active()->withCount('products')->get();
        
        $products = Product::active()
            ->with('category')
            ->when($query, function($q) use ($query) {
                $q->where(function($q) use ($query) {
                    $q->where('name', 'like', '%' . $query . '%')
                      ->orWhere('description', 'like', '%' . $query . '%');
                });
            })
            ->paginate(12);

        return view('frontend.products.search', compact('products', 'categories', 'query'));
    }
} 