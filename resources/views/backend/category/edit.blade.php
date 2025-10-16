<x-admin-site>
    <x-slot:title>Chỉnh Sửa Danh Mục</x-slot:title>

    <div class="content-wrapper">
        <div class="border border-blue-100 rounded-lg p-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-blue-600">✏️ Chỉnh sửa danh mục</h2>
                <a href="{{ route('admin.category.index') }}" class="bg-gray-500 text-white px-3 py-2 rounded hover:bg-gray-600">
                    ⬅ Quay lại
                </a>
            </div>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-semibold mb-1">Tên danh mục</label>
                        <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Trạng thái</label>
                        <select name="status" class="w-full p-2 border rounded">
                            <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                            <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Tạm dừng</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Thứ tự</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="w-full p-2 border rounded">
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Danh mục cha</label>
                        <select name="parent_id" class="w-full p-2 border rounded">
                            <option value="0">-- Không có --</option>
                            @foreach($list_parent as $item)
                                <option value="{{ $item->id }}" {{ $category->parent_id == $item->id ? 'selected' : '' }}>
                                    {{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block font-semibold mb-1">Hình ảnh</label>
                        @if ($category->image)
                            <img src="{{ asset('assets/images/category/' . $category->image) }}" class="w-32 h-auto mb-2 rounded shadow">
                        @endif
                        <input type="file" name="image" class="w-full p-2 border rounded">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block font-semibold mb-1">Mô tả</label>
                        <textarea name="description" rows="4" class="w-full p-2 border rounded">{{ old('description', $category->description) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-xl hover:bg-green-600">
                        💾 Cập nhật danh mục
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-site>
