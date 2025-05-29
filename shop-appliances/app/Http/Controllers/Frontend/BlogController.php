<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['category', 'author'])
            ->published()
            ->latest('published_at');
        
        // Tìm kiếm
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lọc theo thời gian
        if ($request->filled('time')) {
            switch ($request->time) {
                case 'week':
                    $query->where('published_at', '>=', now()->subWeek());
                    break;
                case 'month':
                    $query->where('published_at', '>=', now()->subMonth());
                    break;
                case 'year':
                    $query->where('published_at', '>=', now()->subYear());
                    break;
            }
        }

        $posts = $query->paginate(9)->withQueryString();

        $categories = PostCategory::withCount('posts')->get();
        
        // Thêm dữ liệu cho widgets
        $latestPosts = Post::published()
            ->latest('published_at')
            ->take(5)
            ->get();
        
        $popularPosts = Post::published()
            ->orderBy('view_count', 'desc')
            ->take(5)
            ->get();

        return view('frontend.blog.index', compact(
            'posts', 
            'categories', 
            'latestPosts', 
            'popularPosts'
        ));
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published' || $post->published_at > now()) {
            abort(404, 'Bài viết không tồn tại hoặc chưa được xuất bản');
        }

        $post->load(['category', 'author']);
        $post->incrementViewCount();

        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        // Lấy danh sách post categories với số lượng bài viết
        $categories = PostCategory::withCount('posts')
        ->orderBy('name')
        ->get();

        return view('frontend.blog.show', compact('post', 'relatedPosts', 'categories'));
    }

    public function category(PostCategory $category)
    {
        $posts = Post::with(['author'])
            ->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.blog.category', compact('category', 'posts'));
    }
}