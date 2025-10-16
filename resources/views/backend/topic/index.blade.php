<x-admin-site>
    <x-slot:title>Danh Sách Chủ Đề</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl transition duration-300 border border-gray-300 dark:border-gray-700">

            <!-- Nút Thêm & Xem Thùng Rác -->
            <div class="flex justify-end gap-3 mb-6">
                <a href="{{ route('topic.create') }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    + Thêm Chủ Đề
                </a>
                <a href="{{ route('topic.trash') }}"
                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                    🗑 Thùng Rác
                </a>
            </div>

            <!-- Bảng -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-center text-gray-700 dark:text-gray-300 border-separate border-spacing-y-2">
                    <thead class="text-xs uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Tên</th>
                            <th class="px-4 py-2">Slug</th>
                            <th class="px-4 py-2">Trạng Thái</th>
                            <th class="px-4 py-2">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $topic)
                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 shadow rounded">
                                <td class="px-4 py-3">{{ $topic->id }}</td>
                                <td class="px-4 py-3">{{ $topic->name }}</td>
                                <td class="px-4 py-3">{{ $topic->slug }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('topic.status', $topic->id) }}"
                                       class="text-sm px-2 py-1 rounded 
                                              {{ $topic->status ? 'bg-green-500 text-white' : 'bg-gray-300 text-black' }}">
                                        {{ $topic->status ? 'Hiển thị' : 'Ẩn' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="{{ route('topic.show', $topic->id) }}"
                                       class="bg-blue-500 text-white px-2 py-1 rounded hover:bg-blue-600 transition">Xem</a>
                                
                                    <a href="{{ route('topic.edit', $topic->id) }}"
                                       class="bg-yellow-400 text-white px-2 py-1 rounded hover:bg-yellow-500 transition">Sửa</a>
                                
                                    <form action="{{ route('topic.delete', $topic->id) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Bạn chắc chắn muốn xóa mục này?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded hover:bg-red-600 transition">
                                            Xóa
                                        </button>
                                    </form>
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="mt-6 flex justify-center">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-admin-site>
