<x-admin-site>
    <x-slot:title>Thùng rác chủ đề</x-slot:title>

    <div class="content-wrapper">
        <div class="p-4 border border-gray-300 rounded">
            <h2 class="text-xl font-bold text-red-600 mb-4">Thùng rác</h2>

            <table class="w-full table-auto border border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border p-2">ID</th>
                        <th class="border p-2">Tên</th>
                        <th class="border p-2">Slug</th>
                        <th class="border p-2">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($list as $topic)
                        <tr>
                            <td class="border p-2">{{ $topic->id }}</td>
                            <td class="border p-2">{{ $topic->name }}</td>
                            <td class="border p-2">{{ $topic->slug }}</td>
                            <td class="border p-2 space-x-2">
                                <!-- Khôi phục chủ đề -->
                                <a href="{{ route('topic.restore', $topic->id) }}"
                                   class="bg-green-500 text-white px-2 py-1 rounded">Khôi phục</a>

                                <!-- Xóa vĩnh viễn chủ đề -->
                                <form action="{{ route('topic.forceDelete', $topic->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Xóa vĩnh viễn?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 text-white px-2 py-1 rounded">Xóa vĩnh viễn</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $list->links() }}
            </div>

            <div class="mt-4">
                <a href="{{ route('topic.index') }}" class="text-blue-600 underline">Quay lại danh sách</a>
            </div>
        </div>
    </div>
</x-admin-site>
