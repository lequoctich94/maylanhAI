@extends('layouts.frontend')

@section('meta')
    <title>{{ $post->meta_title ?? $post->title }}</title>
    <meta name="description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}">
    <meta property="og:title" content="{{ $post->meta_title ?? $post->title }}">
    <meta property="og:description" content="{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}">
    @if($post->featured_image)
        <meta property="og:image" content="{{ Storage::url($post->featured_image) }}">
    @endif
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <!-- Bài viết chính -->
            <article class="blog-post">
                <h1 class="mb-4">{{ $post->title }}</h1>
                
                <div class="mb-4 text-muted">
                    <small>
                        <i class="fas fa-user"></i> {{ $post->author->name }} |
                        <i class="fas fa-calendar"></i> {{ $post->published_at->format('d/m/Y') }} |
                        <i class="fas fa-eye"></i> {{ $post->view_count }} lượt xem
                    </small>
                </div>

                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" 
                         class="img-fluid rounded mb-4" 
                         alt="{{ $post->title }}">
                @endif

                <div class="blog-content">
                    {!! $post->content !!}
                </div>

                @if($post->product)
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Sản phẩm liên quan</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{ Storage::url($post->product->image) }}" 
                                         class="img-fluid rounded" 
                                         alt="{{ $post->product->name }}">
                                </div>
                                <div class="col-md-8">
                                    <h6>{{ $post->product->name }}</h6>
                                    <p class="text-muted">{{ Str::limit($post->product->description, 150) }}</p>
                                    <a href="{{ route('products.show', $post->product->slug) }}" 
                                       class="btn btn-primary">
                                        Xem sản phẩm
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Chia sẻ mạng xã hội -->
                <div class="mt-4">
                    <h5>Chia sẻ bài viết</h5>
                    <div class="social-share">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                           target="_blank" 
                           class="btn btn-facebook">
                            <i class="fab fa-facebook-f"></i> Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                           target="_blank" 
                           class="btn btn-twitter">
                            <i class="fab fa-twitter"></i> Twitter
                        </a>
                    </div>
                </div>
            </article>

            <!-- Bài viết liên quan -->
            @if($relatedPosts->count() > 0)
                <div class="mt-5">
                    <h3>Bài viết liên quan</h3>
                    <div class="row">
                        @foreach($relatedPosts as $relatedPost)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    @if($relatedPost->featured_image)
                                        <img src="{{ Storage::url($relatedPost->featured_image) }}" 
                                             class="card-img-top" 
                                             alt="{{ $relatedPost->title }}"
                                             style="height: 150px; object-fit: cover;">
                                    @endif
                                    <div class="card-body">
                                        <h6 class="card-title">
                                            <a href="{{ route('blog.show', $relatedPost->slug) }}" 
                                               class="text-decoration-none">
                                                {{ $relatedPost->title }}
                                            </a>
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Widget danh mục -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Danh mục</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach($categories as $category)
                            <li class="mb-2">
                                <a href="{{ route('blog.category', $category->slug) }}" 
                                   class="text-decoration-none">
                                    {{ $category->name }}
                                    <span class="badge bg-secondary float-end">
                                        {{ $category->posts_count }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 