<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use App\Http\Requests\StoreMenuRequest;
use App\Http\Requests\UpdateMenuRequest;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    private function getMenuOptions()
    {
        return [
            'menuTypes' => [
                'custom' => 'Tùy chỉnh',
                'category' => 'Danh mục',
                'brand' => 'Thương hiệu',
                'page' => 'Trang',
                'topic' => 'Chủ đề',
            ],
            'positions' => [
                'mainmenu' => 'Menu chính',
                'footer' => 'Chân trang',
            ],
        ];
    }
    public static function getFooterMenus()
    {
        return Menu::where('position', 'footer')
                   ->where('status', 1)
                   ->orderBy('sort_order', 'ASC')
                   ->get();
    }
    public function show($id)
{
    $menu = Menu::find($id);
    
    if (!$menu) {
        return redirect()->route('menu.index')->with('error', 'Không tìm thấy menu!');
    }

    return view('backend.menu.show', compact('menu'));
}

    public function index()
    {
        $list = Menu::select(
                'id', 'name', 'link', 'table_id', 'parent_id',
                'sort_order', 'type', 'position', 'status'
            )
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('backend.menu.index', compact('list'));
    }
    

    public function create()
    {
        $options = $this->getMenuOptions();
        $menus = Menu::all();

        return view('backend.menu.create', [
            'menuTypes' => $options['menuTypes'],
            'positions' => $options['positions'],
            'menus' => $menus
        ]);
    }

    public function store(StoreMenuRequest $request)
    {
        $menu = new Menu();
        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->table_id = $request->table_id ?? 0;
        $menu->parent_id = $request->parent_id ?? 0;
        $menu->sort_order = $request->sort_order ?? 0;
        $menu->type = $request->type ?? 'custom';
        $menu->position = $request->position ?? 'mainmenu';
        $menu->status = $request->status ?? 0;
        $menu->created_by = Auth::id() ?? 1;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->created_at = now();
        $menu->updated_at = now();
        $menu->save();

        return redirect()->route('menu.index')->with('thongbao', 'Thêm menu thành công');
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        $options = $this->getMenuOptions();
        $menus = Menu::where('id', '!=', $id)->get();

        return view('backend.menu.edit', [
            'menu' => $menu,
            'menuTypes' => $options['menuTypes'],
            'positions' => $options['positions'],
            'menus' => $menus
        ]);
    }

    public function update(UpdateMenuRequest $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->route('menu.index')->with('error', 'Không tìm thấy menu!');
        }

        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->table_id = $request->table_id ?? 0;
        $menu->parent_id = $request->parent_id ?? 0;
        $menu->sort_order = $request->sort_order ?? 0;
        $menu->type = $request->type ?? 'custom';
        $menu->fill($request->only([
            'name', 'link', 'table_id', 'parent_id', 'sort_order',
            'type', 'position', 'status'
        ]));
    
        
        $menu->status = $request->status ?? 0;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->updated_at = now();
        $menu->save();

        return redirect()->route('menu.index')->with('success', 'Cập nhật menu thành công');
    }

    public function trash()
    {
        $list = Menu::select(
                'id', 'name', 'link', 'table_id', 'parent_id',
                'sort_order', 'type', 'position', 'status'
            )
            ->orderBy('created_at', 'desc')
            ->onlyTrashed()
            ->paginate(5);

        return view('backend.menu.trash', compact('list'));
    }

    public function delete($id)
    {
        $menu = Menu::find($id);
        $menu->delete(); // Soft delete
        return redirect()->route('menu.index');
    }

    public function restore($id)
    {
        $menu = Menu::onlyTrashed()->find($id);
        $menu->restore();
        return redirect()->route('menu.trash');
    }

    public function destroy($id)
    {
        $menu = Menu::onlyTrashed()->find($id);
        $menu->forceDelete(); // Xóa vĩnh viễn
        return redirect()->route('menu.trash');
    }

    public function status($id)
    {
        $menu = Menu::find($id);
        $menu->status = ($menu->status == 1) ? 0 : 1;
        $menu->updated_by = Auth::id() ?? 1;
        $menu->updated_at = now();
        $menu->save();

        return redirect()->route('menu.index');
    }
}
