<?php
namespace App\View\Components;

use Illuminate\View\Component;

class LayoutUser extends Component
{
    public function __construct()
    {
        // Không xử lý menu ở đây nữa
    }

    public function render()
    {
        return view('components.layout-user');
    }
}
