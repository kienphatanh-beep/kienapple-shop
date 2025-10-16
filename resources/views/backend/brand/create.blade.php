<x-admin-site>
    <x-slot:title>Thêm Thương Hiệu</x-slot:title>

    <div class="border p-4 rounded-lg bg-white dark:bg-gray-800 shadow-lg max-w-3xl mx-auto mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-600 dark:text-blue-400">➕ Thêm Thương Hiệu</h2>
            <a href="{{ route('admin.brand.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg">
                ⬅ Quay lại danh sách
            </a>
        </div>

        <form action="{{ route('admin.brand.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 dark:text-gray-200">Tên thương hiệu</label>
                <input type="text" name="name" id="name" class="w-full border rounded p-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label for="slug" class="block font-medium text-gray-700 dark:text-gray-200">Slug</label>
                <input type="text" name="slug" id="slug" class="w-full border rounded p-2 mt-1">
            </div>

            <div class="mb-4">
                <label for="image" class="block font-medium text-gray-700 dark:text-gray-200">Hình ảnh</label>
                <input type="file" name="image" id="image" class="w-full border rounded p-2 mt-1">
            </div>

            <div class="mb-4">
                <label for="status" class="block font-medium text-gray-700 dark:text-gray-200">Trạng thái</label>
                <select name="status" id="status" class="w-full border rounded p-2 mt-1">
                    <option value="1">Hiển thị</option>
                    <option value="0">Ẩn</option>
                </select>
            </div>

            <div class="text-center mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    💾 Lưu Thương Hiệu
                </button>
            </div>
        </form>
    </div>
</x-admin-site>
