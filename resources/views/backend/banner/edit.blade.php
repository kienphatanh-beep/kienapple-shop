<x-admin-site>
    <x-slot:title>Cập Nhật Banner</x-slot:title>

    <div class="flex justify-center mt-6">
        <form action="{{ route('admin.banner.update', $banner->id) }}" method="POST" enctype="multipart/form-data"
              class="w-full max-w-3xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">
            @csrf
            @method('PUT')

            <h2 class="text-2xl font-semibold text-blue-600 dark:text-blue-400 mb-6">✏️ Cập Nhật Banner</h2>

            {{-- Tên banner --}}
            <div class="mb-4">
                <label for="name" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Tên Banner</label>
                <input type="text" name="name" id="name" value="{{ old('name', $banner->name) }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
            </div>

            {{-- Ảnh hiện tại --}}
            @if($banner->image)
                <div class="mb-4">
                    <label class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Ảnh hiện tại</label>
                    <img src="{{ asset('assets/images/banner/' . $banner->image) }}" alt="{{ $banner->name }}"
                         class="w-40 h-24 object-cover rounded-lg border border-gray-300 dark:border-gray-600 shadow mb-2">
                </div>
            @endif

            {{-- Ảnh mới --}}
            <div class="mb-4">
                <label for="image" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Thay ảnh mới (nếu có)</label>
                <input type="file" name="image" id="image"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
            </div>

            {{-- Thứ tự --}}
            <div class="mb-4">
                <label for="sort_order" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Thứ tự hiển thị</label>
                <input type="number" name="sort_order" id="sort_order"
                       value="{{ old('sort_order', $banner->sort_order) }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
            </div>

            {{-- Vị trí --}}
            <div class="mb-4">
                <label for="position" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Vị trí hiển thị</label>
                <select name="position" id="position"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
                    <option value="slideshow" {{ $banner->position == 'slideshow' ? 'selected' : '' }}>Slide Show</option>
                    <option value="ads" {{ $banner->position == 'ads' ? 'selected' : '' }}>Quảng Cáo</option>
                </select>
            </div>

            {{-- Trạng thái --}}
            <div class="mb-6">
                <label for="status" class="block font-semibold text-gray-700 dark:text-gray-200 mb-1">Trạng thái</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
                    <option value="1" {{ $banner->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ $banner->status == 0 ? 'selected' : '' }}>Ẩn</option>
                </select>
            </div>

            {{-- Nút --}}
            <div class="flex justify-between">
                <a href="{{ route('admin.banner.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">⬅ Quay lại</a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition">💾 Cập nhật</button>
            </div>
        </form>
    </div>
</x-admin-site>
