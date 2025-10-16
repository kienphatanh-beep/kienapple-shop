<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Lấy tất cả categories
public function index()
{
    $categories = Category::with('children')
        ->where('parent_id', 0)
        ->get();

    return response()->json($categories);
}


    // Tạo category mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return response()->json($category, 201);
    }

    // Xem chi tiết 1 category
    public function show($id)
    {
        return response()->json(Category::findOrFail($id));
    }

    // Cập nhật category
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $category->update([
            'name' => $request->name ?? $category->name,
            'description' => $request->description ?? $category->description,
        ]);

        return response()->json($category);
    }

    // Xóa category
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}
