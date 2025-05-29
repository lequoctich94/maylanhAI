<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::withCount('posts')
            ->orderBy('name')
            ->paginate(10);

        return view('admin.post-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.post-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:post_categories',
            'description' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        PostCategory::create($validated);

        return redirect()
            ->route('admin.post-categories.index')
            ->with('success', 'Danh mục đã được tạo thành công.');
    }

    public function edit(PostCategory $postCategory)
    {
        return view('admin.post-categories.edit', compact('postCategory'));
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:post_categories,name,' . $postCategory->id,
            'description' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $postCategory->update($validated);

        return redirect()
            ->route('admin.post-categories.index')
            ->with('success', 'Danh mục đã được cập nhật thành công.');
    }

    public function destroy(PostCategory $postCategory)
    {
        if($postCategory->posts()->count() > 0) {
            return back()->with('error', 'Không thể xóa danh mục này vì nó đang chứa bài viết.');
        }

        $postCategory->delete();

        return redirect()
            ->route('admin.post-categories.index')
            ->with('success', 'Danh mục đã được xóa thành công.');
    }
} 