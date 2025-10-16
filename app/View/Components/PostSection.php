<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Post;
use App\Models\Topic;

class PostSection extends Component
{
    public $posts;
    public $topicName;

    public function __construct()
    {
        // 📰 Lấy 4 bài viết mới nhất
        $this->posts = Post::where('status', 1)
            ->latest()
            ->take(4)
            ->get(['id', 'title', 'slug', 'thumbnail', 'description']);

        // Tùy chọn: Lấy chủ đề mới nhất (nếu muốn hiển thị tên chuyên mục)
        $this->topicName = Topic::where('status', 1)->latest()->value('name');
    }

    public function render()
    {
        return view('components.post-section');
    }
}
