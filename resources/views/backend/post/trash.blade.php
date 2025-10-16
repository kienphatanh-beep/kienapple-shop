<x-admin-site>
    <x-slot:title>Thùng Rác Bài Viết</x-slot:title>

    <div class="flex justify-between items-center mt-6">
        <h2 class="text-xl font-bold text-gray-800 dark:text-gray-100">🗑 Danh Sách Bài Viết Đã Xóa</h2>
        <a href="{{ route('admin.post.index') }}"
           class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
           ⬅ Quay lại
        </a>
    </div>

    <div class="mt-6 overflow-x-auto bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">
        <table class="min-w-full text-sm text-center border-separate border-spacing-y-2">
            <thead class="bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 uppercase text-xs">
                <tr>
                    <th class="px-4 py-2">Hình ảnh</th>
                    <th class="px-4 py-2">Tiêu đề</th>
                    <th class="px-4 py-2">Slug</th>
                    <th class="px-4 py-2">Chủ đề</th>
                    <th class="px-4 py-2">Chức năng</th>
                    <th class="px-4 py-2">ID</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($list as $item)
                    <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 rounded shadow">
                        <td class="px-4 py-3">
                            <img src="{{ asset('assets/images/post/'.$item->thumbnail) }}"
                                 class="w-20 h-14 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow">
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $item->title }}</td>
                        <td class="px-4 py-3">{{ $item->slug }}</td>
                        <td class="px-4 py-3">{{ $item->topic_name }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-3">
                                <a href="{{ route('admin.post.restore', $item->id) }}"
                                   onclick="return confirm('Khôi phục bài viết này?')"
                                   class="text-green-500 hover:underline">♻️ Khôi phục</a>

                                <form action="{{ route('admin.post.forceDelete', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Xóa vĩnh viễn bài viết này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">🗑 Xóa vĩnh viễn</button>
                                </form>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $item->id }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-6 flex justify-center">
            {{ $list->links() }}
        </div>
    </div>
</x-admin-site>
