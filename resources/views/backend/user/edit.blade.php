<x-admin-site>
    <x-slot:title>Chỉnh Sửa Người Dùng</x-slot:title>

    <h2 class="text-xl font-bold mb-4 text-yellow-600">Chỉnh Sửa Người Dùng</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.user.update', $user->id) }}" method="POST" class="space-y-4" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label class="block font-medium">Tên:</label>
            <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ old('name', $user->name) }}" required>
        </div>

        <div>
            <label class="block font-medium">Email:</label>
            <input type="email" name="email" class="w-full border rounded px-3 py-2" value="{{ old('email', $user->email) }}" required>
        </div>

        <div>
            <label class="block font-medium">Số điện thoại:</label>
            <input type="text" name="phone" class="w-full border rounded px-3 py-2" value="{{ old('phone', $user->phone) }}">
        </div>

        <div>
            <label class="block font-medium">Mật khẩu mới (nếu thay đổi):</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block font-medium">Vai trò:</label>
            <select name="roles" class="w-full border rounded px-3 py-2" required>
                <option value="admin" {{ $user->roles == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="customer" {{ $user->roles == 'customer' ? 'selected' : '' }}>Customer</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Trạng thái:</label>
            <select name="status" class="w-full border rounded px-3 py-2" required>
                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Kích hoạt</option>
                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Không kích hoạt</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Ảnh đại diện:</label>
            @if ($user->avatar)
                <img src="{{ asset('assets/images/user/' . $user->avatar) }}" alt="Avatar" class="w-24 h-24 rounded-full mb-2 border">
            @endif
            <input type="file" name="avatar" class="w-full border rounded px-3 py-2">
        </div>

        <div class="text-center">
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
                💾 Cập nhật
            </button>
        </div>
    </form>
</x-admin-site>
