<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::latest()->paginate(10);
        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:news',
            'content' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->storeAs('public/news', $imageName);

        News::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $imageName,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News created successfully');
    }

    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|unique:news,title,' . $news->id,
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            Storage::delete('public/news/' . $news->image);
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->storeAs('public/news', $imageName);
        }

        $news->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title),
            'content' => $request->content,
            'image' => $request->hasFile('image') ? $imageName : $news->image,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.news.index')
                        ->with('success', 'News updated successfully');
    }

    public function destroy(News $news)
    {
        Storage::delete('public/news/' . $news->image);
        $news->delete();
        
        return redirect()->route('admin.news.index')
                        ->with('success', 'News deleted successfully');
    }
} 