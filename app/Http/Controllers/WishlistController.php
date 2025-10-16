<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * ✅ Bật / Tắt yêu thích (AJAX)
     */
    public function toggle($product_id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để sử dụng danh sách yêu thích.'
            ], 401);
        }

        $user_id = Auth::id();

        // Kiểm tra xem đã tồn tại trong danh sách chưa
        $wishlist = Wishlist::where('user_id', $user_id)
                            ->where('product_id', $product_id)
                            ->first();

        if ($wishlist) {
            $wishlist->delete();
            return response()->json([
                'success' => true,
                'liked' => false,
                'message' => '❌ Đã xóa khỏi danh sách yêu thích.'
            ]);
        }

        Wishlist::create([
            'user_id' => $user_id,
            'product_id' => $product_id,
        ]);

        return response()->json([
            'success' => true,
            'liked' => true,
            'message' => '❤️ Đã thêm vào danh sách yêu thích.'
        ]);
    }

    /**
     * ✅ Hiển thị danh sách yêu thích
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem danh sách yêu thích.');
        }

        $items = Wishlist::with('product')->where('user_id', Auth::id())->get();

        return view('wishlist.index', compact('items'));
    }
}
