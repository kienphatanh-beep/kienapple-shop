<x-admin-site>
    <x-slot:title>Thùng Rác Menu</x-slot:title>

    <div class="content-wrapper">
        <div class="p-4 border border-gray-300 rounded">
            <h2 class="text-xl font-bold text-blue-600 mb-4">Thùng Rác Menu</h2>

            @if (session('thongbao'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                    {{ session('thongbao') }}
                </div>
            @endif

            <table class="w-full table-auto border border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Tên</th>
                        <th class="border p-2">Liên kết</th>
                        <th class="border p-2">Vị trí</th>
                        <th class="border p-2">Trạng thái</th>
                        <th class="border p-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $menu)
                        <tr>
                            <td class="border p-2">{{ $menu->id }}</td>
                            <td class="border p-2">{{ $menu->name }}</td>
                            <td class="border p-2">{{ $menu->link }}</td>
                            <td class="border p-2">{{ $menu->position }}</td>
                            <td class="border p-2">
                                @if ($menu->status == 1)
                                    <span class="text-green-600 font-semibold">Hiển thị</span>
                                @else
                                    <span class="text-red-600 font-semibold">Ẩn</span>
                                @endif
                            </td>
                            <td class="border p-2 space-x-2">
                                <a href="{{ route('menu.restore', $menu->id) }}" class="bg-blue-500 text-white px-2 py-1 rounded">Khôi phục</a>
                                <form action="{{ route('menu.forceDelete', $menu->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa vĩnh viễn mục này?')">

                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        <i class="fa fa-trash"></i> Xóa vĩnh viễn
                                    </button>
                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-admin-site>
