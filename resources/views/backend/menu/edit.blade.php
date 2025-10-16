<x-admin-site>
    <x-slot:title>Chỉnh sửa Menu</x-slot:title>

    <!-- Header -->
    <div class="flex justify-between items-center bg-white p-4 rounded-lg shadow">
        <h1 class="text-lg font-bold">Chỉnh sửa Menu</h1>
    </div>

    <!-- Form -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        @if (session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('menu.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Tên menu -->
            <div class="mb-4">
                <label for="name" class="block font-semibold mb-1">Tên Menu</label>
                <input type="text" name="name" id="name"
                       class="w-full border border-gray-300 rounded-lg p-2"
                       value="{{ old('name', $menu->name) }}" placeholder="Nhập tên menu">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Link -->
            <div class="mb-4">
                <label for="link" class="block font-semibold mb-1">Liên kết (Link)</label>
                <input type="text" name="link" id="link"
                       class="w-full border border-gray-300 rounded-lg p-2"
                       value="{{ old('link', $menu->link) }}" placeholder="Nhập liên kết">
                @error('link')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Menu cha -->
            <div class="mb-4">
                <label for="parent_id" class="block font-semibold mb-1">Menu Cha</label>
                <select name="parent_id" id="parent_id" class="w-full border border-gray-300 rounded-lg p-2">
                    <option value="0">-- Không có --</option>
                    @foreach($menus as $m)
                        <option value="{{ $m->id }}" {{ old('parent_id', $menu->parent_id) == $m->id ? 'selected' : '' }}>
                            {{ $m->name }}
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
                    <option value="mainmenu" {{ old('position', $menu->position) == 'mainmenu' ? 'selected' : '' }}>Menu chính</option>
                    <option value="footer" {{ old('position', $menu->position) == 'footer' ? 'selected' : '' }}>Footer</option>
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
                        <option value="{{ $key }}" {{ old('type', $menu->type) == $key ? 'selected' : '' }}>
                            {{ $value }}
                        </option>
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
                    <option value="1" {{ old('status', $menu->status) == 1 ? 'selected' : '' }}>Hiển thị</option>
                    <option value="0" {{ old('status', $menu->status) == 0 ? 'selected' : '' }}>Ẩn</option>
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
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</x-admin-site>
