<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;

class ProductSale extends Component
{
    public $products;

    public function __construct()
    {
        // Lấy danh sách sản phẩm đang giảm giá
        $query = Product::where('status', 1)
            ->where('price_sale', '>', 0)
            ->take(4);

        $products = $query->get();

        // ✅ Nếu người dùng đăng nhập, kiểm tra sản phẩm nào đã được yêu thích
        if (Auth::check()) {
            $likedIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();

            foreach ($products as $p) {
                $p->is_liked = in_array($p->id, $likedIds);
            }
        } else {
            foreach ($products as $p) {
                $p->is_liked = false;
            }
        }

        $this->products = $products;
    }

    public function render(): View|Closure|string
    {
        return view('components.product-sale');
    }
}
