<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category', 'author'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        $products = Product::all();
        return view('admin.posts.create', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:post_categories,id',
            'product_id' => 'nullable|exists:products,id',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable'
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('posts', 'public');
        }

        Post::create($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được tạo thành công.');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::all();
        $products = Product::all();
        return view('admin.posts.edit', compact('post', 'categories', 'products'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'category_id' => 'required|exists:post_categories,id',
            'product_id' => 'nullable|exists:products,id',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable'
        ]);

        $validated['slug'] = Str::slug($request->title);

        if ($request->hasFile('featured_image')) {
            // Xóa ảnh cũ nếu có
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $validated['featured_image'] = $request->file('featured_image')
                ->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được cập nhật thành công.');
    }

    public function destroy(Post $post)
    {
        if ($post->featured_image) {
            Storage::disk('public')->delete($post->featured_image);
        }
        
        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Bài viết đã được xóa thành công.');
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $path = $file->store('posts/editor', 'public');
            
            return response()->json([
                'uploaded' => true,
                'fileName' => basename($path),
                'url' => Storage::url($path)
            ]);
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'Could not upload the file'
            ]
        ], 400);
    }
} 