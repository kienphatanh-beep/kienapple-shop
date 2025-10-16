<x-admin-site>
    <x-slot:title>Trang Quản Lý Thương Hiệu</x-slot:title>

    <div class="w-11/12 max-w-6xl mx-auto mt-6 bg-gray-800 text-white p-6 rounded-xl shadow-lg border border-gray-700">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-blue-400">🏷️ Danh Sách Thương Hiệu</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.brand.create') }}" class="bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded shadow">➕ Thêm mới</a>
                <a href="{{ route('admin.brand.trash') }}" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded shadow">🗑️ Đã xóa</a>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full text-sm text-center border border-gray-700">
                <thead class="bg-gray-700 text-gray-300 uppercase">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Hình</th>
                        <th class="px-4 py-3">Tên thương hiệu</th>
                        <th class="px-4 py-3">Trạng thái</th>
                        <th class="px-4 py-3">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $brand)
                        <tr class="bg-gray-900 hover:bg-gray-700 border-b border-gray-600">
                            <td class="px-4 py-2">{{ $brand->id }}</td>
                            <td class="px-4 py-2">
                                @if ($brand->image)
                                    <img src="{{ asset('assets/images/brand/' . $brand->image) }}" class="w-16 h-12 object-contain mx-auto border border-gray-600 rounded">
                                @else
                                    <span class="text-gray-400 italic">Không có hình</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 font-medium">{{ $brand->name }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('admin.brand.status', $brand->id) }}" method="POST">
                                    @csrf
                                    <button class="px-3 py-1 rounded text-white {{ $brand->status == 1 ? 'bg-green-600' : 'bg-gray-500' }}">
                                        {{ $brand->status == 1 ? 'Hoạt động' : 'Tạm dừng' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('admin.brand.show', $brand->id) }}" class="text-indigo-400 hover:underline">Chi tiết</a>
                                <a href="{{ route('admin.brand.edit', $brand->id) }}" class="text-yellow-400 hover:underline">Chỉnh sửa</a>
                                <form action="{{ route('admin.brand.delete', $brand->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn chắc chắn muốn xóa?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:underline">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $list->links() }}</div>
    </div>
</x-admin-site>
