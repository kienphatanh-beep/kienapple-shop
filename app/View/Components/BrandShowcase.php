<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Banner;
use App\Models\Brand;

class BrandShowcase extends Component
{
    public $banner;
    public $brands;
    public $ads;

    public function __construct()
    {
        // Banner chính của Shopee Mall
        $this->banner = Banner::where('position', 'mall')
            ->where('status', 1)
            ->latest()
            ->first();

        // ✅ Danh sách thương hiệu (thêm slug)
        $this->brands = Brand::where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->take(10)
            ->get(['id', 'name', 'slug', 'image', 'description']);

        // 🟡 Ảnh quảng cáo
        $this->ads = Banner::where('position', 'ads')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->first(['id', 'name', 'image', 'position', 'sort_order']);
    }

    public function render()
    {
        return view('components.brand-showcase');
    }
}
