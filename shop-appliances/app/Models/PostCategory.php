<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id'
    ];

    // Relationship với danh mục cha
    public function parent(): BelongsTo
    {
        return $this->belongsTo(PostCategory::class, 'parent_id');
    }

    // Relationship với các danh mục con
    public function children(): HasMany
    {
        return $this->hasMany(PostCategory::class, 'parent_id');
    }

    // Relationship với các bài viết
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class, 'category_id');
    }
} 