<x-layout-user>
<div class="min-h-screen bg-gradient-to-br from-yellow-100 via-yellow-200 to-yellow-300 py-12 relative overflow-hidden">

    <!-- 🌊 Sóng vàng -->
    <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-r from-yellow-300 via-yellow-200 to-yellow-400 animate-wave opacity-60 blur-2xl"></div>

    <div class="max-w-5xl mx-auto px-4 relative z-10 animate-fadeIn">

        <!-- 🧾 Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-yellow-900 flex items-center gap-2">
                🧾 Chi tiết đơn hàng #{{ $order->id }}
            </h1>
            <a href="{{ route('orders.history') }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-xl shadow transition-transform hover:scale-105 hover:shadow-yellow-400/60">
                ← Quay lại danh sách
            </a>
        </div>

        <!-- 🧭 Tiến trình đơn hàng -->
        @php
            $steps = [
                ['icon' => 'fa-file-alt', 'label' => 'Chờ xác nhận'],
                ['icon' => 'fa-dollar-sign', 'label' => 'Đã xác nhận'],
                ['icon' => 'fa-truck', 'label' => 'Đang giao hàng'],
                ['icon' => 'fa-box-open', 'label' => 'Đã giao hàng'],
                ['icon' => 'fa-star', 'label' => 'Đánh Giá'],
            ];
            $currentStep = min($order->status ?? 0, 3);
$hasReviewed = $order->orderDetails->pluck('product')
    ->filter()
    ->some(fn($product) => $product->reviews()->where('user_id', Auth::id())->exists());

if ($hasReviewed) {
    $currentStep = 4; // ⭐ bước đánh giá sáng
}

        @endphp

        <div class="flex justify-between items-center mb-10 relative">
            @foreach($steps as $i => $step)
                <div class="flex flex-col items-center w-1/5 relative">
                    <!-- Line -->
                    @if($i < count($steps) - 1)
                        <div class="absolute top-6 left-1/2 w-full h-1 {{ $i < $currentStep ? 'bg-green-500' : 'bg-gray-300' }}"></div>
                    @endif

                    <!-- Icon -->
                    <div class="relative z-10 w-12 h-12 flex items-center justify-center rounded-full border-4 {{ $i <= $currentStep ? 'border-green-500 bg-green-500 text-white' : 'border-gray-300 bg-white text-gray-400' }} shadow">
                        <i class="fa-solid {{ $step['icon'] }} text-xl"></i>
                    </div>

                    <!-- Label -->
                    <span class="mt-3 text-sm font-medium text-center {{ $i <= $currentStep ? 'text-green-600' : 'text-gray-400' }}">
                        {{ $step['label'] }}
                    </span>
                </div>
            @endforeach
        </div>

        <!-- 🧩 Thông tin đơn hàng -->
        <div class="bg-white rounded-2xl shadow-lg border border-yellow-200 mb-6 overflow-hidden">
            <div class="bg-yellow-100 px-6 py-3 flex justify-between items-center border-b border-yellow-200">
                <div>
                    <p class="font-semibold text-yellow-900">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p class="text-sm text-gray-700">👤 {{ $order->name }} | 📞 {{ $order->phone }} | 📍 {{ $order->address }}</p>
                </div>

                @php
                    $statusText = [
                        0 => '⏳ Chờ xác nhận',
                        1 => '✅ Đã xác nhận',
                        2 => '🚚 Đang giao hàng',
                        3 => '📦 Đã giao hàng',
                        4 => '⭐ Hoàn tất'
                    ];
                    $statusColor = [
                        0 => 'bg-blue-400 text-yellow-900',
                        1 => 'bg-yellow-500 text-white',
                        2 => 'bg-green-700 text-white',
                        3 => 'bg-green-400 text-white',
                        4 => 'bg-orange-500 text-white'
                    ];
                @endphp
                <span class="px-4 py-2 rounded-xl font-semibold {{ $statusColor[$order->status] ?? 'bg-gray-300 text-gray-800' }}">
                    {{ $statusText[$order->status] ?? 'Không xác định' }}
                </span>
            </div>

            <!-- 🛒 Danh sách sản phẩm -->
            <div class="p-4 overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-yellow-50 text-yellow-900">
                        <tr>
                            <th class="text-left px-4 py-2">Sản phẩm</th>
                            <th class="text-center px-4 py-2">SL</th>
                            <th class="text-right px-4 py-2">Giá</th>
                            <th class="text-right px-4 py-2">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderDetails as $d)
                        <tr class="border-t hover:bg-yellow-50 transition">
                            <td class="flex items-center gap-3 px-4 py-2">
                                <img src="{{ asset('assets/images/product/' . ($d->product->thumbnail ?? 'noimage.jpg')) }}"
                                     class="w-12 h-12 rounded-lg border object-cover">
                                <div>
                                    <p class="font-semibold text-yellow-900">{{ $d->product->name ?? '[SP đã xóa]' }}</p>
                                    <p class="text-xs text-gray-500">{{ $d->product->brand->name ?? '' }}</p>
                                </div>
                            </td>
                            <td class="text-center">{{ $d->qty }}</td>
                            <td class="text-right text-yellow-800">{{ number_format($d->price_buy, 0, ',', '.') }}đ</td>
                            <td class="text-right font-bold text-orange-600">{{ number_format($d->amount, 0, ',', '.') }}đ</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- 💰 Tổng cộng -->
            <div class="bg-yellow-50 px-6 py-3 flex justify-between items-center border-t border-yellow-200">
                <span class="text-yellow-900 font-medium">Tổng cộng:</span>
                <span class="text-2xl font-extrabold text-orange-600 animate-amount-glow">
                    {{ number_format($order->orderDetails->sum('amount'), 0, ',', '.') }}đ
                </span>
            </div>
        </div>

        <!-- 📝 Ghi chú -->
        @if($order->note)
            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded-xl text-yellow-900 animate-fadeIn">
                <strong>📝 Ghi chú:</strong> {{ $order->note }}
            </div>
        @endif
    </div>
</div>

<!-- 🌈 Hiệu ứng -->
<style>
@keyframes fadeIn { from {opacity: 0; transform: translateY(15px);} to {opacity: 1; transform: translateY(0);} }
@keyframes waveMove { 0% {transform: translateX(-50%);} 50% {transform: translateX(50%);} 100% {transform: translateX(-50%);} }
.animate-fadeIn { animation: fadeIn 0.8s ease-in-out; }
.animate-wave { animation: waveMove 12s linear infinite; }
@keyframes amountGlow {
  0%,100% { color: #ea580c; text-shadow: 0 0 3px #ffd966; }
  50% { color: #f97316; text-shadow: 0 0 10px #ffeb99; }
}
.animate-amount-glow { animation: amountGlow 2s ease-in-out infinite; }
</style>
</x-layout-user>
