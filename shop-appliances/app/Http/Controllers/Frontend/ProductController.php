<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Attribute;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::active()->withCount('products')->get();
        $totalProducts = Product::active()->count();
        
        $products = Product::active()
            ->with(['category', 'attributes.attribute'])
            ->when(request('search'), function($query) {
                $query->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('min_price'), function($query) {
                $query->where(function($q) {
                    $q->where('discount_price', '>=', request('min_price'))
                      ->orWhere(function($subQuery) {
                          $subQuery->whereNull('discount_price')
                                   ->where('price', '>=', request('min_price'));
                      });
                });
            })
            ->when(request('max_price'), function($query) {
                $query->where(function($q) {
                    $q->where('discount_price', '<=', request('max_price'))
                      ->orWhere(function($subQuery) {
                          $subQuery->whereNull('discount_price')
                                   ->where('price', '<=', request('max_price'));
                      });
                });
            })
            ->when(request('sort'), function($query) {
                switch(request('sort')) {
                    case 'price_asc':
                        $query->orderByRaw('COALESCE(discount_price, price) ASC');
                        break;
                    case 'price_desc':
                        $query->orderByRaw('COALESCE(discount_price, price) DESC');
                        break;
                    case 'newest':
                        $query->latest();
                        break;
                    case 'name_asc':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'name_desc':
                        $query->orderBy('name', 'desc');
                        break;
                    default:
                        $query->latest();
                }
            })
            ->paginate(12);

        return view('frontend.products.index', compact('categories', 'products', 'totalProducts'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        // Load attributes và images của sản phẩm
        $product->load(['attributes.attribute', 'images']);
        
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
                $query->where('name', 'like', '%' . request('search') . '%')
                      ->orWhere('description', 'like', '%' . request('search') . '%');
            })
            ->when(request('attributes'), function($query) {
                foreach(request('attributes') as $attributeId => $value) {
                    if ($value) {
                        $query->whereHas('attributes', function($q) use ($attributeId, $value) {
                            $q->where('attribute_id', $attributeId);
                            
                            // For checkbox attributes, check for exact match (1 or 0)
                            $attribute = Attribute::find($attributeId);
                            if ($attribute && $attribute->type === 'checkbox') {
                                $q->where('value', $value);
                            } else {
                                // For other types, use LIKE search
                                $q->where('value', 'like', '%' . $value . '%');
                            }
                        });
                    }
                }
            })
            ->paginate(12);

        return view('frontend.products.category', compact('category', 'products', 'categories'));
    }
} 