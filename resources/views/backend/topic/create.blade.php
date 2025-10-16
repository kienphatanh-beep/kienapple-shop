<x-admin-site>
    <x-slot:title>Thêm chủ đề</x-slot:title>

    <div class="content-wrapper max-w-xl mx-auto">
        <div class="p-4 border border-gray-300 rounded">
            <h2 class="text-xl font-bold text-blue-600 mb-4">Thêm chủ đề mới</h2>

            <form action="{{ route('topic.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block font-semibold">Tên chủ đề</label>
                    <input type="text" name="name" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block font-semibold">Slug (tùy chọn)</label>
                    <input type="text" name="slug" class="w-full border p-2 rounded">
                </div>
                <div class="mb-3">
                    <label class="block font-semibold">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full border p-2 rounded"></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="block font-semibold">Trạng thái</label>
                    <select name="status" class="w-full border p-2 rounded">
                        <option value="1">Hiển thị</option>
                        <option value="0">Ẩn</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Thêm</button>
                <a href="{{ route('topic.index') }}" class="ml-2 text-gray-600 underline">Hủy</a>
            </form>
        </div>
    </div>
</x-admin-site>
