<x-admin-site>
    <x-slot:title>Chi Tiết Banner</x-slot:title>

    <div class="flex justify-center mt-6">
        <div
            class="w-full max-w-4xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-blue-600 dark:text-blue-400 mb-6">📢 Chi Tiết Banner</h2>

            @if ($banner)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-600 dark:text-gray-300">Tên Banner:</label>
                        <p class="text-lg font-medium text-gray-800 dark:text-white">{{ $banner->name }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-600 dark:text-gray-300">Vị trí hiển thị:</label>
                        <p class="text-gray-700 dark:text-gray-300">
                            {{ $banner->position === 'slideshow' ? 'Slide Show' : 'Quảng Cáo' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-gray-600 dark:text-gray-300">Thứ tự hiển thị:</label>
                        <p class="text-gray-700 dark:text-gray-300">{{ $banner->sort_order }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-600 dark:text-gray-300">Trạng thái:</label>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $banner->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-300 text-gray-700' }}">
                            {{ $banner->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-600 dark:text-gray-300 mb-2">Hình Ảnh:</label>
                        <img src="{{ asset('assets/images/banner/' . $banner->image) }}" alt="{{ $banner->name }}"
                             class="w-full max-w-md h-auto object-contain rounded-lg border border-gray-300 dark:border-gray-600 shadow">
                    </div>
                </div>
            @else
                <p class="text-red-500 mt-4">Không tìm thấy banner.</p>
            @endif

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.banner.edit', $banner->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">
                    ✏️ Sửa
                </a>
                <a href="{{ route('admin.banner.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow transition">
                    ⬅ Quay lại
                </a>
            </div>
        </div>
    </div>
</x-admin-site>
