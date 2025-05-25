<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryAttributeController extends Controller
{
    public function getAttributes(Category $category)
    {
        return response()->json($category->attributes()->orderBy('sort_order')->get());
    }
} 