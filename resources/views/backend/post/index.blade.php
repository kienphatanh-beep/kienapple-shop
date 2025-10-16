<x-admin-site>
    <x-slot:title>
        Bài Viết
    </x-slot:title>

    <div class="flex justify-center mt-6">
        <div
            class="w-full max-w-6xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl transition duration-300 border border-gray-300 dark:border-gray-700">

            <!-- Nút Thêm & Xem Thùng Rác -->
            <div class="flex justify-end gap-3 mb-6">
                <a href="{{ route('admin.post.create') }}"
                   class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-green-400">
                    + Thêm Bài Viết
                </a>
                <a href="{{ route('admin.post.trash') }}"
                   class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                    🗑 Xem Đã Xóa
                </a>
            </div>

            <!-- Bảng -->
            <div class="overflow-x-auto">
                <table
                    class="min-w-full table-auto text-sm text-center text-gray-700 dark:text-gray-300 border-separate border-spacing-y-2">
                    <thead
                        class="text-xs uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Tiêu Đề</th>
                            <th class="px-4 py-2">Slug</th>
                            <th class="px-4 py-2">Ảnh</th>
                            <th class="px-4 py-2">Chi Tiết</th>
                            <th class="px-4 py-2">Trạng Thái</th>
                            <th class="px-4 py-2">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr
                                class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 shadow rounded">
                                <td class="px-4 py-3 font-semibold">{{ $item->id }}</td>
                                <td class="px-4 py-3 font-medium text-left">{{ $item->title }}</td>
                                <td class="px-4 py-3 text-gray-500 italic">{{ $item->slug }}</td>
                                <td class="px-4 py-3">
                                    <img src="{{ asset('assets/images/post/'.$item->thumbnail) }}"
                                         class="w-16 h-10 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow"
                                         alt="{{ $item->thumbnail }}">
                                </td>
                                <td class="px-4 py-3 max-w-xs truncate text-left">{{ $item->detail }}</td>

                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.post.status', $item->id) }}" method="POST"
                                          class="inline-block">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 text-sm text-white rounded transition duration-200 focus:outline-none focus:ring-2
                                            {{ $item->status == 1 ? 'bg-green-600 hover:bg-green-700 focus:ring-green-400' : 'bg-gray-500 hover:bg-gray-600 focus:ring-gray-400' }}">
                                            {{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                        </button>
                                    </form>
                                </td>

                                <td class="px-4 py-3 space-x-2">
                                    <!-- Xem -->
                                    <a href="{{ route('admin.post.show', $item->id) }}"
                                       class="text-indigo-500 hover:underline transition duration-150">
                                        👁 Xem
                                    </a>
                                    <!-- Sửa -->
                                    <a href="{{ route('admin.post.edit', $item->id) }}"
                                       class="text-blue-500 hover:underline transition duration-150">
                                        ✏️ Sửa
                                    </a>
                                    <!-- Xóa -->
                                    <form action="{{ route('admin.post.destroy', $item->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa bài viết này không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:underline transition duration-150">
                                            🗑 Xóa
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
