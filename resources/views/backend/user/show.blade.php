<x-admin-site>
    <x-slot:title>Chi Tiết Người Dùng</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-4xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border">
            <h2 class="text-2xl font-semibold mb-6">👤 Thông Tin Người Dùng</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div><label>Tên:</label><p class="font-medium">{{ $user->name }}</p></div>
                <div><label>Email:</label><p>{{ $user->email }}</p></div>
                <div><label>SĐT:</label><p>{{ $user->phone }}</p></div>
                <div><label>Vai trò:</label><p>{{ ucfirst($user->roles) }}</p></div>
                <div><label>Trạng thái:</label>
                    <span class="px-3 py-1 rounded-full {{ $user->status ? 'bg-green-100 text-green-800' : 'bg-gray-200 text-gray-700' }}">
                        {{ $user->status ? 'Kích hoạt' : 'Không kích hoạt' }}
                    </span>
                </div>
                <div class="md:col-span-2">
                    <label>Ảnh đại diện:</label>
                    <img src="{{ asset('assets/images/user/' . ($user->avatar ?: 'default-avatar.jpg')) }}" class="w-40 h-40 object-cover rounded-full border mt-2">
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.user.edit', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded">✏️ Sửa</a>
                <a href="{{ route('admin.user.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">⬅ Quay lại</a>
            </div>
        </div>
    </div>
</x-admin-site>
