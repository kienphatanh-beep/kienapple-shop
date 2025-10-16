<x-admin-site>
    <x-slot:title>Chi Tiết Danh Mục</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100 mb-6">📁 Thông Tin Danh Mục</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label>Tên danh mục:</label><p>{{ $category->name }}</p></div>
                <div><label>Slug:</label><p>{{ $category->slug }}</p></div>
                <div><label>Mô tả:</label><p>{{ $category->description ?? 'Không có' }}</p></div>
                <div><label>Danh mục cha:</label><p>{{ $category->parent?->name ?? 'Không có' }}</p></div>
                <div><label>Thứ tự hiển thị:</label><p>{{ $category->sort_order }}</p></div>
                <div>
                    <label>Trạng thái:</label>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        {{ $category->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-300 text-gray-700' }}">
                        {{ $category->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </div>

                <div class="md:col-span-2">
                    <label>Hình ảnh:</label>
                    <img src="{{ asset('assets/images/category/' . $category->image) }}"
                         class="w-64 h-40 object-contain rounded-lg border mt-2">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.category.edit', $category->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">✏️ Chỉnh sửa</a>
                <a href="{{ route('admin.category.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">⬅ Quay lại</a>
            </div>
        </div>
    </div>
</x-admin-site>
