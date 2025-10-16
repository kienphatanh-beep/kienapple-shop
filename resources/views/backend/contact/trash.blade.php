<x-admin-site>
    <x-slot:title>Danh sách Thùng Rác Liên Hệ</x-slot:title>

    <div class="content-wrapper">
        <div class="mb-4">
            <a href="{{ route('contact.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Quay lại danh sách</a>
        </div>

        @if (session('thongbao'))
            <div class="bg-green-100 border border-green-400 text-green-700 p-2 rounded mb-4">
                {{ session('thongbao') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">ID</th>
                        <th class="border px-4 py-2">Tên</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Tiêu đề</th>
                        <th class="border px-4 py-2">Ngày xóa</th>
                        <th class="border px-4 py-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $item)
                        <tr>
                            <td class="border px-4 py-2">{{ $item->id }}</td>
                            <td class="border px-4 py-2">{{ $item->name }}</td>
                            <td class="border px-4 py-2">{{ $item->email }}</td>
                            <td class="border px-4 py-2">{{ $item->title }}</td>
                            <td class="border px-4 py-2">{{ $item->deleted_at->format('d-m-Y H:i:s') }}</td>
                            <td class="border px-4 py-2 space-x-2">
                                <!-- Nút khôi phục liên hệ -->
                                <form action="{{ route('contact.restore', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn khôi phục liên hệ này không?')">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:underline">Khôi phục</button>
                                </form>
                                <!-- Nút xóa vĩnh viễn -->
                                <form action="{{ route('contact.delete', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Bạn có chắc muốn xóa vĩnh viễn liên hệ này không?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Xóa vĩnh viễn</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $list->links() }}
        </div>
    </div>
</x-admin-site>
