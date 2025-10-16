<x-admin-site>
    <x-slot:title>Danh Sách Banner</x-slot:title>

    <div class="flex justify-center mt-6">
        <div
            class="w-full max-w-6xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-blue-600 dark:text-blue-400">📢 Danh Sách Banner</h2>
                <div class="flex gap-2">
                    <a href="{{ route('admin.banner.create') }}"
                       class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        ➕ Thêm Banner
                    </a>
                    <a href="{{ route('admin.banner.trash') }}"
                       class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition duration-200">
                        🗑️ Thùng Rác
                    </a>
                </div>
            </div>

            @if (session('thongbao'))
                <div class="bg-green-600 text-white px-4 py-2 rounded mb-4 shadow">
                    {{ session('thongbao') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table
                    class="min-w-full text-sm text-center border-separate border-spacing-y-2 text-gray-700 dark:text-gray-300">
                    <thead
                        class="uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Tên</th>
                            <th class="px-4 py-2">Hình Ảnh</th>
                            <th class="px-4 py-2">Vị Trí</th>
                            <th class="px-4 py-2">Sắp Xếp</th>
                            <th class="px-4 py-2">Trạng Thái</th>
                            <th class="px-4 py-2">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $item)
                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 rounded shadow">
                                <td class="px-4 py-2 font-semibold">{{ $item->id }}</td>
                                <td class="px-4 py-2 font-medium">{{ $item->name }}</td>
                                <td class="px-4 py-2">
                                    <img src="{{ asset('assets/images/banner/'.$item->image) }}"
                                         alt="{{ $item->name }}"
                                         class="w-28 h-16 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow">
                                </td>
                                <td class="px-4 py-2">
                                    {{ $item->position === 'slideshow' ? 'Slide Show' : 'Quảng Cáo' }}
                                </td>
                                <td class="px-4 py-2">{{ $item->sort_order }}</td>
                                <td class="px-4 py-2">
                                    <form action="{{ route('admin.banner.status', $item->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1 rounded text-white text-sm transition duration-200
                                            {{ $item->status == 1 ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-500 hover:bg-gray-600' }}">
                                            {{ $item->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.banner.show', $item->id) }}"
                                       class="text-indigo-400 hover:underline">👁 Xem</a>
                                    <a href="{{ route('admin.banner.edit', $item->id) }}"
                                       class="text-blue-400 hover:underline">✏️ Sửa</a>
                                    <form action="{{ route('admin.banner.destroy', $item->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này không?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:underline">🗑 Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-admin-site>
