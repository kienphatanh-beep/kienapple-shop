<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $list = Brand::orderBy('created_at', 'desc')->paginate(5);
        return view('backend.brand.index', compact('list'));
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brand,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->slug = $request->slug ?: Str::slug($request->name);
        $brand->sort_order = $request->sort_order ?? 0;
        $brand->status = 1;
        $brand->created_by = Auth::id() ?? 1;
        $brand->created_at = now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = $brand->slug . '.' . $ext;
            $file->move(public_path('assets/images/brand'), $filename);
            $brand->image = $filename;
        }

        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', '✅ Thêm thương hiệu thành công!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.edit', compact('brand'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brand,slug,' . $id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $slug = Str::slug($request->slug ?: $request->name);
        $brand->name = $request->name;
        $brand->slug = $slug;
        $brand->sort_order = $request->sort_order ?? $brand->sort_order;
        $brand->status = $request->status ?? 1;
        $brand->updated_by = Auth::id() ?? 1;
        $brand->updated_at = now();

        if ($request->hasFile('image')) {
            $oldPath = public_path('assets/images/brand/' . $brand->image);
            if (File::exists($oldPath)) File::delete($oldPath);

            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension();
            $filename = $slug . '.' . $ext;
            $file->move(public_path('assets/images/brand'), $filename);
            $brand->image = $filename;
        }

        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', '✏️ Cập nhật thương hiệu thành công!');
    }

    public function delete($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->delete();
        return redirect()->route('admin.brand.index')->with('success', '🗑 Đã chuyển thương hiệu vào thùng rác.');
    }

    public function trash()
    {
        $list = Brand::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(5);
        return view('backend.brand.trash', compact('list'));
    }

    public function restore($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $brand->restore();
        return redirect()->route('admin.brand.trash')->with('success', '♻️ Khôi phục thương hiệu thành công!');
    }

    public function destroy($id)
    {
        $brand = Brand::onlyTrashed()->findOrFail($id);
        $imagePath = public_path('assets/images/brand/' . $brand->image);

        if ($brand->forceDelete() && File::exists($imagePath)) {
            File::delete($imagePath);
        }

        return redirect()->route('admin.brand.trash')->with('success', '❌ Xóa vĩnh viễn thương hiệu thành công!');
    }

    public function status($id)
    {
        $brand = Brand::findOrFail($id);
        $brand->status = $brand->status == 1 ? 0 : 1;
        $brand->updated_by = Auth::id() ?? 1;
        $brand->updated_at = now();
        $brand->save();

        return redirect()->route('admin.brand.index')->with('success', '🔄 Cập nhật trạng thái thành công.');
    }

    public function show($id)
    {
        $brand = Brand::findOrFail($id);
        return view('backend.brand.show', compact('brand'));
    }
}
