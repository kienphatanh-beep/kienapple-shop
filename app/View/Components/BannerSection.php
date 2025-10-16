<?php

namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Banner;

class BannerSection extends Component
{
    public $sliders;
    public $ads;

    public function __construct()
    {
        // Lấy các banner SlideShow từ database
        $this->sliders = Banner::where('position', 'slideshow')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'image', 'position', 'sort_order']);

        // Lấy các banner Quảng Cáo từ database
        $this->ads = Banner::where('position', 'ads')
            ->where('status', 1)
            ->orderBy('sort_order', 'asc')
            ->get(['id', 'name', 'image', 'position', 'sort_order']);
    }

    public function render()
    {
        return view('components.banner-section');
    }
}
