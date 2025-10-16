<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    public function index()
    {
        $list = Category::orderBy('created_at', 'desc')->paginate(5);
        return view('backend.category.index', compact('list'));
    }

    public function create()
    {
        $list_category = Category::select('id', 'name')->get();
        return view('backend.category.create', compact('list_category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->slug ?: $request->name);
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order ?? 0;
        $category->status = $request->status;
        $category->created_by = Auth::id() ?? 1;
        $category->created_at = now();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $category->slug . '.' . $extension;
            $file->move(public_path('assets/images/category'), $filename);
            $category->image = $filename;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', '✅ Thêm danh mục thành công.');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $list_parent = Category::where('id', '!=', $id)->get();
        return view('backend.category.edit', compact('category', 'list_parent'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,,webp,jpg,gif,svg|max:2048',
        ]);

        $category = Category::findOrFail($id);
        $slug = Str::slug($request->slug ?: $request->name);

        $category->name = $request->name;
        $category->slug = $slug;
        $category->description = $request->description;
        $category->parent_id = $request->parent_id;
        $category->sort_order = $request->sort_order ?? 0;
        $category->status = $request->status;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = now();

        $oldImagePath = public_path('assets/images/category/' . $category->image);

        if ($request->hasFile('image')) {
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = $slug . '.' . $extension;
            $file->move(public_path('assets/images/category'), $filename);
            $category->image = $filename;
        }

        $category->save();

        return redirect()->route('admin.category.index')->with('success', '✅ Cập nhật danh mục thành công.');
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.category.index')->with('success', '🗑 Đã chuyển danh mục vào thùng rác.');
    }

    public function show($id)
    {
        $category = Category::with('parent')->findOrFail($id);
        return view('backend.category.show', compact('category'));
    }
    
    public function trash()
    {
        $list = Category::onlyTrashed()->paginate(10);
        return view('backend.category.trash', compact('list'));
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('admin.category.trash')->with('success', '♻️ Khôi phục danh mục thành công.');
    }

    public function destroy($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $imagePath = public_path('assets/images/category/' . $category->image);

        if ($category->forceDelete()) {
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        return redirect()->route('admin.category.trash')->with('success', '❌ Xóa vĩnh viễn danh mục.');
    }

    public function status($id)
    {
        $category = Category::findOrFail($id);
        $category->status = $category->status == 1 ? 0 : 1;
        $category->updated_by = Auth::id() ?? 1;
        $category->updated_at = now();
        $category->save();

        return redirect()->route('admin.category.index')->with('success', '🔄 Cập nhật trạng thái thành công.');
    }
}
