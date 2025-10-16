<?php
namespace App\View\Components;

use Illuminate\View\Component;
use App\Http\Controllers\MenuController;

class MenuComponent extends Component
{
    public $menus;

    public function __construct()
    {
        $this->menus = MenuController::getMainMenus();
    }

    public function render()
    {
        return view('components.menu-component', [
            'menus' => $this->menus
        ]);
    }
}
