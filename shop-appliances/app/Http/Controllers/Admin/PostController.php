<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:posts',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('public/posts', $imageName);

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imageName,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post created successfully');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|unique:posts,title,' . $post->id,
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/posts/' . $post->image);
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/posts', $imageName);
        }

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $request->hasFile('image') ? $imageName : $post->image,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post updated successfully');
    }

    public function destroy(Post $post)
    {
        Storage::delete('public/posts/' . $post->image);
        $post->delete();
        
        return redirect()->route('admin.posts.index')
                        ->with('success', 'Post deleted successfully');
    }
} 