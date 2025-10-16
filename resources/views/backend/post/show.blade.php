<x-admin-site>
    <x-slot:title>Chi Tiết Bài Viết</x-slot:title>

    <div class="flex justify-center mt-6">
        <div
            class="w-full max-w-4xl bg-white dark:bg-gray-800 bg-opacity-30 backdrop-blur-sm p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">
            <h2 class="text-2xl font-semibold text-blue-600 mb-6">📄 Thông Tin Bài Viết</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="text-gray-500 dark:text-gray-300">Tiêu đề:</label>
                    <p class="font-medium text-gray-800 dark:text-white">{{ $post->title }}</p>
                </div>

                <div>
                    <label class="text-gray-500 dark:text-gray-300">Slug:</label>
                    <p class="text-gray-600 dark:text-gray-300">{{ $post->slug }}</p>
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-500 dark:text-gray-300">Mô tả:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $post->description ?? 'Không có' }}</p>
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-500 dark:text-gray-300">Chi tiết:</label>
                    <div class="prose dark:prose-invert max-w-none">{!! $post->detail !!}</div>
                </div>

                <div>
                    <label class="text-gray-500 dark:text-gray-300">Chủ đề:</label>
                    <p class="text-gray-700 dark:text-gray-300">{{ $post->topic->name ?? 'Không có' }}</p>
                </div>

                <div>
                    <label class="text-gray-500 dark:text-gray-300">Trạng thái:</label>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $post->status == 1 ? 'bg-green-100 text-green-800' : 'bg-gray-400 text-gray-800' }}">
                        {{ $post->status == 1 ? 'Hiển thị' : 'Ẩn' }}
                    </span>
                </div>

                <div class="md:col-span-2">
                    <label class="text-gray-500 dark:text-gray-300">Hình ảnh:</label>
                    <img src="{{ asset('assets/images/post/' . $post->thumbnail) }}"
                         class="w-full max-w-md rounded-lg border border-gray-300 dark:border-gray-600 shadow mt-2"
                         alt="{{ $post->title }}">
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.post.edit', $post->id) }}"
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow transition">✏️ Chỉnh sửa</a>
                <a href="{{ route('admin.post.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg shadow transition">⬅ Quay lại</a>
            </div>
        </div>
    </div>
</x-admin-site>
