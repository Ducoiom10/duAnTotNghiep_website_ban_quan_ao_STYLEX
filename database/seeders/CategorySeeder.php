<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear table first
        // Category::truncate();

        // Danh mục cha chính
        $aoNam = Category::create(['name' => 'Áo Nam', 'parent_id' => null, 'status' => 1]);
        $aoNu = Category::create(['name' => 'Áo Nữ', 'parent_id' => null, 'status' => 1]);
        $quanNam = Category::create(['name' => 'Quần Nam', 'parent_id' => null, 'status' => 1]);
        $quanNu = Category::create(['name' => 'Quần Nữ', 'parent_id' => null, 'status' => 1]);
        $giayDep = Category::create(['name' => 'Giày Dép', 'parent_id' => null, 'status' => 1]);
        $phuKien = Category::create(['name' => 'Phụ Kiện', 'parent_id' => null, 'status' => 1]);

        // Danh mục con cho Áo Nam
        Category::create(['name' => 'Áo Sơ Mi', 'parent_id' => $aoNam->id, 'status' => 1]);
        Category::create(['name' => 'Áo Thun', 'parent_id' => $aoNam->id, 'status' => 1]);
        Category::create(['name' => 'Áo Khoác', 'parent_id' => $aoNam->id, 'status' => 1]);
        Category::create(['name' => 'Áo Vest', 'parent_id' => $aoNam->id, 'status' => 1]);

        // Danh mục con cho Áo Nữ
        Category::create(['name' => 'Áo Dài', 'parent_id' => $aoNu->id, 'status' => 1]);
        Category::create(['name' => 'Áo Blouse', 'parent_id' => $aoNu->id, 'status' => 1]);
        Category::create(['name' => 'Áo Thun Nữ', 'parent_id' => $aoNu->id, 'status' => 1]);
        Category::create(['name' => 'Áo Khoác Nữ', 'parent_id' => $aoNu->id, 'status' => 1]);

        // Danh mục con cho Quần Nam
        Category::create(['name' => 'Quần Jean', 'parent_id' => $quanNam->id, 'status' => 1]);
        Category::create(['name' => 'Quần Kaki', 'parent_id' => $quanNam->id, 'status' => 1]);
        Category::create(['name' => 'Quần Short', 'parent_id' => $quanNam->id, 'status' => 1]);
        Category::create(['name' => 'Quần Âu', 'parent_id' => $quanNam->id, 'status' => 1]);

        // Danh mục con cho Quần Nữ
        Category::create(['name' => 'Quần Jean Nữ', 'parent_id' => $quanNu->id, 'status' => 1]);
        Category::create(['name' => 'Quần Short Nữ', 'parent_id' => $quanNu->id, 'status' => 1]);
        Category::create(['name' => 'Quần Legging', 'parent_id' => $quanNu->id, 'status' => 1]);
        Category::create(['name' => 'Chân Váy', 'parent_id' => $quanNu->id, 'status' => 1]);

        // Danh mục con cho Giày Dép
        Category::create(['name' => 'Giày Thể Thao', 'parent_id' => $giayDep->id, 'status' => 1]);
        Category::create(['name' => 'Giày Tây', 'parent_id' => $giayDep->id, 'status' => 1]);
        Category::create(['name' => 'Giày Cao Gót', 'parent_id' => $giayDep->id, 'status' => 1]);
        Category::create(['name' => 'Dép', 'parent_id' => $giayDep->id, 'status' => 1]);

        // Danh mục con cho Phụ Kiện
        Category::create(['name' => 'Túi Xách', 'parent_id' => $phuKien->id, 'status' => 1]);
        Category::create(['name' => 'Ví', 'parent_id' => $phuKien->id, 'status' => 1]);
        Category::create(['name' => 'Đồng Hồ', 'parent_id' => $phuKien->id, 'status' => 1]);
        Category::create(['name' => 'Trang Sức', 'parent_id' => $phuKien->id, 'status' => 1]);
    }
}


