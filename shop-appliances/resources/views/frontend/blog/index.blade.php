@extends('layouts.frontend')

@section('styles')
<link href="{{ asset('css/blog.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container py-5">
    <!-- Form tìm kiếm và lọc -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('blog.index') }}" method="GET" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" 
                                   name="search" 
                                   class="form-control" 
                                   placeholder="Tìm kiếm bài viết..."
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="category" class="form-select">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select name="time" class="form-select">
                                <option value="">Tất cả thời gian</option>
                                <option value="week" {{ request('time') == 'week' ? 'selected' : '' }}>
                                    Tuần này
                                </option>
                                <option value="month" {{ request('time') == 'month' ? 'selected' : '' }}>
                                    Tháng này
                                </option>
                                <option value="year" {{ request('time') == 'year' ? 'selected' : '' }}>
                                    Năm nay
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar với danh mục -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('blog.category', $category->slug) }}" class="text-decoration-none">
                                    {{ $category->name }}
                                    <span class="badge bg-secondary float-end">{{ $category->posts_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Widget bài viết mới nhất -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Bài viết mới nhất</h5>
                </div>
                <div class="card-body">
                    @foreach($latestPosts as $latestPost)
                        <div class="d-flex mb-3">
                            @if($latestPost->featured_image)
                                <img src="{{ Storage::url($latestPost->featured_image) }}" 
                                     class="rounded" 
                                     alt="{{ $latestPost->title }}"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @endif
                            <div class="ms-3">
                                <h6 class="mb-1">
                                    <a href="{{ route('blog.show', $latestPost->slug) }}" 
                                       class="text-decoration-none">
                                        {{ Str::limit($latestPost->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    {{ $latestPost->published_at->format('d/m/Y') }}
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Widget bài viết xem nhiều nhất -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Bài viết xem nhiều nhất</h5>
                </div>
                <div class="card-body">
                    @foreach($popularPosts as $popularPost)
                        <div class="d-flex mb-3">
                            @if($popularPost->featured_image)
                                <img src="{{ Storage::url($popularPost->featured_image) }}" 
                                     class="rounded" 
                                     alt="{{ $popularPost->title }}"
                                     style="width: 80px; height: 60px; object-fit: cover;">
                            @endif
                            <div class="ms-3">
                                <h6 class="mb-1">
                                    <a href="{{ route('blog.show', $popularPost->slug) }}" 
                                       class="text-decoration-none">
                                        {{ Str::limit($popularPost->title, 40) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="fas fa-eye"></i> {{ $popularPost->view_count }} lượt xem
                                </small>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Danh sách bài viết -->
        <div class="col-md-9">
            @if($posts->isEmpty())
                <div class="alert alert-info">
                    Không tìm thấy bài viết nào phù hợp với tiêu chí tìm kiếm.
                </div>
            @else
                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                @if($post->featured_image)
                                    <img src="{{ Storage::url($post->featured_image) }}" 
                                         class="card-img-top" 
                                         alt="{{ $post->title }}"
                                         style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted">
                                        <small>
                                            <i class="fas fa-user"></i> {{ $post->author->name }} |
                                            <i class="fas fa-calendar"></i> {{ $post->published_at->format('d/m/Y') }}
                                        </small>
                                    </p>
                                    <p class="card-text">
                                        {{ Str::limit($post->excerpt ?? strip_tags($post->content), 100) }}
                                    </p>
                                </div>
                                <div class="card-footer bg-white">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">
                                        Đọc tiếp
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 