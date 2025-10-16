<x-layout-user>
<div class="min-h-screen bg-gradient-to-br from-yellow-100 via-yellow-200 to-yellow-300 py-12 relative overflow-hidden">

    <!-- 🌊 Sóng vàng động -->
    <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-r from-yellow-300 via-yellow-200 to-yellow-400 animate-wave opacity-60 blur-2xl"></div>

    <div class="max-w-5xl mx-auto px-4 relative z-10 animate-fadeIn">
        <!-- 🧭 Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-yellow-900 flex items-center gap-3 animate-bounce-slow">
                🛍️ Đơn hàng của bạn
            </h1>
            <a href="{{ route('home') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl shadow-lg transition-transform hover:scale-105 hover:shadow-yellow-400/50">
                ← Quay lại trang chủ
            </a>
        </div>

        <!-- 😢 Không có đơn hàng -->
        @if($orders->isEmpty())
            <div class="bg-white p-10 rounded-2xl shadow-md text-center animate-fadeIn">
                <p class="text-yellow-900 text-lg font-medium">
                    😢 Bạn chưa có đơn hàng nào.
                </p>
                <a href="{{ route('site.product') }}"
                   class="mt-4 inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg shadow transition-all hover:scale-105">
                    Mua sắm ngay
                </a>
            </div>
        @else
            <div class="space-y-8">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl shadow-lg border border-yellow-200 overflow-hidden transform transition hover:scale-[1.02] hover:shadow-2xl duration-500 animate-slideUp">

                        <!-- 🧾 Thông tin đơn hàng -->
                        <div class="bg-yellow-100 px-6 py-3 flex items-center justify-between border-b border-yellow-200">
                            <div>
                                <h2 class="font-bold text-yellow-900 text-lg flex items-center gap-2">
                                    🧾 <span>Đơn hàng #{{ $order->id }}</span>
                                </h2>
                                <p class="text-sm text-yellow-800">
                                    Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>

                            <!-- ✅ Trạng thái -->
                            @php
                                $statusText = [
                                    0 => '⏳ Chờ xác nhận',
                                    1 => '✅ Đã xác nhận',
                                    2 => '🚚 Đang giao hàng',
                                    3 => '📦 Đã giao hàng'
                                ];
                                $statusColor = [
                                    0 => 'bg-blue-400 text-yellow-900',
                                    1 => 'bg-yellow-500 text-white',
                                    2 => 'bg-green-700 text-white',
                                    3 => 'bg-green-400 text-white'
                                ];
                            @endphp
                            <span class="px-4 py-2 rounded-xl font-semibold shadow {{ $statusColor[$order->status] ?? 'bg-gray-300 text-gray-800' }} animate-pulse-slow">
                                {{ $statusText[$order->status] ?? 'Không xác định' }}
                            </span>
                        </div>

                        <!-- 🛒 Danh sách sản phẩm -->
                        <div class="p-4 overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-yellow-50 text-yellow-900">
                                    <tr>
                                        <th class="text-left px-4 py-2">Sản phẩm</th>
                                        <th class="text-center px-4 py-2">Số lượng</th>
                                        <th class="text-right px-4 py-2">Giá</th>
                                        <th class="text-right px-4 py-2">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderDetails as $detail)
                                        <tr class="border-t hover:bg-yellow-50 transition-all duration-300">
                                            <td class="flex items-center gap-3 px-4 py-2">
                                                <img src="{{ asset('assets/images/product/' . ($detail->product->thumbnail ?? 'noimage.jpg')) }}"
                                                     class="w-12 h-12 object-cover rounded-lg border hover:scale-110 transform transition duration-300">
                                                <div>
                                                    <p class="font-semibold text-yellow-900">{{ $detail->product->name ?? '[Sản phẩm đã xóa]' }}</p>
                                                    <p class="text-xs text-gray-500">{{ $detail->product->brand->name ?? '' }}</p>
                                                </div>
                                            </td>
                                            <td class="text-center px-4 py-2">{{ $detail->qty }}</td>
                                            <td class="text-right px-4 py-2 text-yellow-800">{{ number_format($detail->price_buy, 0, ',', '.') }}đ</td>
                                            <td class="text-right px-4 py-2 font-bold text-orange-600">{{ number_format($detail->amount, 0, ',', '.') }}đ</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- 💰 Tổng cộng -->
                        <div class="bg-yellow-50 px-6 py-3 flex justify-between items-center border-t border-yellow-100">
                            @php $total = $order->orderDetails->sum('amount'); @endphp
                            <span class="text-yellow-900 font-medium">Tổng cộng:</span>
                            <span class="text-2xl font-extrabold text-orange-600 animate-amount-glow">
                                {{ number_format($total, 0, ',', '.') }}đ
                            </span>
                        </div>

                        <!-- 🔍 Xem chi tiết -->
                        <div class="px-6 py-3 flex justify-end bg-white border-t">
                            <a href="{{ route('order.show', $order->id) }}"
                               class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white px-5 py-2 rounded-xl font-semibold shadow-lg transition-transform hover:scale-105 hover:shadow-yellow-400/60">
                                🔍 Xem chi tiết
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<style>
@keyframes fadeIn { from {opacity:0;transform:translateY(15px);} to {opacity:1;transform:translateY(0);} }
@keyframes slideUp { from {opacity:0;transform:translateY(25px);} to {opacity:1;transform:translateY(0);} }
@keyframes bounceSlow {0%,100%{transform:translateY(0);}50%{transform:translateY(-4px);}}
@keyframes waveMove {0%{transform:translateX(-50%);}50%{transform:translateX(50%);}100%{transform:translateX(-50%);}}
@keyframes amountGlow {0%,100%{color:#ea580c;text-shadow:0 0 3px #ffd966;}50%{color:#f97316;text-shadow:0 0 10px #ffeb99;}}
.animate-fadeIn{animation:fadeIn .8s ease-in-out;}
.animate-slideUp{animation:slideUp .7s ease-in-out;}
.animate-bounce-slow{animation:bounceSlow 2.5s infinite ease-in-out;}
.animate-wave{animation:waveMove 12s linear infinite;}
.animate-pulse-slow{animation:pulse 2s infinite;}
.animate-amount-glow{animation:amountGlow 2s ease-in-out infinite;}
@keyframes pulse {0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.8;transform:scale(1.05);}}
</style>
</x-layout-user>
