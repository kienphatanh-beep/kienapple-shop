<x-admin-site>
    <x-slot:title>Danh Mục Đã Xóa</x-slot:title>

    <div class="content-wrapper">
        <div class="border border-blue-100 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-red-600">🗑 Thùng Rác Danh Mục</h2>
                <a href="{{ route('admin.category.index') }}" class="bg-gray-500 px-3 py-2 rounded-xl text-white hover:bg-gray-600">
                    ⬅ Quay lại
                </a>
            </div>
        </div>

        <div class="border border-blue-100 rounded-lg p-2 mt-3">
            <table class="border-collapse border border-gray-400 w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2 w-20">ID</th>
                        <th class="border p-2">Tên danh mục</th>
                        <th class="border p-2">Slug</th>
                        <th class="border p-2">Đã xóa lúc</th>
                        <th class="border p-2">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($list as $category)
                        <tr class="text-center">
                            <td class="border p-2">{{ $category->id }}</td>
                            <td class="border p-2">{{ $category->name }}</td>
                            <td class="border p-2">{{ $category->slug }}</td>
                            <td class="border p-2">{{ $category->deleted_at }}</td>
                            <td class="border p-2">
                                <a href="{{ route('admin.category.restore', $category->id) }}" class="text-green-600 mx-1 hover:underline">♻ Khôi phục</a>
                                <form action="{{ route('admin.category.destroy', $category->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa vĩnh viễn danh mục này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">❌ Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-500 p-4">Không có danh mục nào trong thùng rác.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">{{ $list->links() }}</div>
        </div>
    </div>
</x-admin-site>
