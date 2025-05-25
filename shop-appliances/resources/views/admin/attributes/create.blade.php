@extends('layouts.admin')

@section('title', 'Add New Attribute')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Attribute</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attributes.store') }}" method="POST">
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
                    <label for="type" class="form-label">Type</label>
                    <select class="form-select @error('type') is-invalid @enderror" 
                            id="type" name="type" required>
                        <option value="">Select Type</option>
                        <option value="text" {{ old('type') == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="number" {{ old('type') == 'number' ? 'selected' : '' }}>Number</option>
                        <option value="select" {{ old('type') == 'select' ? 'selected' : '' }}>Select</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" id="options-container" style="display: none;">
                    <label class="form-label">Select Options</label>
                    <div id="options-list">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="options[]" placeholder="Enter option">
                            <button type="button" class="btn btn-danger remove-option">Remove</button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary" id="add-option">Add Option</button>
                    @error('options')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" 
                               id="is_required" name="is_required" value="1" 
                               {{ old('is_required') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_required">Required</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categories</label>
                    <div class="row">
                        @foreach($categories as $category)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" 
                                           id="category_{{ $category->id }}" 
                                           name="categories[]" 
                                           value="{{ $category->id }}"
                                           {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="mb-3">
                    <button type="submit" class="btn btn-primary">Create Attribute</button>
                    <a href="{{ route('admin.attributes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const optionsContainer = document.getElementById('options-container');
    const optionsList = document.getElementById('options-list');
    const addOptionBtn = document.getElementById('add-option');

    // Show/hide options based on type selection
    typeSelect.addEventListener('change', function() {
        optionsContainer.style.display = this.value === 'select' ? 'block' : 'none';
    });

    // Add new option
    addOptionBtn.addEventListener('click', function() {
        const optionDiv = document.createElement('div');
        optionDiv.className = 'input-group mb-2';
        optionDiv.innerHTML = `
            <input type="text" class="form-control" name="options[]" placeholder="Enter option">
            <button type="button" class="btn btn-danger remove-option">Remove</button>
        `;
        optionsList.appendChild(optionDiv);
    });

    // Remove option
    optionsList.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-option')) {
            e.target.parentElement.remove();
        }
    });

    // Show options container if type is select on page load
    if (typeSelect.value === 'select') {
        optionsContainer.style.display = 'block';
    }
});
</script>
@endpush
@endsection