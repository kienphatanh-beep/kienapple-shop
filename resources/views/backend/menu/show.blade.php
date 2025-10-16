<x-admin-site>
    <x-slot:title>Chi Tiết Menu</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">📌 Thông Tin Menu</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tên Menu -->
                <div>
                    <label class="block text-gray-600 dark:text-gray-300">Tên Menu:</label>
                    <p class="text-lg font-medium text-gray-800 dark:text-white">{{ $menu->name }}</p>
                </div>

                <!-- Link Menu -->
                <div>
                    <label class="block text-gray-600 dark:text-gray-300">Link:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $menu->link }}</p>
                </div>

                <!-- Mô Tả Menu -->
                <div class="md:col-span-2">
                    <label class="block text-gray-600 dark:text-gray-300">Mô tả:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $menu->description ?? 'Không có' }}</p>
                </div>

                <!-- Trạng Thái -->
                <div>
                    <label class="block text-gray-600 dark:text-gray-300">Trạng thái:</label>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                        {{ $menu->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-300 text-gray-700' }}">
                        {{ $menu->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </div>

                <!-- Vị trí Menu -->
                <div>
                    <label class="block text-gray-600 dark:text-gray-300">Vị trí:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $menu->position }}</p>
                </div>

                <!-- Loại Menu -->
                <div>
                    <label class="block text-gray-600 dark:text-gray-300">Loại Menu:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $menu->type }}</p>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <!-- Button chỉnh sửa -->
                <a href="{{ route('menu.edit', $menu->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition shadow">
                    ✏️ Chỉnh sửa
                </a>
                <!-- Button quay lại -->
                <a href="{{ route('menu.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition shadow">
                    ⬅ Quay lại
                </a>
            </div>
        </div>
    </div>
</x-admin-site>
