<x-admin-site>
    <x-slot:title>Thêm Danh Mục</x-slot:title>

    <div class="content-wrapper">
        <div class="border border-blue-100 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-blue-600">➕ Thêm Danh Mục</h2>
                <div class="text-right">
                    <a href="{{ route('admin.category.index') }}" class="bg-sky-500 px-3 py-2 rounded-xl text-white hover:bg-sky-600">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>
        </div>

        <div class="border border-blue-100 rounded-lg p-2 mt-3">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <ul class="list-disc ml-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.category.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold">Tên Danh Mục</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full mt-1 p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug') }}" class="w-full mt-1 p-2 border rounded">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold">Trạng thái</label>
                        <select name="status" class="w-full mt-1 p-2 border rounded">
                            <option value="1" selected>Kích hoạt</option>
                            <option value="0">Tạm dừng</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold">Hình ảnh</label>
                        <input type="file" name="image" class="w-full mt-1 p-2 border rounded">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold">Mô tả</label>
                        <textarea name="description" rows="4" class="w-full mt-1 p-2 border rounded">{{ old('description') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold">Danh mục cha</label>
                        <select name="parent_id" class="w-full mt-1 p-2 border rounded">
                            <option value="0">Không có</option>
                            @foreach($list_category as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold">Thứ tự</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" class="w-full mt-1 p-2 border rounded">
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="bg-green-500 px-6 py-2 rounded-xl text-white hover:bg-green-600">
                        💾 Thêm Danh Mục
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-site>
