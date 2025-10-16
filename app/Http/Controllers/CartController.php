<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;

class CartController extends Controller
{
    // 🛒 Hiển thị giỏ hàng
    public function index()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    // 💳 Trang QR Code thanh toán
    public function qr($id)
    {
        $order = Order::findOrFail($id);
        $amount = OrderDetail::where('order_id', $order->id)->sum('amount');

        $bank = "VCB";
        $account = "9332383326";
        $name = "TRAN TRUNG KIEN";
        $desc = "Thanh toan don hang #" . $order->id;

        $vietQrUrl = "https://img.vietqr.io/image/{$bank}-{$account}-compact2.png?" . http_build_query([
            'amount' => $amount,
            'addInfo' => $desc,
            'accountName' => $name,
        ]);

        return view('cart.qr', compact('order', 'vietQrUrl', 'amount'));
    }

    // ➕ Thêm sản phẩm vào giỏ hàng
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // ❌ Kiểm tra tồn kho
        $stock = (int)($product->stock ?? 0);
        if ($stock <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm đã hết hàng, không thể thêm vào giỏ.');
        }

        $cart = session()->get('cart', []);
        $qty = max(1, (int)$request->input('quantity', 1));

        // ❌ Nếu vượt tồn kho
        if ($qty > $stock) {
            return redirect()->back()->with('error', 'Số lượng yêu cầu vượt quá tồn kho hiện có.');
        }

        // ✅ Cập nhật hoặc thêm mới
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $qty;

            // Giới hạn trong kho
            if ($cart[$product->id]['quantity'] > $stock) {
                $cart[$product->id]['quantity'] = $stock;
                return redirect()->back()->with('error', 'Đã đạt giới hạn tồn kho của sản phẩm này.');
            }
        } else {
            $cart[$product->id] = [
                'name'       => $product->name,
                'price_root' => $product->price_root ?? 0,
                'price_sale' => $product->price_sale ?? null,
                'price'      => $product->price_sale ?: ($product->price_root ?? 0),
                'quantity'   => $qty,
                'image'      => $product->thumbnail,
                'product_id' => $product->id,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng.');
    }

    // 🔄 Cập nhật số lượng giỏ hàng
    public function update(Request $request)
    {
        $id = $request->input('id');
        $quantity = (int)$request->input('quantity', 1);

        $cart = session()->get('cart', []);
        if (isset($cart[$id]) && $quantity > 0) {
            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Cập nhật giỏ hàng thành công.');
    }

    // ❌ Xoá sản phẩm khỏi giỏ
    public function remove($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng.');
    }

    // 🧾 Trang checkout
    public function checkout()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        return view('cart.checkout', compact('cart'));
    }

    // 💰 Xử lý thanh toán
public function processCheckout(Request $request)
{
    // 🟡 Lấy sản phẩm được chọn để thanh toán
    $selected = $request->input('selected_products', []);
    $cart = session()->get('cart', []);

    // Nếu có chọn sản phẩm cụ thể → lọc lại
    if (!empty($selected)) {
        $cart = array_filter($cart, function ($item) use ($selected) {
            return in_array($item['product_id'], $selected);
        });
    }

    // Nếu không chọn sản phẩm nào
    if (empty($cart)) {
        return redirect()->route('cart.index')->with('error', 'Vui lòng chọn ít nhất 1 sản phẩm để thanh toán.');
    }

    // 🧾 Validate thông tin khách hàng
    $request->validate([
        'name'    => 'required|string|max:255',
        'phone'   => 'required|string|max:20',
        'email'   => 'required|email|max:255',
        'address' => 'required|string|max:255',
    ]);

    // ✅ Tính tổng tiền các sản phẩm được chọn
    $total = collect($cart)->sum(fn($item) => ($item['price'] ?? 0) * ($item['quantity'] ?? 1));

    // ✅ Tạo đơn hàng
    $order = Order::create([
        'user_id' => Auth::id() ?? 1,
        'name'    => $request->name,
        'phone'   => $request->phone,
        'email'   => $request->email,
        'address' => $request->address,
        'note'    => $request->note,
        'total'   => $total,
        'status'  => 0,
    ]);

    // ✅ Lưu chi tiết + trừ kho
    foreach ($cart as $productId => $item) {
        OrderDetail::create([
            'order_id'   => $order->id,
            'product_id' => $productId,
            'price_buy'  => $item['price'] ?? 0,
            'qty'        => $item['quantity'] ?? 1,
            'amount'     => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
        ]);

        if ($product = Product::find($productId)) {
            $product->increment('sold', $item['quantity']);
            $product->decrement('stock', $item['quantity']);
        }
    }

    // ✅ Cập nhật session: xóa sản phẩm đã thanh toán
    $remaining = session()->get('cart', []);
    foreach ($selected as $id) {
        unset($remaining[$id]);
    }
    session()->put('cart', $remaining);

    // ✅ Chuyển hướng theo phương thức thanh toán
    return $request->payment_method === 'qr'
        ? redirect()->route('cart.qr', $order->id)
        : redirect()->route('home')->with('success', '🎉 Đặt hàng thành công! Vui lòng thanh toán khi nhận hàng.');
}

}
