<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminSite extends Component
{
    public $title;
    public $header;

    public function __construct($title = null, $header = null)
    {
        $this->title  = $title;
        $this->header = $header;
    }

    public function render(): View|Closure|string
    {
        return view('components.admin-site');
    }
}
