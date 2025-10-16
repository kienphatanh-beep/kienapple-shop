<x-admin-site>
    <x-slot:title>Thùng Rác Người Dùng</x-slot:title>

    <div class="border p-4 bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="flex justify-between mb-4">
            <h2 class="text-xl font-bold text-red-600">🗑 Thùng Rác Người Dùng</h2>
            <a href="{{ route('admin.user.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                ← Quay lại danh sách
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <table class="w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Tên</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">Vai trò</th>
                    <th class="p-2 border">Thời gian xoá</th>
                    <th class="p-2 border">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($list as $user)
                    <tr class="text-center">
                        <td class="border p-2">{{ $user->id }}</td>
                        <td class="border p-2">{{ $user->name }}</td>
                        <td class="border p-2">{{ $user->email }}</td>
                        <td class="border p-2">{{ ucfirst($user->roles) }}</td>
                        <td class="border p-2">{{ $user->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="border p-2">
                            <a href="{{ route('admin.user.restore', $user->id) }}" class="text-blue-500 hover:underline mx-2">♻ Khôi phục</a>
                            <form action="{{ route('admin.user.delete', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Xóa vĩnh viễn?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">❌ Xóa vĩnh viễn</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-gray-500 p-4">Không có người dùng nào trong thùng rác.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $list->links() }}</div>
    </div>
</x-admin-site>
