<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class CatProduct extends Component
{
    public $categories;

    public function __construct()
    {
        $this->categories = Category::with(['products' => function ($query) {
            $query->where('status', 1)->take(2); // lấy 2 sản phẩm mỗi danh mục
        }])
        ->where('status', 1)
        ->take(4) // lấy 4 danh mục
        ->get();
    }

    public function render(): View
    {
        return view('components.cat-product');
    }
    public function children()
{
    return $this->hasMany(Category::class, 'parent_id', 'id')
                ->where('status', 1)
                ->orderBy('sort_order');
}

}
