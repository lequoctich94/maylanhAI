@extends('layouts.admin')

@section('title', 'Thêm Slide Mới')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Thêm Slide Mới</h1>
        <a href="{{ route('admin.slides.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Quay lại
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.slides.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="title" class="form-label">Tiêu đề <span class="text-danger">*</span></label>
                    <input type="text" 
                           class="form-control @error('title') is-invalid @enderror" 
                           id="title" 
                           name="title" 
                           value="{{ old('title') }}" 
                           required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="subtitle" class="form-label">Mô tả</label>
                    <textarea class="form-control @error('subtitle') is-invalid @enderror" 
                              id="subtitle" 
                              name="subtitle" 
                              rows="3">{{ old('subtitle') }}</textarea>
                    @error('subtitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check mb-3">
                        <input class="form-check-input @error('is_mobile') is-invalid @enderror" 
                               type="checkbox" 
                               id="is_mobile" 
                               name="is_mobile" 
                               value="1" 
                               {{ old('is_mobile') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_mobile">
                            <strong>Slider dành cho Mobile</strong>
                        </label>
                        @error('is_mobile')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Hình ảnh <span class="text-danger">*</span></label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*" 
                           required>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="mt-2">
                        <div class="alert alert-info" id="desktop-size-info">
                            <strong>Kích thước đề xuất cho Desktop:</strong> 1920x1080px (tỉ lệ 16:9). Tối đa 2MB
                        </div>
                        <div class="alert alert-warning" id="mobile-size-info" style="display: none;">
                            <strong>Kích thước đề xuất cho Mobile:</strong> 390x293px (tỉ lệ 4:3) hoặc 390x220px (tỉ lệ 16:9). Tối đa 2MB
                            <br><small class="text-muted">Lưu ý: Hình ảnh mobile nên có tỉ lệ 4:3 để hiển thị tốt trên màn hình điện thoại</small>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="link" class="form-label">Đường dẫn liên kết (không bắt buộc)</label>
                    <input type="url" 
                           class="form-control @error('link') is-invalid @enderror" 
                           id="link" 
                           name="link" 
                           value="{{ old('link') }}"
                           placeholder="https://example.com">
                    @error('link')
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
                           value="{{ old('order', 1) }}" 
                           min="1" 
                           required>
                    @error('order')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="is_active" class="form-label">Trạng thái</label>
                    <select class="form-select @error('is_active') is-invalid @enderror" 
                            id="is_active" 
                            name="is_active">
                        <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Hiện</option>
                        <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Ẩn</option>
                    </select>
                    @error('is_active')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Lưu
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileCheckbox = document.getElementById('is_mobile');
    const desktopSizeInfo = document.getElementById('desktop-size-info');
    const mobileSizeInfo = document.getElementById('mobile-size-info');
    
    function toggleSizeInfo() {
        if (mobileCheckbox.checked) {
            desktopSizeInfo.style.display = 'none';
            mobileSizeInfo.style.display = 'block';
        } else {
            desktopSizeInfo.style.display = 'block';
            mobileSizeInfo.style.display = 'none';
        }
    }
    
    mobileCheckbox.addEventListener('change', toggleSizeInfo);
    
    // Initialize
    toggleSizeInfo();
});
</script>
@endpush 