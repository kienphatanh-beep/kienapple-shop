<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * 🧾 Lịch sử đơn hàng của người dùng (frontend)
     */
    public function history()
    {
        $orders = Order::with(['orderDetails.product.brand'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.order.history', compact('orders'));
    }

    /**
     * 🔍 Chi tiết đơn hàng
     */
    public function show($id)
    {
        $order = Order::with(['orderDetails.product.brand'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('frontend.order.detail', compact('order'));
    }
}
