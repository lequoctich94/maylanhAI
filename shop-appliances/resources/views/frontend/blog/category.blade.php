@extends('layouts.frontend')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-md-12 mb-4">
            <h1>{{ $category->name }}</h1>
            @if($category->description)
                <p class="text-muted">{{ $category->description }}</p>
            @endif
        </div>
    </div>

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
</div>
@endsection 