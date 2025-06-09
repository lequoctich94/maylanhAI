<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'image',
        'link',
        'order',
        'is_active',
        'is_mobile'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_mobile' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeMobile($query)
    {
        return $query->where('is_mobile', true);
    }

    public function scopeDesktop($query)
    {
        return $query->where('is_mobile', false);
    }
} 