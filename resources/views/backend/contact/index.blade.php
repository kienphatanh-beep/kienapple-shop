<x-admin-site>
    <x-slot:title>Danh Sách Liên Hệ</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl transition duration-300 border border-gray-300 dark:border-gray-700">

            <!-- Nút Thùng Rác -->
            <div class="flex justify-end mb-6">
                <a href="{{ route('contact.trash') }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    🗑 Xem Đã Xóa
                </a>
            </div>

            <!-- Thông báo -->
            @if (session('thongbao'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded">
                    {{ session('thongbao') }}
                </div>
            @endif

            <!-- Bảng -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-center text-gray-700 dark:text-gray-300 border-separate border-spacing-y-2">
                    <thead class="text-xs uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Tên</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Tiêu đề</th>
                            <th class="px-4 py-2">Trạng thái</th>
                            <th class="px-4 py-2">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 shadow rounded">
                                <td class="px-4 py-3 font-semibold">{{ $item->id }}</td>
                                <td class="px-4 py-3">{{ $item->name }}</td>
                                <td class="px-4 py-3">{{ $item->email }}</td>
                                <td class="px-4 py-3">{{ $item->title }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->reply_id == 0)
                                        <span class="px-3 py-1 text-sm font-medium text-red-600 bg-red-100 rounded-full">Chưa phản hồi</span>
                                    @else
                                        <span class="px-3 py-1 text-sm font-medium text-green-600 bg-green-100 rounded-full">Đã phản hồi</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 space-x-2">
                                    <a href="{{ route('contact.show', $item->id) }}"
                                       class="text-blue-500 hover:underline transition">Chi tiết</a>
                                    <a href="{{ route('contact.reply', $item->id) }}"
                                       class="text-indigo-500 hover:underline transition">Phản hồi</a>
                                    <form action="{{ route('contact.destroy', $item->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Bạn có chắc muốn xóa liên hệ này không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline transition">Xóa</button>
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
