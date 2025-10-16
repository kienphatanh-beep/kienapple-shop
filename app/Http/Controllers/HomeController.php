<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    // 🏠 Trang chủ
    public function index()
    {
        // ✅ Lấy danh mục cha + danh mục con
        $categories = Category::with('children')
            ->where('parent_id', 0)
            ->get();

        // ✅ Sản phẩm mới nhất
        $newProducts = Product::where('status', 1)
            ->latest()
            ->take(8)
            ->get();

        // ✅ Sản phẩm flash sale
        $saleProducts = Product::where('status', 1)
            ->whereNotNull('price_sale')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        return view('frontend.home', compact('categories', 'newProducts', 'saleProducts'));
    }
}
