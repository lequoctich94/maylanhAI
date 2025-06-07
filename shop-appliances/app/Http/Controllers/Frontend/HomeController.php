<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::active()->orderBy('order')->get();
        $categories = Category::active()->withCount('products')->take(6)->get();
        $products = Product::active()
            ->with(['category', 'attributes.attribute'])
            ->latest()
            ->take(8)
            ->get();
        
        // Lấy các bài viết hiển thị trên trang chủ
        $posts = Post::showOnHomepage()
            ->with(['category', 'author'])
            ->latest()
            ->take(6)
            ->get();
        
        return view('frontend.home', compact('slides', 'categories', 'products', 'posts'));
    }
} 