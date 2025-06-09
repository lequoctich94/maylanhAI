<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slide;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Detect mobile device
        $isMobile = $this->isMobileDevice($request);
        
        // Lấy slides phù hợp với device type
        if ($isMobile) {
            // Nếu là mobile, ưu tiên slider mobile, nếu không có thì lấy desktop
            $slides = Slide::active()->mobile()->orderBy('order')->get();
            if ($slides->isEmpty()) {
                $slides = Slide::active()->desktop()->orderBy('order')->get();
            }
        } else {
            // Nếu là desktop, chỉ lấy slider desktop
            $slides = Slide::active()->desktop()->orderBy('order')->get();
        }
        
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
        
        return view('frontend.home', compact('slides', 'categories', 'products', 'posts', 'isMobile'));
    }
    
    /**
     * Detect if the request is from a mobile device
     */
    private function isMobileDevice(Request $request)
    {
        $userAgent = $request->header('User-Agent');
        
        $mobileKeywords = [
            'Mobile', 'Android', 'iPhone', 'iPad', 'iPod', 'BlackBerry', 
            'Windows Phone', 'Opera Mini', 'IEMobile', 'Mobile Safari'
        ];
        
        foreach ($mobileKeywords as $keyword) {
            if (stripos($userAgent, $keyword) !== false) {
                return true;
            }
        }
        
        // Alternative: Check screen width via JavaScript (requires frontend implementation)
        // For now, we'll also check for common mobile screen widths in viewport
        return false;
    }
} 