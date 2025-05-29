# Blog Module Specification

## 1. Overview
Module blog được tích hợp vào hệ thống hiện tại, cho phép quản trị viên tạo và quản lý các bài viết giới thiệu sản phẩm. Module này sẽ tận dụng hệ thống authentication và authorization hiện có.

## 2. Integration Points
- Sử dụng hệ thống authentication hiện tại
- Tích hợp với menu admin hiện có
- Tận dụng layout và theme hiện tại
- Kết nối với hệ thống sản phẩm hiện có

## 3. Database Structure

### 3.1 Posts Table
```sql
posts
- id (bigint, primary key)
- title (varchar)
- slug (varchar, unique)
- content (text)
- excerpt (text, nullable)
- featured_image (varchar, nullable)
- status (enum: draft, published)
- category_id (foreign key)
- user_id (foreign key)
- product_id (foreign key, nullable) - Liên kết với sản phẩm
- created_at (timestamp)
- updated_at (timestamp)
- published_at (timestamp, nullable)
- meta_title (varchar, nullable)
- meta_description (text, nullable)
- view_count (integer, default: 0)
```

### 3.2 Categories Table
```sql
post_categories
- id (bigint, primary key)
- name (varchar)
- slug (varchar, unique)
- description (text, nullable)
- parent_id (foreign key, nullable)
- created_at (timestamp)
- updated_at (timestamp)
```

## 4. Features

### 4.1 Admin Features
1. **Post Management**
   - CRUD operations for posts
   - Rich text editor (CKEditor 5)
   - Image upload and management
   - Draft/Publish functionality
   - SEO metadata management
   - Liên kết bài viết với sản phẩm

2. **Category Management**
   - CRUD operations for categories
   - Category assignment to posts

3. **Media Management**
   - Image upload và optimization
   - File upload support
   - Media library organization

### 4.2 Frontend Features
1. **Blog Display**
   - Responsive blog listing
   - Category-based filtering
   - Search functionality
   - Pagination
   - Related products

2. **Post Display**
   - Rich text content rendering
   - Image gallery support
   - Social sharing buttons
   - Product information integration
   - Publication date

## 5. Routes

### 5.1 Admin Routes
```php
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Blog Routes
    Route::resource('posts', PostController::class);
    Route::post('posts/upload-image', [PostController::class, 'uploadImage'])->name('posts.upload-image');
    Route::post('posts/upload-file', [PostController::class, 'uploadFile'])->name('posts.upload-file');
    
    // Blog Categories
    Route::resource('post-categories', PostCategoryController::class);
});
```

### 5.2 Frontend Routes
```php
use App\Http\Controllers\Frontend\BlogController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/blog/category/{category:slug}', [BlogController::class, 'category'])->name('blog.category');
```

## 6. File Structure
```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── PostController.php
│   │   │   └── PostCategoryController.php
│   │   └── Frontend/
│   │       └── BlogController.php
│   └── Requests/
│       ├── Admin/
│       │   ├── PostRequest.php
│       │   └── PostCategoryRequest.php
│       └── Frontend/
│           └── BlogRequest.php
├── Models/
│   ├── Post.php
│   └── PostCategory.php
└── Services/
    └── BlogService.php

resources/
└── views/
    ├── admin/
    │   ├── posts/
    │   │   ├── index.blade.php
    │   │   ├── create.blade.php
    │   │   └── edit.blade.php
    │   └── categories/
    │       ├── index.blade.php
    │       ├── create.blade.php
    │       └── edit.blade.php
    └── frontend/
        ├── blog/
        │   ├── index.blade.php
        │   └── show.blade.php
        └── categories/
            └── show.blade.php
```

## 7. Integration Requirements
- Tích hợp menu blog vào admin dashboard
- Thêm link blog vào navigation menu
- Tích hợp với hệ thống sản phẩm
- Tận dụng hệ thống upload hiện có
- Sử dụng theme và layout hiện tại

## 8. Security Considerations
- Tận dụng hệ thống authentication hiện có
- CSRF protection
- XSS prevention
- Input sanitization
- File upload validation

## 9. Performance Optimization
- Image optimization
- Caching strategy
- Database indexing
- Lazy loading for images
- Pagination implementation

## 10. SEO Requirements
- Meta title and description
- Open Graph tags
- Canonical URLs
- SEO-friendly URLs

## 11. Testing Requirements
- Unit tests for models
- Feature tests for controllers
- Integration tests
- Browser tests for frontend features

## 12. Timeline
1. Phase 1: Setup (3 days)
   - Database setup
   - Basic CRUD operations
   - Admin interface

2. Phase 2: Core Features (4 days)
   - Rich text editor integration
   - Media management
   - Category system
   - Product integration

3. Phase 3: Frontend (3 days)
   - Blog listing
   - Post display
   - Search functionality

4. Phase 4: Enhancement (2 days)
   - SEO optimization
   - Performance optimization
   - Testing and bug fixes

## 13. Maintenance
- Regular security updates
- Performance monitoring
- Content optimization
- User feedback collection
