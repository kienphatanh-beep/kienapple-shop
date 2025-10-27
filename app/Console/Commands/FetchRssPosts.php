<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Vedmant\FeedReader\Facades\FeedReader;

class FetchRssPosts extends Command
{
    protected $signature = 'rss:fetch';
    protected $description = 'Fetch real news from RSS feed and insert into post table';

    public function handle()
    {
        $url = 'https://vnexpress.net/rss/tin-moi-nhat.rss'; // Nguồn RSS thật
        $feed = FeedReader::read($url);

        foreach ($feed->get_items() as $item) {
            $title = $item->get_title();
            $slug = Str::slug($title);

            // Nếu đã tồn tại slug này thì bỏ qua
            if (DB::table('post')->where('slug', $slug)->exists()) {
                continue;
            }

            // Lấy mô tả ngắn gọn (description)
            $desc = strip_tags($item->get_description());
            $desc = Str::limit($desc, 200);

            // Lấy ảnh thumbnail chính
            $thumbnail = $item->get_enclosure()?->get_link();

            // Nếu không có ảnh trong enclosure, thử tìm ảnh trong thẻ <img> của description
            if (!$thumbnail && preg_match('/<img.*?src="(.*?)"/', $item->get_description(), $m)) {
                $thumbnail = $m[1];
            }

            // Nếu vẫn không có ảnh, gán ảnh ngẫu nhiên
            if (!$thumbnail) {
                $thumbnail = 'https://picsum.photos/seed/' . rand(111, 999) . '/800/450';
            }

            // Lấy nội dung chi tiết
            $content = $item->get_content() ?: $item->get_description();
            $contentHtml = '<p>' . strip_tags($content, '<p><a><img><br><strong><em><figure><figcaption>') . '</p>';

            DB::table('post')->insert([
                'topic_id' => 1,
                'title' => $title,
                'slug' => $slug,
                'detail' => $contentHtml,
                'thumbnail' => $thumbnail,
                'type' => 'post',
                'description' => $desc,
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'status' => 1,
            ]);

            $this->info("✅ Đã thêm: {$title}");
        }

        $this->info('🎉 Hoàn tất! Đã tự động lấy tin từ RSS.');
    }
}
