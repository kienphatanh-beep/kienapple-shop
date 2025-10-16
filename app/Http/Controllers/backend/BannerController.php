<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    // 🧭 DANH SÁCH BANNER
    public function index()
    {
        $list = Banner::orderBy('created_at', 'desc')->paginate(8);
        return view('backend.banner.index', compact('list'));
    }

    // 👁 XEM CHI TIẾT
    public function show(string $id)
    {
        $banner = Banner::findOrFail($id);
        return view('backend.banner.show', compact('banner'));
    }

    // ➕ FORM THÊM
    public function create()
    {
        $positions = ['slideshow' => 'Slide Show', 'ads' => 'Quảng cáo'];
        return view('backend.banner.create', compact('positions'));
    }

    // 💾 THÊM MỚI
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'position' => 'required|in:slideshow,ads',
        ]);

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->sort_order = $request->sort_order ?? 1;
        $banner->position = $request->position;
        $banner->status = 1;
        $banner->created_by = Auth::id() ?? 1;

        // 📸 Upload ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($banner->name) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $filename);
            $banner->image = $filename;
        } else {
            // Nếu không có ảnh => dùng ảnh mặc định
            $banner->image = 'default-' . time() . '.jpg';
        }

        $banner->save();
        return redirect()->route('admin.banner.index')->with('thongbao', '✅ Thêm banner thành công!');
    }

    // ✏️ FORM SỬA
    public function edit(string $id)
    {
        $banner = Banner::findOrFail($id);
        $positions = ['slideshow' => 'Slide Show', 'ads' => 'Quảng cáo'];
        return view('backend.banner.edit', compact('banner', 'positions'));
    }

    // 💾 CẬP NHẬT
    public function update(Request $request, string $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'sort_order' => 'nullable|integer',
            'position' => 'required|in:slideshow,ads',
        ]);

        $banner->name = $request->name;
        $banner->position = $request->position;
        $banner->sort_order = $request->sort_order ?? $banner->sort_order;
        $banner->status = $request->status ?? $banner->status;
        $banner->updated_by = Auth::id() ?? 1;
        $banner->updated_at = now();

        // 📸 Cập nhật ảnh
        if ($request->hasFile('image')) {
            $old_path = public_path('assets/images/banner/' . $banner->image);
            if (File::exists($old_path)) {
                File::delete($old_path);
            }

            $file = $request->file('image');
            $filename = Str::slug($request->name) . '-' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/images/banner'), $filename);
            $banner->image = $filename;
        }

        $banner->save();
        return redirect()->route('admin.banner.index')->with('thongbao', '✏️ Cập nhật banner thành công!');
    }

    // 🗑 XÓA MỀM
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete(); // soft delete
        return redirect()->route('admin.banner.index')->with('thongbao', '🗑 Đã chuyển banner vào thùng rác!');
    }

    // 🧹 THÙNG RÁC
    public function trash()
    {
        $list = Banner::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(8);
        return view('backend.banner.trash', compact('list'));
    }

    // ♻️ KHÔI PHỤC
    public function restore($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $banner->restore();
        return redirect()->route('admin.banner.trash')->with('thongbao', '♻️ Khôi phục banner thành công!');
    }

    // ❌ XÓA VĨNH VIỄN
    public function forceDelete($id)
    {
        $banner = Banner::onlyTrashed()->findOrFail($id);
        $image_path = public_path('assets/images/banner/' . $banner->image);

        if ($banner->forceDelete()) {
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        return redirect()->route('admin.banner.trash')->with('thongbao', '🔥 Đã xóa vĩnh viễn banner!');
    }

    // 🔄 TRẠNG THÁI
    public function status($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->status = ($banner->status == 1) ? 0 : 1;
        $banner->updated_by = Auth::id() ?? 1;
        $banner->updated_at = now();
        $banner->save();

        return redirect()->route('admin.banner.index')->with('thongbao', '🔁 Đã cập nhật trạng thái banner!');
    }
}
