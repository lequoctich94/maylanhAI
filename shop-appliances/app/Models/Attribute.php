<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name', 
        'type', 
        'is_required', 
        'is_active',
        'options'
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'options' => 'array'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class)
            ->withPivot('sort_order')
            ->withTimestamps();
    }

    public function productAttributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }
} 