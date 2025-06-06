<?php

use App\Http\Controllers\Frontend\{
    HomeController,
    ProductController,
    CartController,
    CheckoutController,
    ProfileController,
    SearchController,
    BlogController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    CategoryController,
    ProductController as AdminProductController,
    OrderController,
    UserController,
    SlideController,
    CategoryAttributeController,
    AttributeController,
    PostController,
    PostCategoryController
};
use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/category/{category:slug}', [ProductController::class, 'category'])->name('products.category');
Route::get('/search', [SearchController::class, 'search'])->name('products.search');

// Cart Routes (moved outside auth middleware)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{productId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

// Checkout Routes (moved outside auth middleware)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/{order}/success', [CheckoutController::class, 'success'])->name('checkout.success');

// Profile Routes
Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Products
    Route::resource('products', AdminProductController::class);

    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Slides
    Route::resource('slides', SlideController::class);

    // Category Attributes
    Route::resource('attributes', AttributeController::class);
    Route::get('/categories/{category}/attributes', [CategoryAttributeController::class, 'getAttributes'])
        ->name('categories.attributes');

    // Posts
    Route::resource('posts', PostController::class);
    Route::resource('post-categories', PostCategoryController::class);
    Route::post('posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
    
    Route::post('admin/posts/upload-image', [PostController::class, 'uploadImage'])->name('admin.posts.upload-image');
});

require __DIR__.'/auth.php';
