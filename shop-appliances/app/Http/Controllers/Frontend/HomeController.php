<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;

class HomeController extends Controller
{
    public function index()
    {
        $slides = Slide::active()->orderBy('order')->get();
        $categories = Category::active()->take(6)->get();
        $products = Product::active()
            ->with(['category', 'attributes.attribute'])
            ->latest()
            ->take(8)
            ->get();

        return view('frontend.home', compact('slides', 'categories', 'products'));
    }
} 