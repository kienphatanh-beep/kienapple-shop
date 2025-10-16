<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(9); // Mỗi trang 9 bài

        return view('frontend.post.index', compact('posts'));
    }

   public function show($slug)
{
    $post = Post::where('slug', $slug)->where('status', 1)->firstOrFail();

    $relatedPosts = Post::where('status', 1)
        ->where('id', '!=', $post->id)
        ->where('topic_id', $post->topic_id)
        ->latest()
        ->take(3)
        ->get();

    return view('frontend.post.show', compact('post', 'relatedPosts'));
}

    
}
