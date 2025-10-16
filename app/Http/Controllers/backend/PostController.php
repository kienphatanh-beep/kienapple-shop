<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Topic;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    // 🧭 DANH SÁCH BÀI VIẾT
    public function index()
    {
        $list = Post::select(
                'post.id',
                'post.title',
                'post.slug',
                'post.detail',
                'post.thumbnail',
                'topic.name as topic_name',
                'post.status'
            )
            ->join('topic', 'post.topic_id', '=', 'topic.id')
            ->orderBy('post.created_at', 'desc')
            ->paginate(8);

        return view('backend.post.index', compact('list'));
    }

    // ➕ FORM THÊM
    public function create()
    {
        $list_topic = Topic::select('id', 'name')->get();
        return view('backend.post.create', compact('list_topic'));
    }

    // 💾 XỬ LÝ THÊM MỚI
    public function store(StorePostRequest $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->slug = Str::of($request->title)->slug('-');
        $post->description = $request->description;
        $post->detail = $request->detail;
        $post->topic_id = $request->topic_id;
        $post->status = $request->status ?? 0;
        $post->created_by = Auth::id() ?? 1;

        // 📸 Upload ảnh
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $ext = $file->getClientOriginalExtension();
            $filename = $post->slug . '.' . $ext;
            $file->move(public_path('assets/images/post'), $filename);
            $post->thumbnail = $filename;
        }

        $post->save();
        return redirect()->route('admin.post.index')->with('success', '✅ Thêm bài viết thành công!');
    }

    // 👁 XEM CHI TIẾT
    public function show(string $id)
    {
        $post = Post::with('topic')->findOrFail($id);
        return view('backend.post.show', compact('post'));
    }

    // ✏️ FORM SỬA
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $list_topic = Topic::select('id', 'name')->get();
        return view('backend.post.edit', compact('post', 'list_topic'));
    }

    // 💾 XỬ LÝ CẬP NHẬT
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = Post::findOrFail($id);
        $slug = Str::of($request->title)->slug('-');

        $post->title = $request->title;
        $post->slug = $slug;
        $post->description = $request->description;
        $post->detail = $request->detail;
        $post->topic_id = $request->topic_id;
        $post->status = $request->status;
        $post->updated_by = Auth::id() ?? 1;

        // 📸 Cập nhật ảnh
        if ($request->hasFile('thumbnail')) {
            $old_path = public_path('assets/images/post/' . $post->thumbnail);
            if (File::exists($old_path)) {
                File::delete($old_path);
            }

            $file = $request->file('thumbnail');
            $ext = $file->getClientOriginalExtension();
            $filename = $slug . '.' . $ext;
            $file->move(public_path('assets/images/post'), $filename);
            $post->thumbnail = $filename;
        }

        $post->save();
        return redirect()->route('admin.post.index')->with('success', '✏️ Cập nhật bài viết thành công!');
    }

    // 🗑 DANH SÁCH THÙNG RÁC
    public function trash()
    {
        $list = Post::onlyTrashed()
            ->select(
                'post.id',
                'post.title',
                'post.slug',
                'post.thumbnail',
                'topic.name as topic_name'
            )
            ->join('topic', 'post.topic_id', '=', 'topic.id')
            ->orderBy('post.deleted_at', 'desc')
            ->paginate(8);

        return view('backend.post.trash', compact('list'));
    }

    // ⚙️ CHUYỂN TRẠNG THÁI
    public function status($id)
    {
        $post = Post::findOrFail($id);
        $post->status = ($post->status == 1) ? 0 : 1;
        $post->updated_by = Auth::id() ?? 1;
        $post->updated_at = now();
        $post->save();

        return redirect()->route('admin.post.index')->with('success', '🔄 Đã cập nhật trạng thái!');
    }

    // ♻️ XÓA MỀM
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete(); // soft delete
        return redirect()->route('admin.post.index')->with('success', '🗑 Đã chuyển vào thùng rác!');
    }

    // 🔄 KHÔI PHỤC
    public function restore($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $post->restore();
        return redirect()->route('admin.post.trash')->with('success', '♻️ Khôi phục thành công!');
    }

    // ❌ XÓA VĨNH VIỄN
    public function forceDelete($id)
    {
        $post = Post::onlyTrashed()->findOrFail($id);
        $image_path = public_path('assets/images/post/' . $post->thumbnail);

        if ($post->forceDelete()) {
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        return redirect()->route('admin.post.trash')->with('success', '🔥 Đã xóa vĩnh viễn!');
    }
}
