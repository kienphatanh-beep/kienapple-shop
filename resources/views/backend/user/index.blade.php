<x-admin-site>
    <x-slot:title>Danh Sách Người Dùng (Admin)</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border">
            
            <div class="flex justify-end gap-3 mb-6">
                <a href="{{ route('admin.user.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg shadow">
                    + Thêm Người Dùng
                </a>
                <a href="{{ route('admin.user.trash') }}" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow">
                    🗑 Thùng Rác
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-center border border-gray-300 dark:border-gray-600">
                    <thead class="bg-gray-200 dark:bg-gray-700">
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Email</th>
                            <th>Vai Trò</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $user)
                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <td class="py-2">
                                    <img src="{{ asset('assets/images/user/' . ($user->avatar ?: 'default-avatar.jpg')) }}"
                                         class="w-10 h-10 rounded-full mx-auto object-cover">
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ ucfirst($user->roles) }}</td>
                                <td>
                                    <form action="{{ route('admin.user.status', $user->id) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 text-white rounded {{ $user->status ? 'bg-green-600' : 'bg-gray-500' }}">
                                            {{ $user->status ? 'Hoạt động' : 'Tạm dừng' }}
                                        </button>
                                    </form>
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="space-x-2">
                                    <a href="{{ route('admin.user.show', $user->id) }}" class="text-green-500 hover:underline">Xem</a>
                                    <a href="{{ route('admin.user.edit', $user->id) }}" class="text-blue-500 hover:underline">Sửa</a>
                                    <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc muốn xóa?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 hover:underline">Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-center">
                {{ $list->links() }}
            </div>
        </div>
    </div>
</x-admin-site>
