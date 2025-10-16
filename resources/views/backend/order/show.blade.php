<x-admin-site>
    <x-slot:title>Chi Tiết Đơn Hàng #{{ $order->id }}</x-slot:title>

    <div class="flex justify-center mt-6">
        <div class="w-full max-w-6xl bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
            
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
                🧾 Chi tiết đơn hàng #{{ $order->id }}
            </h1>

            {{-- 🔹 Thông tin khách hàng --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="text-gray-600">👤 Khách hàng:</label>
                    <p class="font-semibold">{{ $order->name }}</p>
                </div>
                <div>
                    <label class="text-gray-600">📞 Điện thoại:</label>
                    <p>{{ $order->phone }}</p>
                </div>
                <div>
                    <label class="text-gray-600">📧 Email:</label>
                    <p>{{ $order->email }}</p>
                </div>
                <div>
                    <label class="text-gray-600">📍 Địa chỉ:</label>
                    <p>{{ $order->address }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="text-gray-600">📝 Ghi chú:</label>
                    <p>{{ $order->note ?? 'Không có' }}</p>
                </div>

                {{-- 🔸 Trạng thái --}}
                <div>
                    <label class="text-gray-600">📦 Trạng thái:</label>
                    @php
                        $statusColors = [
                            0 => 'bg-gray-200 text-gray-700',
                            1 => 'bg-yellow-200 text-yellow-800',
                            2 => 'bg-blue-200 text-blue-800',
                            3 => 'bg-green-200 text-green-800',
                        ];
                        $statusText = [
                            0 => '⏳ Chờ xác nhận',
                            1 => '✅ Đã xác nhận',
                            2 => '🚚 Đang giao hàng',
                            3 => '📦 Đã giao hàng',
                        ];
                    @endphp
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $statusColors[$order->status] }}">
                        {{ $statusText[$order->status] }}
                    </span>
                </div>
            </div>

            {{-- 🛍️ Danh sách sản phẩm --}}
            <h2 class="text-lg font-semibold text-gray-800 mb-3">🛒 Sản phẩm trong đơn hàng</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-separate border-spacing-y-2">
                    <thead class="bg-gray-100 text-gray-700 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-2 text-left">Tên sản phẩm</th>
                            <th class="px-4 py-2 text-center">Ảnh</th>
                            <th class="px-4 py-2 text-center">Giá</th>
                            <th class="px-4 py-2 text-center">Số lượng</th>
                            <th class="px-4 py-2 text-center">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orderDetails as $detail)
                            <tr class="bg-white dark:bg-gray-900 border border-gray-300 rounded">
                                <td class="px-4 py-3">{{ $detail['product_name'] }}</td>
                                <td class="px-4 py-3 text-center">
                                    <img src="{{ asset('assets/images/product/' . $detail['product_image']) }}"
                                         alt="{{ $detail['product_name'] }}"
                                         class="w-20 h-14 object-contain border rounded shadow">
                                </td>
                                <td class="px-4 py-3 text-center">{{ number_format($detail['price'], 0, ',', '.') }}đ</td>
                                <td class="px-4 py-3 text-center">{{ $detail['quantity'] }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-green-600">
                                    {{ number_format($detail['total'], 0, ',', '.') }}đ
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- 🔙 Nút quay lại --}}
            <div class="mt-8 flex justify-end">
                <a href="{{ route('admin.order.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg shadow flex items-center gap-2">
                    ⬅ Quay lại danh sách
                </a>
            </div>
        </div>
    </div>
</x-admin-site>
