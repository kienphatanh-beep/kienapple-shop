<x-admin-site>
    <x-slot:title>Thùng Rác Banner</x-slot:title>

    <div class="flex justify-center mt-6">
        <div
            class="w-full max-w-6xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-red-500 dark:text-red-400">🗑️ Thùng Rác Banner</h2>
                <a href="{{ route('admin.banner.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow transition">
                    ⬅ Quay lại danh sách
                </a>
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
                            <th class="px-4 py-2">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $banner)
                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 rounded shadow">
                                <td class="px-4 py-2 font-semibold">{{ $banner->id }}</td>
                                <td class="px-4 py-2">{{ $banner->name }}</td>
                                <td class="px-4 py-2">
                                    <img src="{{ asset('assets/images/banner/' . $banner->image) }}"
                                         alt="{{ $banner->name }}"
                                         class="w-28 h-16 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow">
                                </td>
                                <td class="px-4 py-2">
                                    {{ $banner->position === 'slideshow' ? 'Slide Show' : 'Quảng Cáo' }}
                                </td>
                                <td class="px-4 py-2">{{ $banner->sort_order }}</td>
                                <td class="px-4 py-2 space-x-3">
                                    <form action="{{ route('admin.banner.restore', $banner->id) }}" method="GET"
                                          class="inline-block"
                                          onsubmit="return confirm('Khôi phục banner này?')">
                                        @csrf
                                        <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded shadow text-sm">
                                            ♻️ Khôi phục
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.banner.forceDelete', $banner->id) }}" method="POST"
                                          class="inline-block"
                                          onsubmit="return confirm('Xóa vĩnh viễn banner này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-sm">
                                            🗑 Xóa vĩnh viễn
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-4 py-4 text-center text-gray-500 dark:text-gray-400 italic">
                                    Không có banner nào trong thùng rác.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-admin-site>
