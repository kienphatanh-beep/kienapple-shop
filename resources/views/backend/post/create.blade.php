<x-admin-site>
    <x-slot:title>Thêm Bài Viết</x-slot:title>

    <div class="flex justify-center mt-6">
        <form action="{{ route('admin.post.store') }}" method="POST" enctype="multipart/form-data"
              class="w-full max-w-4xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">
            @csrf

            <h2 class="text-2xl font-semibold text-blue-600 mb-6">📝 Thêm Bài Viết Mới</h2>

            {{-- Tiêu đề --}}
            <div class="mb-4">
                <label for="title" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Tiêu đề</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100"
                       placeholder="Nhập tiêu đề bài viết...">
                @error('title')
                    <div class="text-red-500 mt-1 text-sm">{{ $message }}</div>
                @enderror
            </div>

            {{-- Mô tả ngắn --}}
            <div class="mb-4">
                <label for="description" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Mô tả ngắn</label>
                <textarea name="description" id="description"
                          class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100"
                          rows="3" placeholder="Mô tả ngắn gọn về bài viết...">{{ old('description') }}</textarea>
            </div>

            {{-- Chi tiết bài viết --}}
            <div class="mb-4">
                <label for="detail" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Chi tiết bài viết</label>
                <textarea name="detail" id="detail"
                          class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100"
                          rows="6" placeholder="Nhập nội dung chi tiết...">{{ old('detail') }}</textarea>
            </div>

            {{-- Chủ đề --}}
            <div class="mb-4">
                <label for="topic_id" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Chủ đề</label>
                <select name="topic_id" id="topic_id"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
                    <option value="">-- Chọn chủ đề --</option>
                    @foreach ($list_topic as $topic)
                        <option value="{{ $topic->id }}" {{ old('topic_id') == $topic->id ? 'selected' : '' }}>
                            {{ $topic->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Ảnh đại diện --}}
            <div class="mb-4">
                <label for="thumbnail" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Ảnh đại diện</label>
                <input type="file" name="thumbnail" id="thumbnail"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
                <small class="text-gray-500 dark:text-gray-400">Chỉ chấp nhận jpg, jpeg, png. Dung lượng tối đa 2MB.</small>
            </div>

            {{-- Trạng thái --}}
            <div class="mb-4">
                <label for="status" class="block font-semibold mb-1 text-gray-700 dark:text-gray-200">Trạng thái</label>
                <select name="status" id="status"
                        class="w-full border border-gray-300 dark:border-gray-600 rounded-lg p-2 dark:bg-gray-900 dark:text-gray-100">
                    <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Xuất bản</option>
                    <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Không xuất bản</option>
                </select>
            </div>

            {{-- Nút --}}
            <div class="flex justify-between mt-6">
                <a href="{{ route('admin.post.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">
                    ⬅ Quay lại
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow transition">
                    💾 Thêm mới
                </button>
            </div>
        </form>
    </div>
</x-admin-site>
