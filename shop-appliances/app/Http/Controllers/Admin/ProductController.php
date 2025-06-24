<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'images' => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'attributes' => 'array',
            'attributes.*' => 'nullable'
        ]);
        // Lấy ảnh đầu tiên làm ảnh chính của sản phẩm
        $mainImage = null;
        if ($request->hasFile('images') && count($request->file('images')) > 0) {
            $mainImage = $request->file('images')[0]->store('products', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'image' => $mainImage, // Vẫn giữ một ảnh chính trong bảng product
            'is_active' => $request->boolean('is_active', true),
        ]);
        
        // Lưu tất cả các ảnh vào bảng product_images
        if ($request->hasFile('images')) {
            $sortOrder = 0;
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $imagePath,
                    'sort_order' => $sortOrder++
                ]);
            }
        }
       
        // Save attributes
        if (isset($request->all()['attributes'])) {
            foreach ($request->all()['attributes'] as $attributeId => $value) {
                $product->attributes()->create([
                    'attribute_id' => $attributeId,
                    'value' => $value
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully');
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:products,name,'.$product->id,
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'stock' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'numeric|exists:product_images,id',
            'attributes' => 'array',
            'attributes.*' => 'nullable'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'is_active' => $request->boolean('is_active', true)
        ];

        // Xóa các ảnh đã chọn để xóa
        if ($request->has('remove_images') && is_array($request->remove_images)) {
            foreach($request->remove_images as $imageId) {
                $imageToDelete = $product->images()->find($imageId);
                if ($imageToDelete) {
                    // Xóa file từ storage
                    Storage::delete('public/' . $imageToDelete->image_path);
                    // Xóa record từ database
                    $imageToDelete->delete();
                }
            }
        }
        
        // Thêm ảnh mới
        if ($request->hasFile('images')) {
            $sortOrder = $product->images()->max('sort_order') + 1 ?? 0;
            
            // Nếu không có ảnh chính (trường hợp đã xóa hết ảnh) và có ảnh mới, lấy ảnh đầu làm ảnh chính
            $mainImageUpdated = false;
            if (!$product->image && count($request->file('images')) > 0) {
                $mainImage = $request->file('images')[0]->store('products', 'public');
                $data['image'] = $mainImage;
                $mainImageUpdated = true;
            }
            
            foreach ($request->file('images') as $index => $image) {
                // Nếu là ảnh đầu tiên và đã cập nhật ảnh chính thì bỏ qua để tránh lưu trùng
                if ($index === 0 && $mainImageUpdated) {
                    continue;
                }
                
                $imagePath = $image->store('products', 'public');
                $product->images()->create([
                    'image_path' => $imagePath,
                    'sort_order' => $sortOrder++
                ]);
            }
        }

        $product->update($data);

        // Update attributes
        if (isset($request->all()['attributes'])) {
            // Delete old attributes
            $product->attributes()->delete();
            
            // Create new attributes
            foreach ($request->all()['attributes'] as $attributeId => $value) {
                $product->attributes()->create([
                    'attribute_id' => $attributeId,
                    'value' => $value
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Xóa ảnh chính
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        // Xóa tất cả ảnh liên quan trong bảng product_images
        foreach ($product->images as $image) {
            Storage::delete('public/' . $image->image_path);
        }
        
        // Xóa sản phẩm (các bản ghi trong bảng product_images sẽ bị xóa do cấu hình onDelete('cascade'))
        $product->delete();

        return back()->with('success', 'Sản phẩm đã được xóa thành công.');
    }
} 