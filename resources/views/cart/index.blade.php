<x-layout-user>
<div class="min-h-screen bg-gradient-to-br from-yellow-200 via-yellow-300 to-yellow-400 py-12 relative overflow-hidden">
    <canvas id="sparkleCanvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <div class="max-w-6xl mx-auto relative z-10">
        <form action="{{ route('cart.processCheckout') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="grid md:grid-cols-3 gap-6">

                <!-- 🛒 Giỏ hàng -->
                <div class="md:col-span-2 bg-white/90 backdrop-blur-md rounded-2xl shadow-xl p-6 transform transition hover:scale-[1.01] hover:shadow-2xl">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-extrabold text-gray-800 flex items-center gap-3">
                            🛍️ Giỏ hàng của bạn
                            <span class="bg-yellow-200 px-3 py-1 rounded-full text-sm font-semibold animate-pulse shadow-inner">
                                {{ count($cart) }} sản phẩm
                            </span>
                        </h1>
                        <div class="flex items-center gap-2 text-sm font-semibold text-gray-700">
                            <input type="checkbox" id="selectAll" class="accent-yellow-500 w-5 h-5 cursor-pointer">
                            <label for="selectAll">Chọn tất cả</label>
                        </div>
                    </div>

                    @forelse($cart as $item)
                        @php
                            $price_root = $item['price_root'] ?? 0;
                            $price_sale = $item['price_sale'] ?? null;
                            $price = ($price_sale && $price_sale > 0 && $price_sale < $price_root) ? $price_sale : $price_root;
                            $itemTotal = $price * ($item['quantity'] ?? 1);
                        @endphp

                        <div class="flex items-center justify-between py-4 border-b border-gray-200 group hover:bg-yellow-50 transition rounded-xl relative">

                            <!-- Checkbox -->
                            <input type="checkbox" name="selected_products[]" value="{{ $item['product_id'] }}"
                                   class="product-checkbox accent-yellow-500 w-5 h-5 mr-3 cursor-pointer">

                            <!-- Ảnh & tên -->
                            <div class="flex items-center flex-1">
                                <img src="{{ asset('assets/images/product/' . $item['image']) }}"
                                     class="w-16 h-16 rounded-xl shadow-md transform group-hover:scale-110 transition">
                                <div class="ml-4">
                                    <div class="font-bold text-gray-800">{{ $item['name'] }}</div>
                                    <div class="text-xs text-gray-500">#{{ $loop->iteration }}</div>
                                </div>
                            </div>

                            <!-- Số lượng -->
                            <div class="flex items-center gap-1">
                                <button type="button"
                                        class="qty-btn px-3 py-1 bg-yellow-300 hover:bg-yellow-400 rounded shadow text-lg font-bold"
                                        data-id="{{ $item['product_id'] }}"
                                        data-quantity="{{ max(1, ($item['quantity'] ?? 1) - 1) }}">−</button>
                                <input type="text" readonly value="{{ $item['quantity'] ?? 1 }}"
                                       class="w-10 text-center bg-gray-100 border rounded shadow font-semibold">
                                <button type="button"
                                        class="qty-btn px-3 py-1 bg-yellow-300 hover:bg-yellow-400 rounded shadow text-lg font-bold"
                                        data-id="{{ $item['product_id'] }}"
                                        data-quantity="{{ ($item['quantity'] ?? 1) + 1 }}">+</button>
                            </div>

                            <!-- Giá -->
                            <div class="text-right min-w-[120px]">
                                @if ($price_sale && $price_sale < $price_root)
                                    <div class="line-through text-sm text-gray-400">
                                        {{ number_format($price_root, 0, ',', '.') }}đ
                                    </div>
                                    <div class="font-bold text-orange-600">
                                        {{ number_format($price_sale, 0, ',', '.') }}đ
                                    </div>
                                    <div class="text-xs text-green-600 animate-bounce">
                                        -{{ round(100 - ($price_sale / $price_root * 100)) }}%
                                    </div>
                                @else
                                    <div class="font-bold text-orange-600">
                                        {{ number_format($price_root, 0, ',', '.') }}đ
                                    </div>
                                @endif
                                <div class="text-xs text-gray-600 item-total">
                                    Tổng: {{ number_format($itemTotal, 0, ',', '.') }}đ
                                </div>
                            </div>

                            <!-- Xoá -->
                            <a href="{{ route('cart.remove', $item['product_id']) }}"
                               class="ml-4 text-red-500 hover:text-red-700 text-2xl transition-all transform hover:scale-125">
                                <i class="fa-solid fa-trash-can"></i>
                            </a>
                        </div>
                    @empty
                        <div class="text-gray-600 italic mt-4 text-center">Giỏ hàng trống...</div>
                    @endforelse

                    <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                        <a href="{{ route('home') }}"
                           class="relative inline-flex items-center text-blue-700 font-semibold hover:text-blue-900 group">
                            <span class="absolute inset-0 bg-blue-100 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 origin-center"></span>
                            <i class="fa-solid fa-arrow-left mr-2 transition-transform group-hover:-translate-x-1"></i>
                            <span class="relative z-10">Tiếp tục mua sắm</span>
                        </a>

                        <div class="text-xl font-extrabold text-gray-900">
                            Tổng: <span id="cart-total-display">0đ</span>
                        </div>
                    </div>
                </div>

                <!-- 💳 Thanh toán -->
                <div class="bg-gradient-to-b from-yellow-400 to-yellow-500 text-white rounded-2xl shadow-2xl p-6 relative overflow-hidden transform transition hover:scale-[1.01] hover:shadow-yellow-300/50">
                    <h2 class="text-2xl font-bold mb-4">🧾 Thông tin thanh toán</h2>

                    <div class="space-y-3 text-gray-800">
                        <input name="name" placeholder="👤 Họ tên" required class="w-full h-11 px-3 rounded-xl focus:ring-2 focus:ring-yellow-600 shadow-inner">
                        <input name="email" type="email" placeholder="📧 Email" required class="w-full h-11 px-3 rounded-xl focus:ring-2 focus:ring-yellow-600 shadow-inner">
                        <input name="phone" placeholder="📞 Số điện thoại" required class="w-full h-11 px-3 rounded-xl focus:ring-2 focus:ring-yellow-600 shadow-inner">
                        <input name="address" placeholder="🏠 Địa chỉ" required class="w-full h-11 px-3 rounded-xl focus:ring-2 focus:ring-yellow-600 shadow-inner">
                        <textarea name="note" placeholder="📝 Ghi chú đơn hàng..." rows="2" class="w-full p-3 rounded-xl focus:ring-2 focus:ring-yellow-600 shadow-inner"></textarea>
                    </div>

                    <div class="mt-6 space-y-3">
                        <button type="submit" name="payment_method" value="cod"
                            class="w-full h-12 bg-green-600 hover:bg-green-700 rounded-xl font-bold shadow-lg transform hover:scale-105 transition duration-300">
                            🚚 Thanh toán khi nhận hàng
                        </button>
                        <button type="submit" name="payment_method" value="qr"
                            class="w-full h-12 bg-yellow-700 hover:bg-yellow-800 rounded-xl font-bold shadow-lg transform hover:scale-105 transition duration-300">
                            💳 Thanh toán Online (QR)
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- 💰 Tính tổng realtime --}}
<script>
const checkboxes = document.querySelectorAll('.product-checkbox');
const totalDisplay = document.getElementById('cart-total-display');
const selectAll = document.getElementById('selectAll');

function updateTotal() {
    let total = 0;
    checkboxes.forEach(cb => {
        if (cb.checked) {
            const row = cb.closest('.flex');
            const text = row.querySelector('.item-total').innerText.match(/[\d.,]+/g);
            if (text && text[0]) {
                const itemTotal = parseFloat(text[0].replace(/[.,]/g, '')) || 0;
                total += itemTotal;
            }
        }
    });
    totalDisplay.textContent = new Intl.NumberFormat('vi-VN').format(total) + 'đ';
}

selectAll?.addEventListener('change', e => {
    checkboxes.forEach(cb => cb.checked = e.target.checked);
    updateTotal();
});
checkboxes.forEach(cb => cb.addEventListener('change', updateTotal));
</script>

{{-- 🔄 Cập nhật số lượng bằng AJAX --}}
<script>
document.querySelectorAll('.qty-btn').forEach(btn => {
    btn.addEventListener('click', async e => {
        const id = btn.dataset.id;
        const quantity = btn.dataset.quantity;
        const token = "{{ csrf_token() }}";

        const res = await fetch("{{ route('cart.update') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token,
            },
            body: JSON.stringify({ id, quantity }),
        });

        if (res.ok) location.reload();
    });
});
</script>

{{-- 🌟 Hiệu ứng lấp lánh --}}
<script>
const canvas = document.getElementById("sparkleCanvas");
const ctx = canvas.getContext("2d");
let sparkles = [];
function resizeCanvas() { canvas.width = window.innerWidth; canvas.height = window.innerHeight; }
window.addEventListener("resize", resizeCanvas);
resizeCanvas();
function createSparkle() { return { x: Math.random()*canvas.width, y: Math.random()*canvas.height, size: Math.random()*2+1, speed: Math.random()*1+0.5, opacity: Math.random() }; }
for (let i=0; i<100; i++) sparkles.push(createSparkle());
function drawSparkles() {
  ctx.clearRect(0,0,canvas.width,canvas.height);
  for (let s of sparkles) {
    ctx.fillStyle = `rgba(255,255,255,${s.opacity})`;
    ctx.beginPath(); ctx.arc(s.x,s.y,s.size,0,Math.PI*2); ctx.fill();
    s.y += s.speed; if (s.y > canvas.height) { s.y = -5; s.x = Math.random()*canvas.width; }
  }
  requestAnimationFrame(drawSparkles);
}
drawSparkles();
</script>

<style>
.fa-trash-can { transition: transform 0.3s ease, color 0.3s ease; }
.fa-trash-can:hover { transform: scale(1.2) rotate(-10deg); color: #dc2626; }
</style>
</x-layout-user>
