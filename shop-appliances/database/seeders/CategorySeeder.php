<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Máy Lạnh Treo Tường',
                'description' => 'Các loại máy lạnh treo tường phổ biến cho gia đình và văn phòng nhỏ'
            ],
            [
                'name' => 'Máy Lạnh Âm Trần',
                'description' => 'Máy lạnh âm trần cho không gian rộng và thẩm mỹ cao'
            ],
            [
                'name' => 'Máy Lạnh Tủ Đứng',
                'description' => 'Máy lạnh tủ đứng công suất lớn cho không gian thương mại'
            ],
            [
                'name' => 'Máy Lạnh Multi',
                'description' => 'Hệ thống máy lạnh multi cho nhiều phòng'
            ]
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'is_active' => true
            ]);
        }
    }
} 