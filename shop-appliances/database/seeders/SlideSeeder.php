<?php

namespace Database\Seeders;

use App\Models\Slide;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class SlideSeeder extends Seeder
{
    public function run()
    {
        // Tạo thư mục slides nếu chưa có
        if(!is_dir(storage_path('app/public/slides'))) {
            mkdir(storage_path('app/public/slides'), 0755, true);
        }

        // Copy ảnh từ public/images/slides sang storage
        $images = [
            'slide-1.jpg',
            'slide-2.jpg',
            'slide-3.jpg'
        ];

        foreach($images as $image) {
            if(file_exists(public_path("images/slides/$image"))) {
                copy(
                    public_path("images/slides/$image"),
                    storage_path("app/public/slides/$image")
                );
            }
        }

        $slides = [
            [
                'title' => 'Máy Lạnh Inverter Tiết Kiệm Điện',
                'subtitle' => 'Giảm đến 40% điện năng tiêu thụ',
                'image' => 'slide-1.jpg',
                'link' => '/products',
                'order' => 1
            ],
            [
                'title' => 'Dịch Vụ Lắp Đặt Chuyên Nghiệp',
                'subtitle' => 'Đội ngũ kỹ thuật viên giàu kinh nghiệm',
                'image' => 'slide-2.jpg',
                'link' => '/services',
                'order' => 2
            ],
            [
                'title' => 'Bảo Hành Chính Hãng',
                'subtitle' => 'Yên tâm sử dụng với chế độ bảo hành tận nơi',
                'image' => 'slide-3.jpg',
                'link' => '/warranty',
                'order' => 3
            ]
        ];

        foreach ($slides as $slide) {
            Slide::create($slide);
        }
    }
} 