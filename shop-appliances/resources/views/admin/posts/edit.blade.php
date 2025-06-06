@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chỉnh sửa bài viết</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="title">Tiêu đề</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                id="title" name="title" value="{{ old('title', $post->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="category_id">Danh mục</label>
                            <select class="form-control @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                                <option value="">Chọn danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="product_id">Sản phẩm liên quan</label>
                            <select class="form-control @error('product_id') is-invalid @enderror" 
                                id="product_id" name="product_id">
                                <option value="">Chọn sản phẩm</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" 
                                        {{ old('product_id', $post->product_id) == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('product_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="excerpt">Tóm tắt</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                            @error('excerpt')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="content">Nội dung</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                id="content" name="content" rows="10">{{ old('content', $post->content) }}</textarea>
                            @error('content')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="featured_image">Ảnh đại diện</label>
                            @if($post->featured_image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($post->featured_image) }}" 
                                        alt="Featured Image" class="img-thumbnail" style="max-height: 200px">
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('featured_image') is-invalid @enderror" 
                                id="featured_image" name="featured_image">
                            @error('featured_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="status">Trạng thái</label>
                            <select class="form-control @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Xuất bản</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="published_at">Ngày xuất bản</label>
                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" 
                                id="published_at" name="published_at" 
                                value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}">
                            @error('published_at')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control @error('meta_title') is-invalid @enderror" 
                                id="meta_title" name="meta_title" value="{{ old('meta_title', $post->meta_title) }}">
                            @error('meta_title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" 
                                id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $post->meta_description) }}</textarea>
                            @error('meta_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Cập nhật bài viết</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Hủy</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'), {
            ckfinder: {
                uploadUrl: '{{ route('admin.posts.upload-image') }}',
                headers: {
                    'cuc cut': 'cuc cut',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush 