<x-admin-site>
    <x-slot:title>Chỉnh Sửa Thương Hiệu</x-slot:title>

    <div class="border p-4 rounded-lg bg-white dark:bg-gray-800 shadow-lg max-w-3xl mx-auto mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold text-blue-600 dark:text-blue-400">✏️ Chỉnh Sửa Thương Hiệu</h2>
            <a href="{{ route('admin.brand.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-3 py-2 rounded-lg">
                ⬅ Quay lại
            </a>
        </div>

        <form action="{{ route('admin.brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700 dark:text-gray-200">Tên thương hiệu</label>
                <input type="text" name="name" value="{{ $brand->name }}" class="w-full border rounded p-2 mt-1">
            </div>

            <div class="mb-4">
                <label for="slug" class="block font-medium text-gray-700 dark:text-gray-200">Slug</label>
                <input type="text" name="slug" value="{{ $brand->slug }}" class="w-full border rounded p-2 mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Hình ảnh hiện tại</label>
                @if ($brand->image)
                    <img src="{{ asset('assets/images/brand/' . $brand->image) }}" class="w-32 my-2 rounded border">
                @endif
                <input type="file" name="image" class="w-full border rounded p-2 mt-1">
            </div>

            <div class="mb-4">
                <label for="status" class="block font-medium text-gray-700 dark:text-gray-200">Trạng thái</label>
                <select name="status" class="w-full border rounded p-2 mt-1">
                    <option value="1" {{ $brand->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $brand->status == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>

            <div class="text-center mt-6">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
                    💾 Cập Nhật
                </button>
            </div>
        </form>
    </div>
</x-admin-site>
