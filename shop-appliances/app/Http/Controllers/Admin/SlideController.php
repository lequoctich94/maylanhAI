<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('order')->paginate(10);
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.slides.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $path = $image->store('slides', 'public');
        }

        Slide::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $path ?? null,
            'order' => $request->order,
            'is_active' => $request->is_active,
            'url' => $request->url,
        ]);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide đã được tạo thành công.');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'order' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
            'url' => 'nullable|url|max:255',
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            // Lưu ảnh mới
            $image = $request->file('image');
            $path = $image->store('slides', 'public');
            $slide->image = $path;
        }

        $slide->update([
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order,
            'is_active' => $request->is_active,
            'url' => $request->url,
        ]);

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide đã được cập nhật thành công.');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
        
        $slide->delete();

        return redirect()->route('admin.slides.index')
            ->with('success', 'Slide đã được xóa thành công.');
    }
} 