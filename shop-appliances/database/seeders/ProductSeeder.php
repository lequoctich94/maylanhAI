<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Tạo symbolic link từ public/storage đến storage/app/public
        if(!file_exists(public_path('storage'))) {
            \Artisan::call('storage:link');
        }

        // Copy hình mẫu vào storage
        $defaultImage = 'default-product.jpg';
        if(!file_exists(storage_path('app/public/products/' . $defaultImage))) {
            if(!is_dir(storage_path('app/public/products'))) {
                mkdir(storage_path('app/public/products'), 0755, true);
            }
            copy(public_path('images/' . $defaultImage), storage_path('app/public/products/' . $defaultImage));
        }

        $products = [
            [
                'category_id' => 1, // Máy Lạnh Treo Tường
                'name' => 'Máy Lạnh Daikin Inverter 1.5 HP',
                'description' => 'Máy lạnh Daikin Inverter 1.5 HP tiết kiệm điện, làm lạnh nhanh',
                'price' => 11990000,
                'image' => $defaultImage
            ],
            [
                'category_id' => 1,
                'name' => 'Máy Lạnh Panasonic Inverter 2.0 HP',
                'description' => 'Máy lạnh Panasonic Inverter 2.0 HP với công nghệ nanoe™ X',
                'price' => 15990000,
                'discount_price' => 14990000,
                'image' => $defaultImage
            ],
            [
                'category_id' => 2, // Máy Lạnh Âm Trần
                'name' => 'Máy Lạnh Âm Trần Daikin 3.0 HP',
                'description' => 'Máy lạnh âm trần Daikin 3.0 HP thích hợp cho văn phòng',
                'price' => 28990000,
                'image' => $defaultImage
            ],
            [
                'category_id' => 2,
                'name' => 'Máy Lạnh Âm Trần Casper 5.0 HP',
                'description' => 'Máy lạnh âm trần Casper 5.0 HP công suất lớn',
                'price' => 35990000,
                'discount_price' => 32990000,
                'image' => $defaultImage
            ],
            [
                'category_id' => 3, // Máy Lạnh Tủ Đứng
                'name' => 'Máy Lạnh Tủ Đứng LG 5.0 HP',
                'description' => 'Máy lạnh tủ đứng LG 5.0 HP cho không gian lớn',
                'price' => 42990000,
                'image' => $defaultImage
            ],
            [
                'category_id' => 3,
                'name' => 'Máy Lạnh Tủ Đứng Gree 10.0 HP',
                'description' => 'Máy lạnh tủ đứng Gree 10.0 HP công nghiệp',
                'price' => 65990000,
                'discount_price' => 59990000,
                'image' => $defaultImage
            ]
        ];

        foreach ($products as $product) {
            Product::create([
                'category_id' => $product['category_id'],
                'name' => $product['name'],
                'slug' => Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'discount_price' => $product['discount_price'] ?? null,
                'image' => $product['image'],
                'is_active' => true
            ]);
        }
    }
} 