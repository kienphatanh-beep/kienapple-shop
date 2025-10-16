<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu; // Đảm bảo bạn có model Menu

class MenuController extends Controller
{
    public static function getFooterMenus()
    {
        return Menu::where('position', 'footer')
                   ->where('status', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->get();
    }

    public static function getMenusByPosition($position = 'mainmenu')
    {
        return Menu::where('position', $position)
                   ->where('status', 1)
                   ->where('parent_id', 0) // chỉ lấy menu cha
                   ->with('children')
                   ->orderBy('sort_order', 'ASC')
                   ->get();
    }

    public static function getMainMenus()
    {
        return self::getMenusByPosition('mainmenu');
    }
}

