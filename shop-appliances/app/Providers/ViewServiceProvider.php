<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('layouts.frontend', function ($view) {
            $view->with([
                'categories' => Category::active()->withCount('products')->get(),
                'cartCount' => session('cart') ? count(session('cart')) : 0
            ]);
        });
    }
} 