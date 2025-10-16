<x-admin-site>
    <x-slot:title>Danh Sách Đơn Hàng</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-300 dark:border-gray-700">

            <!-- Nút Xem Thùng Rác -->
            <div class="flex justify-end gap-3 mb-6">
                <a href="{{ route('admin.order.trash') }}"
                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition duration-200 focus:outline-none focus:ring-2 focus:ring-red-400">
                    🗑 Xem Đơn Đã Xóa
                </a>
            </div>

            <!-- Bảng -->
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto text-sm text-center text-gray-700 dark:text-gray-300 border-separate border-spacing-y-2">
                    <thead class="text-xs uppercase bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-4 py-2">ID</th>
                            <th class="px-4 py-2">Khách Hàng</th>
                            <th class="px-4 py-2">Email</th>
                            <th class="px-4 py-2">Điện Thoại</th>
                            <th class="px-4 py-2">Địa Chỉ</th>
                            <th class="px-4 py-2">Trạng Thái</th>
                            <th class="px-4 py-2">Ngày Tạo</th>
                            <th class="px-4 py-2">Hành Động</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($list as $order)
                            @php
                                $statusLabels = [
                                    0 => ['⏳ Chờ xác nhận', 'bg-yellow-500'],
                                    1 => ['✅ Đã xác nhận', 'bg-blue-500'],
                                    2 => ['🚚 Đang giao hàng', 'bg-purple-500'],
                                    3 => ['📦 Đã giao hàng', 'bg-green-600'],
                                ];
                                [$label, $color] = $statusLabels[$order->status] ?? ['❓ Không xác định', 'bg-gray-500'];
                            @endphp

                            <tr class="bg-white dark:bg-gray-900 hover:bg-gray-100 dark:hover:bg-gray-700 rounded shadow transition">
                                <td class="px-4 py-3 font-semibold">{{ $order->id }}</td>
                                <td class="px-4 py-3">{{ $order->name }}</td>
                                <td class="px-4 py-3">{{ $order->email }}</td>
                                <td class="px-4 py-3">{{ $order->phone }}</td>
                                <td class="px-4 py-3">{{ $order->address }}</td>

                                <!-- Dropdown Trạng Thái -->
                                <td class="px-4 py-3 relative" x-data="{ open: false }">
                                    <button @click="open = !open"
                                        class="px-3 py-1 text-sm text-white font-semibold rounded {{ $color }} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-300">
                                        {{ $label }}
                                        <i class="fa-solid fa-chevron-down ml-1 text-xs"></i>
                                    </button>

                                    <div x-show="open" @click.outside="open = false"
                                        class="absolute mt-2 right-0 w-48 bg-white shadow-lg rounded-lg border border-gray-200 z-50">
                                        @foreach ($statusLabels as $key => [$labelText, $bg])
                                            <form action="{{ route('admin.order.status', $order->id) }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="status" value="{{ $key }}">
                                                <button type="submit"
                                                    class="w-full text-left px-4 py-2 text-sm hover:bg-gray-100 
                                                    {{ $order->status == $key ? 'bg-yellow-50 font-semibold text-yellow-700' : 'text-gray-700' }}">
                                                    {{ $labelText }}
                                                </button>
                                            </form>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="px-4 py-3">{{ $order->created_at->format('d/m/Y') }}</td>

                                <td class="px-4 py-3 space-x-2">
                                    <a href="{{ route('admin.order.show', $order->id) }}"
                                        class="text-blue-500 hover:underline font-medium">🔍 Chi tiết</a>

                                    <form action="{{ route('admin.order.delete', $order->id) }}" method="POST" class="inline-block"
                                        onsubmit="return confirm('Xác nhận xóa đơn hàng này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-500 hover:underline font-medium">🗑 Xóa</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Phân trang -->
            <div class="mt-6 flex justify-center">
                {{ $list->links() }}
            </div>
        </div>
    </div>

    <!-- AlpineJS -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</x-admin-site>
