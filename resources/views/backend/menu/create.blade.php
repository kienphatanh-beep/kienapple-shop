<x-admin-site>
    <x-slot:title>Thêm Menu</x-slot:title>

    <!-- Hiển thị lỗi tổng quát (nếu có) -->
    @if($errors->any())
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow">
        <h1 class="text-lg font-bold">Thêm Menu</h1>
    </div>

    <!-- Form -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <form action="{{ route('menu.store') }}" method="POST">
            @csrf

            <!-- Tên menu -->
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Tên Menu</label>
                <input type="text" name="name" id="name" required autocomplete="off"
                       class="w-full border border-gray-300 rounded-lg p-2"
                       value="{{ old('name') }}" placeholder="Nhập tên menu">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Link menu -->
            <div class="mb-4">
                <label for="link" class="block font-semibold mb-1">Liên kết (Link)</label>
                <input type="text" name="link" id="link" required autocomplete="off"
                       class="w-full border border-gray-300 rounded-lg p-2"
                       value="{{ old('link', '#') }}" placeholder="Nhập liên kết">
                @error('link')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Menu cha -->
            <div class="mb-4">
                <label for="parent_id" class="block font-semibold mb-1">Menu Cha</label>
                <select name="parent_id" id="parent_id" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="0">-- Không có --</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}" {{ old('parent_id') == $menu->id ? 'selected' : '' }}>
                            {{ str_repeat('--', $menu->level ?? 0) . ' ' . $menu->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Vị trí -->
            <div class="mb-4">
                <label for="position" class="block font-semibold mb-1">Vị trí hiển thị</label>
                <select name="position" id="position" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="mainmenu" {{ old('position') == 'mainmenu' ? 'selected' : '' }}>Menu chính</option>
                    <option value="footer" {{ old('position') == 'footer' ? 'selected' : '' }}>Footer</option>
                </select>
                @error('position')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Loại menu -->
            <div class="mb-4">
                <label for="type" class="block font-semibold mb-1">Loại Menu</label>
                <select name="type" id="type" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="">-- Chọn loại menu --</option>
                    @foreach($menuTypes as $key => $value)
                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                    @endforeach
                </select>
                @error('type')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Trạng thái -->
            <div class="mb-4">
                <label for="status" class="block font-semibold mb-1">Trạng thái</label>
                <select name="status" id="status" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                </select>
                @error('status')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nút hành động -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('menu.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                    Quay lại
                </a>
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
                    Thêm mới
                </button>
            </div>
        </form>
    </div>
</x-admin-site>
