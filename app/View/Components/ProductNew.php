<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Product;

class ProductNew extends Component
{
    public $newProducts;

    public function __construct($limit = 8)
    {
        // ✅ Lấy sản phẩm mới nhất (có trạng thái active)
        $this->newProducts = Product::where('status', 1)
            ->orderByDesc('created_at')
            ->take($limit)
            ->get();
    }

    public function render()
    {
        return view('components.product-new');
    }
}
