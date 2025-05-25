<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    public function index()
    {
        $attributes = Attribute::with('categories')->paginate(10);
        return view('admin.attributes.index', compact('attributes'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.attributes.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,select',
            'is_required' => 'boolean',
            'categories' => 'array',
            'options' => 'required_if:type,select|array'
        ]);

        $attribute = Attribute::create([
            'name' => $request->name,
            'type' => $request->type,
            'is_required' => $request->boolean('is_required'),
            'is_active' => true,
            'options' => $request->type === 'select' ? $request->options : null
        ]);

        if ($request->has('categories')) {
            $attribute->categories()->attach($request->categories);
        }

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully');
    }

    public function edit(Attribute $attribute)
    {
        $categories = Category::all();
        return view('admin.attributes.edit', compact('attribute', 'categories'));
    }

    public function update(Request $request, Attribute $attribute)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:text,number,select',
            'is_required' => 'boolean',
            'categories' => 'array',
            'options' => 'required_if:type,select|array'
        ]);

        $attribute->update([
            'name' => $request->name,
            'type' => $request->type,
            'is_required' => $request->boolean('is_required'),
            'options' => $request->type === 'select' ? $request->options : null
        ]);

        if ($request->has('categories')) {
            $attribute->categories()->sync($request->categories);
        }

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully');
    }

    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully');
    }
}