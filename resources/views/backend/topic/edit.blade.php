<x-admin-site>
    <x-slot:title>Sửa chủ đề</x-slot:title>

    <div class="content-wrapper max-w-xl mx-auto">
        <div class="p-4 border border-gray-300 rounded">
            <h2 class="text-xl font-bold text-yellow-600 mb-4">Chỉnh sửa chủ đề</h2>

            <form action="{{ route('topic.update', $topic->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="block font-semibold">Tên chủ đề</label>
                    <input type="text" name="name" value="{{ $topic->name }}" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-3">
                    <label class="block font-semibold">Trạng thái</label>
                    <select name="status" class="w-full border p-2 rounded">
                        <option value="1" {{ $topic->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                        <option value="0" {{ $topic->status == 0 ? 'selected' : '' }}>Ẩn</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block font-semibold">Mô tả</label>
                    <textarea name="description" rows="4" class="w-full border p-2 rounded">{{ $topic->description }}</textarea>
                </div>
                

                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Cập nhật</button>
                <a href="{{ route('topic.index') }}" class="ml-2 text-gray-600 underline">Hủy</a>
            </form>
        </div>
    </div>
</x-admin-site>
