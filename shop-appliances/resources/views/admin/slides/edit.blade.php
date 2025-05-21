@extends('layouts.admin')

@section('title', 'Chỉnh sửa Slide')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Chỉnh sửa Slide</h1>
        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.slides.update', $slide) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title', $slide->title) }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Mô tả</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" 
                              name="description" 
                              rows="3">{{ old('description', $slide->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh</label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Kích thước đề xuất: 1920x1080px. Tối đa 2MB</small>
                    
                    @if($slide->image)
                        <div class="mt-2">
                            <label class="form-label">Hình ảnh hiện tại:</label>
                            <div>
                                <img src="{{ Storage::url($slide->image) }}" 
                                     alt="{{ $slide->title }}" 
                                     class="img-thumbnail" 
                                     style="max-height: 200px;">
                            </div>
                        </div>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="url" class="form-label">Đường dẫn liên kết (không bắt buộc)</label>
                    <input type="url" 
                           class="form-control @error('url') is-invalid @enderror" 
                           id="url" 
                           name="url" 
                           value="{{ old('url', $slide->url) }}"
                           placeholder="https://example.com">
                    @error('url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Nhập URL đầy đủ nếu muốn liên kết slide đến một trang web</small>
                </div>

                <div class="mb-3">
                    <label for="order" class="form-label">Thứ tự <span class="text-danger">*</span></label>
                    <input type="number" 
                           class="form-control @error('order') is-invalid @enderror" 
                           id="order" 
                           name="order" 
                           value="{{ old('order', $slide->order) }}" 
                           min="1" 
                           required>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status">
                        <option value="1" {{ old('status', $slide->status) == 1 ? 'selected' : '' }}>Hiện</option>
                        <option value="0" {{ old('status', $slide->status) == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-label {
        font-weight: 500;
    }
</style>
@endpush 