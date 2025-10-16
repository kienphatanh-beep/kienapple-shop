<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * 📦 Danh sách đơn hàng
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sortBy', 'created_at');
        $sortType = $request->get('sortType', 'desc');

        $list = Order::with(['orderDetails.product'])
            ->orderBy($sortBy, $sortType)
            ->paginate(10);

        return view('backend.order.index', compact('list', 'sortBy', 'sortType'));
    }

    /**
     * 🧾 Hiển thị form tạo đơn hàng thủ công
     */
    public function create()
    {
        return view('backend.order.create');
    }

    /**
     * 💾 Lưu đơn hàng mới (nếu cần thêm thủ công)
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:255',
        ]);

        $order = new Order();
        $order->user_id = Auth::id() ?? 1;
        $order->name    = $request->name;
        $order->phone   = $request->phone;
        $order->email   = $request->email;
        $order->address = $request->address;
        $order->note    = $request->note;
        $order->status  = 0; // chờ xác nhận
        $order->created_by = Auth::id() ?? 1;
        $order->save();

        return redirect()->route('admin.order.index')
                         ->with('success', '✅ Đơn hàng đã được thêm thành công.');
    }

    /**
     * ✏️ Sửa đơn hàng
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        return view('backend.order.edit', compact('order'));
    }

    /**
     * 🔁 Cập nhật đơn hàng
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:255',
            'status'  => 'required|integer',
        ]);

        $order->update([
            'name'    => $request->name,
            'phone'   => $request->phone,
            'email'   => $request->email,
            'address' => $request->address,
            'note'    => $request->note,
            'status'  => $request->status,
            'updated_by' => Auth::id() ?? 1,
        ]);

        return redirect()->route('admin.order.index')
                         ->with('success', '✅ Cập nhật đơn hàng thành công.');
    }

    /**
     * 👁️ Xem chi tiết đơn hàng + sản phẩm
     */
    public function show($id)
    {
        $order = Order::with(['orderDetails.product'])->findOrFail($id);

        $orderDetails = $order->orderDetails->map(function ($detail) {
            return [
                'product_name'  => $detail->product->name ?? '[Sản phẩm đã xóa]',
                'product_image' => $detail->product->thumbnail ?? 'noimage.jpg',
                'price'         => $detail->price_buy,
                'quantity'      => $detail->qty,
                'total'         => $detail->amount,
            ];
        });

        return view('backend.order.show', compact('order', 'orderDetails'));
    }

    /**
     * 🗑️ Chuyển đơn hàng vào thùng rác (Soft Delete)
     */
    public function delete($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->route('admin.order.index')
                         ->with('success', '🗑️ Đơn hàng đã được chuyển vào thùng rác.');
    }

    /**
     * ♻️ Hiển thị danh sách đơn hàng trong thùng rác
     */
    public function trash()
    {
        $list = Order::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('backend.order.trash', compact('list'));
    }

    /**
     * 🔄 Khôi phục đơn hàng từ thùng rác
     */
    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return redirect()->route('admin.order.trash')
                         ->with('success', '♻️ Đơn hàng đã được khôi phục.');
    }

    /**
     * ❌ Xóa vĩnh viễn đơn hàng
     */
    public function destroy($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);

        if ($order->orderDetails()->exists()) {
            $order->orderDetails()->forceDelete();
        }

        $order->forceDelete();

        return redirect()->route('admin.order.trash')
                         ->with('success', '❌ Đơn hàng đã bị xóa vĩnh viễn.');
    }

    /**
     * 🔁 Cập nhật trạng thái đơn hàng (0→3)
     */
    public function status(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->has('status')) {
            $newStatus = (int) $request->input('status');
            if (!in_array($newStatus, [0, 1, 2, 3])) {
                return back()->with('error', '❌ Trạng thái không hợp lệ.');
            }

            $order->status = $newStatus;
        } else {
            $order->status = ($order->status + 1) % 4;
        }

        $order->updated_by = Auth::id() ?? 1;
        $order->updated_at = now();
        $order->save();

        return back()->with('success', '✅ Cập nhật trạng thái đơn hàng thành công.');
    }

    /**
     * 🧍‍♂️ Lịch sử đơn hàng (frontend)
     */
    public function history()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderDetails.product'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('frontend.orders.history', compact('orders'));
    }
}
