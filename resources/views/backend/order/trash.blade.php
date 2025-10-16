<x-admin-site>
    <x-slot:title>Thùng Rác Đơn Hàng</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            
            <h2 class="text-2xl font-bold text-red-600 mb-4">🗑️ Đơn Hàng Đã Xóa</h2>

            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-3 rounded mb-4 shadow">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-separate border-spacing-y-2 text-sm text-gray-700 dark:text-gray-300">
                    <thead class="bg-gray-100 dark:bg-gray-700 uppercase">
                        <tr>
                            <th class="px-4 py-2 text-center">ID</th>
                            <th class="px-4 py-2 text-left">Khách Hàng</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Điện Thoại</th>
                            <th class="px-4 py-2 text-center">Ngày Xóa</th>
                            <th class="px-4 py-2 text-center">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($list as $order)
                            <tr class="bg-white dark:bg-gray-900 border border-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="px-4 py-3 text-center font-semibold">{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->name }}</td>
                                <td class="px-4 py-3">{{ $order->email }}</td>
                                <td class="px-4 py-3">{{ $order->phone }}</td>
                                <td class="px-4 py-3 text-center">{{ $order->deleted_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3 text-center space-x-2">
                                    <a href="{{ route('admin.order.restore', $order->id) }}"
                                       class="inline-block bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded transition">
                                        ♻️ Khôi phục
                                    </a>

                                    <form action="{{ route('admin.order.destroy', $order->id) }}"
                                          method="POST" class="inline-block"
                                          onsubmit="return confirm('Xóa vĩnh viễn đơn hàng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded transition">
                                            🗑 Xóa hẳn
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-3">
                                    Không có đơn hàng nào trong thùng rác.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- 🔽 Phân trang --}}
            <div class="mt-6 flex justify-center">
                {{ $list->links() }}
            </div>

            {{-- 🔙 Quay lại --}}
            <div class="mt-4 text-center">
                <a href="{{ route('admin.order.index') }}" class="text-blue-500 hover:underline">
                    ← Quay lại danh sách đơn hàng
                </a>
            </div>
        </div>
    </div>
</x-admin-site>
