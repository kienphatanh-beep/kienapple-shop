<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Chia sẻ dữ liệu cho mọi view
        View::composer('*', function ($view) {
            // 🟡 Lấy danh mục sản phẩm (nếu bảng tồn tại)
            try {
                $categories = Category::where('status', 1)
                    ->orderBy('sort_order', 'asc')
                    ->get(['id', 'name', 'slug', 'parent_id']);
            } catch (\Exception $e) {
                // Nếu chưa migrate bảng -> tránh lỗi
                $categories = collect();
            }

            // 🛒 Lấy giỏ hàng từ session
            $cart = session()->get('cart', []);
            $cartCount = 0;
            foreach ($cart as $item) {
                $cartCount += isset($item['quantity']) ? (int) $item['quantity'] : 0;
            }

            // 📤 Truyền ra tất cả view
            $view->with([
                'categories' => $categories,
                'cartCount'  => $cartCount,
            ]);
        });
    }
}
