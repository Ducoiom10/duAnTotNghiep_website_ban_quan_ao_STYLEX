<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    public function run(): void
    {
        // Xóa toàn bộ dữ liệu banner hiện tại (kể cả đã soft delete)
        Banner::query()->forceDelete();

        $data = [
            [
                'title'        => 'Bộ sưu tập Danh Mục 2025',
                'content'      => 'BỘ SƯU TẬP MỚI',
                'image'        => '/client/images/slide-01.jpg',
                'redirect_url' => '/products',
                'order'        => 0,
                'status'       => 1,
            ],
            [
                'title'        => 'Bộ sưu tập nam mới',
                'content'      => 'Áo khoác & Áo choàng',
                'image'        => '/client/images/slide-02.jpg',
                'redirect_url' => '/products',
                'order'        => 1,
                'status'       => 1,
            ],
            [
                'title'        => 'Bộ sưu tập nam 2025',
                'content'      => 'Hàng mới về',
                'image'        => '/client/images/slide-03.jpg',
                'redirect_url' => '/products',
                'order'        => 2,
                'status'       => 1,
            ],
        ];

        foreach ($data as $row) {
            Banner::updateOrCreate(
                ['title' => $row['title']],
                $row
            );
        }
    }
}
