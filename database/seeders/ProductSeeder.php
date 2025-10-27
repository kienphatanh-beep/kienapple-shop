<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        // Danh mục (id => tên)
        $categories = [
            1 => 'Điện Thoại',
            2 => 'Laptop',
            3 => 'Tablet',
            4 => 'Phụ Kiện',
            5 => 'SmartWatch',
        ];

        // Thương hiệu (id => tên)
        $brands = [
            1 => 'Apple',
            2 => 'Vivo',
            3 => 'Samsung',
            4 => 'Realme',
            5 => 'DELL',
            6 => 'Xiaomi',
            7 => 'Asus',
        ];

        // ✅ Ảnh mặc định (bạn đặt sẵn trong public/assets/images/product/maudt.jpg)
        $defaultImage = 'maudt.jpg';

        $products = [];

        for ($i = 1; $i <= 1000; $i++) {
            $category_id = $faker->numberBetween(1, 5);
            $brand_id = $faker->numberBetween(1, 7);

            $name = "{$brands[$brand_id]} {$categories[$category_id]} " .
                $faker->randomElement(['Pro', 'Plus', 'Max', 'Mini', 'SE']) . " " .
                $faker->numberBetween(2022, 2025);

            $slug = Str::slug($name) . '-' . $i;

            $price_root = $faker->numberBetween(2000000, 90000000);
            $price_sale = $price_root - $faker->numberBetween(500000, 15000000);

            $stock = $faker->numberBetween(5, 300);
            $sold = $faker->numberBetween(0, $stock / 2);

            $products[] = [
                'category_id' => $category_id,
                'brand_id'    => $brand_id,
                'name'        => $name,
                'slug'        => $slug,
                'price_root'  => $price_root,
                'price_sale'  => $price_sale,
                'thumbnail'   => $defaultImage, // 🔥 tất cả đều dùng maudt.jpg
                'qty'         => $stock,
                'stock'       => $stock,
                'sold'        => $sold,
                'detail'      => '<p>' . implode('</p><p>', $faker->paragraphs(rand(3, 6))) . '</p>',
                'description' => $faker->sentence(18),
                'created_by'  => 1,
                'updated_by'  => null,
                'status'      => 1,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        // ✅ Chia nhỏ insert để tránh lỗi max_allowed_packet
        foreach (array_chunk($products, 200) as $chunk) {
            DB::table('product')->insert($chunk);
        }

        echo "✅ Đã thêm 1000 sản phẩm với ảnh mặc định maudt.jpg!\n";
    }
}
