<x-layout-user>
<div class="min-h-screen bg-gradient-to-br from-yellow-100 via-yellow-200 to-yellow-300 py-12 relative overflow-hidden">
    <!-- 🌟 Hiệu ứng lấp lánh -->
    <canvas id="sparkleCanvas" class="absolute inset-0 w-full h-full pointer-events-none z-0"></canvas>

    <div class="max-w-6xl mx-auto relative z-10">
        <div class="bg-white/90 backdrop-blur-md rounded-3xl shadow-2xl p-8 transform transition hover:scale-[1.01] hover:shadow-[0_0_40px_rgba(255,230,150,0.6)]">
            <h1 class="text-4xl font-extrabold text-yellow-700 mb-6 flex items-center gap-3">
                💛 Danh sách yêu thích
                <span class="bg-yellow-200 px-3 py-1 rounded-full text-sm font-semibold animate-pulse shadow text-yellow-700">
                    {{ $items->count() }} sản phẩm
                </span>
            </h1>

            @if($items->isEmpty())
                <div class="text-gray-700 italic text-center py-10 text-lg">
                    Danh sách yêu thích trống... 🌻
                </div>
            @else
            <div class="overflow-x-auto">
                <table class="min-w-full border-separate border-spacing-y-2">
                    <thead>
                        <tr class="bg-yellow-100 text-yellow-900 text-left text-sm font-semibold uppercase tracking-wider">
                            <th class="py-3 px-4 rounded-l-xl">Ảnh</th>
                            <th class="py-3 px-4">Sản phẩm</th>
                            <th class="py-3 px-4 text-right">Giá</th>
                            <th class="py-3 px-4 text-center rounded-r-xl">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $wish)
                            @php $product = $wish->product; @endphp
                            <tr class="bg-yellow-50 hover:bg-yellow-100 transition rounded-xl shadow-sm">
                                <td class="py-3 px-4">
                                    <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                                         class="w-20 h-20 rounded-xl object-cover shadow">
                                </td>

                                <td class="py-3 px-4 align-middle">
                                    <div class="font-bold text-yellow-900 text-base">{{ $product->name }}</div>
                                    <div class="text-xs text-gray-500">#{{ $loop->iteration }}</div>
                                </td>

                                <td class="py-3 px-4 text-right align-middle">
                                    @if ($product->price_sale > 0)
                                        <div class="text-orange-600 font-bold text-lg">
                                            {{ number_format($product->price_sale, 0, ',', '.') }}đ
                                        </div>
                                        <div class="text-gray-400 line-through text-sm">
                                            {{ number_format($product->price_root, 0, ',', '.') }}đ
                                        </div>
                                    @else
                                        <div class="text-orange-600 font-bold text-lg">
                                            {{ number_format($product->price_root, 0, ',', '.') }}đ
                                        </div>
                                    @endif
                                </td>

                                <td class="py-3 px-4 text-center align-middle">
                                    <div class="flex justify-center items-center gap-3">
                                        <a href="{{ route('site.product_detail', ['slug' => $product->slug]) }}"
                                           class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full font-semibold shadow hover:scale-105 transition text-sm">
                                            Xem chi tiết
                                        </a>
                                        <button type="button"
                                                class="remove-btn text-red-500 hover:text-red-700 text-2xl transition transform hover:scale-125"
                                                data-id="{{ $product->id }}" title="Xóa khỏi yêu thích">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

            <div class="flex justify-center mt-8">
                <a href="{{ route('home') }}"
                   class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-full shadow-lg transform hover:scale-105 transition">
                    ← Tiếp tục mua sắm
                </a>
            </div>
        </div>
    </div>
</div>

{{-- ✨ Canvas lấp lánh --}}
<script>
const canvas = document.getElementById("sparkleCanvas");
const ctx = canvas.getContext("2d");
let sparkles = [];

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}
window.addEventListener("resize", resizeCanvas);
resizeCanvas();

function createSparkle() {
    return {
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        size: Math.random() * 2 + 1,
        speed: Math.random() * 0.7 + 0.3,
        opacity: Math.random()
    };
}
for (let i = 0; i < 100; i++) sparkles.push(createSparkle());
function drawSparkles() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    for (let s of sparkles) {
        ctx.fillStyle = `rgba(255,255,200,${s.opacity})`;
        ctx.beginPath();
        ctx.arc(s.x, s.y, s.size, 0, Math.PI * 2);
        ctx.fill();
        s.y += s.speed;
        if (s.y > canvas.height) {
            s.y = -5;
            s.x = Math.random() * canvas.width;
        }
    }
    requestAnimationFrame(drawSparkles);
}
drawSparkles();
</script>

{{-- 🗑️ Xóa yêu thích bằng AJAX + hiệu ứng --}}
<script>
document.querySelectorAll('.remove-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const productId = this.dataset.id;
        const icon = this.querySelector('i');
        icon.classList.add('trash-animate');

        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const trash = document.createElement('div');
                trash.innerHTML = '🗑️';
                trash.className = 'trash-fly';
                document.body.appendChild(trash);
                setTimeout(() => {
                    trash.remove();
                    location.reload();
                }, 1000);
            } else {
                alert(data.message || 'Lỗi xảy ra!');
            }
        })
        .catch(err => console.error(err));
    });
});
</script>

<style>
.trash-fly {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    font-size: 70px;
    opacity: 0;
    z-index: 9999;
    animation: trashFly 1s ease-out forwards;
}
@keyframes trashFly {
    0% { transform: translate(-50%, -50%) scale(0); opacity: 0; }
    40% { transform: translate(-50%, -60%) scale(1.3); opacity: 1; }
    100% { transform: translate(-50%, -80%) scale(0.7); opacity: 0; }
}
.trash-animate { animation: trashShake 0.6s ease-in-out; }
@keyframes trashShake {
    0%, 100% { transform: rotate(0); }
    20% { transform: rotate(-15deg); }
    40% { transform: rotate(10deg); }
    60% { transform: rotate(-10deg); }
    80% { transform: rotate(5deg); }
}
</style>
</x-layout-user>
