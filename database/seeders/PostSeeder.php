<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('vi_VN');

        for ($i = 1; $i <= 30; $i++) {
            $title = $faker->sentence(rand(6, 12));
            $slug = Str::slug($title);

            DB::table('post')->insert([
                'topic_id' => rand(1, 3),
                'title' => $title,
                'slug' => $slug,
                // Nội dung chi tiết HTML có đoạn văn và ảnh minh họa
                'detail' => '
                    <p>' . implode('</p><p>', $faker->paragraphs(rand(5, 9))) . '</p>
                    <figure style="margin:20px 0;text-align:center">
                        <img src="https://picsum.photos/seed/' . rand(100, 999) . '/800/400" 
                             alt="' . $title . '" 
                             style="max-width:100%;border-radius:12px">
                        <figcaption style="font-size:14px;color:#666;margin-top:6px">
                            Hình minh họa cho bài viết
                        </figcaption>
                    </figure>
                    <p>' . implode('</p><p>', $faker->paragraphs(rand(3, 6))) . '</p>
                ',
                // Thumbnail chính (ảnh đại diện)
                'thumbnail' => 'https://picsum.photos/seed/' . rand(2000, 9000) . '/800/450',
                'type' => 'post',
                'description' => $faker->sentence(rand(12, 18)),
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
            ]);
        }
    }
}
