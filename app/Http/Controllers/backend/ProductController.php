<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $list = Product::select('product.id', 'product.name', 'category.name as categoryname', 'brand.name as brandname', 'thumbnail', 'product.status')
            ->join('category', 'product.category_id', '=', 'category.id')
            ->join('brand', 'product.brand_id', '=', 'brand.id')
            ->orderBy('product.created_at', 'desc')
            ->paginate(5);

        return view('backend.product.index', compact('list'));
    }

    public function create()
    {
        $list_category = Category::select('name', 'id')->orderBy('sort_order', 'asc')->get();
        $list_brand = Brand::select('name', 'id')->orderBy('sort_order', 'asc')->get();

        return view('backend.product.create', compact('list_category', 'list_brand'));
    }

    // 🧩 Sửa sản phẩm
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $list_category = Category::select('name', 'id')->orderBy('sort_order', 'asc')->get();
        $list_brand = Brand::select('name', 'id')->orderBy('sort_order', 'asc')->get();

        return view('backend.product.edit', compact('product', 'list_category', 'list_brand'));
    }

    // ✅ Thêm sản phẩm mới
    public function store(StoreProductRequest $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->slug = Str::of($request->name)->slug('-');
        $product->detail = $request->detail;
        $product->description = $request->description;
        $product->price_root = $request->price_root;
        $product->price_sale = $request->price_sale;
        $product->qty = $request->qty;
        $product->stock = $request->qty;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = $product->slug . '.' . $extension;
            $file->move(public_path('assets/images/product/'), $filename);
            $product->thumbnail = $filename;
        }

        $product->status = $request->status;
        $product->created_at = now();
        $product->created_by = Auth::id() ?? 1;
        $product->save();

        return redirect()->route('admin.product.index')->with('thongbao', '✅ Thêm sản phẩm thành công');
    }

    // ✅ Cập nhật sản phẩm
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        $old_qty = $product->qty;
        $old_stock = $product->stock;

        $product->name = $request->name;
        $product->slug = Str::of($request->name)->slug('-');
        $product->detail = $request->detail;
        $product->description = $request->description;
        $product->price_root = $request->price_root;
        $product->price_sale = $request->price_sale;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->status = $request->status;

        $new_qty = $request->qty;
        $product->qty = $new_qty;
        $product->stock = $old_stock + ($new_qty - $old_qty);

        if ($request->hasFile('thumbnail')) {
            $oldPath = public_path('assets/images/product/') . $product->thumbnail;
            if (!empty($product->thumbnail) && is_file($oldPath)) {
                unlink($oldPath);
            }

            $file = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $filename = $product->slug . '.' . $extension;
            $file->move(public_path('assets/images/product/'), $filename);
            $product->thumbnail = $filename;
        }

        $product->updated_at = now();
        $product->updated_by = Auth::id() ?? 1;
        $product->save();

        return redirect()->route('admin.product.index')->with('thongbao', '✅ Cập nhật sản phẩm thành công');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.product.index')->with('thongbao', '🗑️ Sản phẩm đã được xóa tạm thời');
    }

    public function trash()
    {
        $products = Product::onlyTrashed()->with('category', 'brand')->paginate(5);
        return view('backend.product.trash', compact('products'));
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()->route('admin.product.trash')->with('success', '♻️ Sản phẩm đã được khôi phục');
    }

    public function show(string $id)
    {
        $product = Product::with('category', 'brand')->findOrFail($id);
        return view('backend.product.show', compact('product'));
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $path = public_path('assets/images/product/') . $product->thumbnail;

        if (!empty($product->thumbnail) && is_file($path)) {
            unlink($path);
        }

        $product->forceDelete();
        return redirect()->route('admin.product.trash')->with('success', '❌ Sản phẩm đã bị xóa vĩnh viễn.');
    }

    public function status($id)
    {
        $product = Product::findOrFail($id);
        $product->status = $product->status == 1 ? 0 : 1;
        $product->save();

        return redirect()->route('admin.product.index')->with('thongbao', '🔄 Trạng thái sản phẩm đã được thay đổi');
    }
}
