@extends('layouts.admin')

@section('title', 'Add Product')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Product</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category</label>
                    <select class="form-select @error('category_id') is-invalid @enderror" 
                            id="category_id" name="category_id" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="category-attributes">
                    <!-- Dynamic attributes will be loaded here -->
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" 
                                   id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount_price" class="form-label">Discount Price</label>
                            <input type="number" step="0.01" class="form-control @error('discount_price') is-invalid @enderror" 
                                   id="discount_price" name="discount_price" value="{{ old('discount_price') }}">
                            <small class="text-muted">Leave empty if no discount</small>
                            @error('discount_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" 
                                   id="stock" name="stock" value="{{ old('stock', 0) }}" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Hình ảnh sản phẩm (có thể chọn nhiều hình)</label>
                    <input type="file" class="form-control @error('images') is-invalid @enderror" 
                           id="images" name="images[]" accept="image/*" multiple required>
                    <small class="text-muted">Có thể chọn nhiều ảnh cùng lúc. Ảnh đầu tiên sẽ là ảnh chính của sản phẩm.</small>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" 
                               name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save Product</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('category_id').addEventListener('change', function() {
    const categoryId = this.value;
    if (categoryId) {
        fetch(`/admin/categories/${categoryId}/attributes`)
            .then(response => response.json())
            .then(attributes => {
                const container = document.getElementById('category-attributes');
                container.innerHTML = '';
                
                attributes.forEach(attr => {
                    const div = document.createElement('div');
                    div.className = 'mb-3';
                    
                    let inputHtml = '';
                    if (attr.type === 'select') {
                        // Create select element for select type
                        inputHtml = `
                            <select class="form-control @error('attributes.${attr.id}') is-invalid @enderror"
                                    id="attr_${attr.id}" 
                                    name="attributes[${attr.id}]"
                                    ${attr.is_required ? 'required' : ''}>
                                <option value="">Select ${attr.name}</option>
                                ${attr.options.map(option => `
                                    <option value="${option}">${option}</option>
                                `).join('')}
                            </select>
                        `;
                    } else if (attr.type === 'checkbox') {
                        // Create checkbox for checkbox type
                        inputHtml = `
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input @error('attributes.${attr.id}') is-invalid @enderror"
                                       id="attr_${attr.id}" 
                                       name="attributes[${attr.id}]"
                                       value="1">
                                <label class="form-check-label" for="attr_${attr.id}">
                                    ${attr.name}
                                </label>
                            </div>
                        `;
                    } else {
                        // Create regular input for other types
                        inputHtml = `
                            <input type="${attr.type}" 
                                   class="form-control @error('attributes.${attr.id}') is-invalid @enderror"
                                   id="attr_${attr.id}" 
                                   name="attributes[${attr.id}]"
                                   ${attr.is_required ? 'required' : ''}>
                        `;
                    }

                    div.innerHTML = `
                        ${attr.type === 'checkbox' ? '' : `<label for="attr_${attr.id}" class="form-label">${attr.name}</label>`}
                        ${inputHtml}
                        @error('attributes.${attr.id}')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    `;
                    container.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    } else {
        // Clear attributes container if no category is selected
        document.getElementById('category-attributes').innerHTML = '';
    }
});

// Trigger change event if category is pre-selected (for edit form)
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    if (categorySelect.value) {
        categorySelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush 