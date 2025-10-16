<x-admin-site>
    <x-slot:title>Thương Hiệu Đã Xóa</x-slot:title>

    <div class="flex justify-end mb-4">
        <a href="{{ route('admin.brand.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
            ← Về danh sách thương hiệu
        </a>
    </div>

    <div class="border border-blue-100 rounded-lg p-4 mt-3 bg-white dark:bg-gray-800">
        <table class="w-full border-collapse border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                <tr>
                    <th class="border p-2">ID</th>
                    <th class="border p-2">Hình</th>
                    <th class="border p-2">Tên thương hiệu</th>
                    <th class="border p-2">Trạng thái</th>
                    <th class="border p-2">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list as $brand)
                    <tr>
                        <td class="border p-2 text-center">{{ $brand->id }}</td>
                        <td class="border p-2 text-center">
                            @if ($brand->image)
                                <img src="{{ asset('assets/images/brand/' . $brand->image) }}" class="w-16 h-12 object-contain mx-auto">
                            @else
                                <span class="text-gray-400 italic">Không có hình</span>
                            @endif
                        </td>
                        <td class="border p-2">{{ $brand->name }}</td>
                        <td class="border p-2 text-center">
                            {{ $brand->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                        </td>
                        <td class="border p-2 text-center">
                            <a href="{{ route('admin.brand.restore', $brand->id) }}" class="text-blue-500 hover:underline mx-2">♻ Khôi phục</a>
                            <form action="{{ route('admin.brand.destroy', $brand->id) }}" method="POST" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Xóa vĩnh viễn?')" class="text-red-600 hover:underline mx-2">
                                    ❌ Xóa vĩnh viễn
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-gray-500 p-4">Không có thương hiệu nào trong thùng rác.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $list->links() }}</div>
    </div>
</x-admin-site>
