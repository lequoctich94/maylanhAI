<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'excerpt',
        'featured_image',
        'status',
        'category_id',
        'user_id',
        'product_id',
        'published_at',
        'meta_title',
        'meta_description'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relationship với danh mục
    public function category(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'category_id');
    }

    // Relationship với người tạo
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship với sản phẩm
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scope để lấy bài viết đã xuất bản
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    // Scope để lấy bài viết nháp
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Tăng lượt xem
    public function incrementViewCount()
    {
        $this->increment('view_count');
    }
} 