<section id="brandShowcase"
         class="relative max-w-6xl mx-auto mt-10 bg-gradient-to-b from-yellow-50 via-yellow-100 to-white
                rounded-2xl shadow-[0_4px_30px_rgba(255,200,0,0.2)] overflow-hidden border border-yellow-300 animate-fadeIn">

    <!-- 🌟 Header -->
    <div class="flex justify-between items-center flex-wrap border-b border-yellow-300 
                bg-gradient-to-r from-yellow-500 to-yellow-400 px-6 py-4 text-white">
        <div class="flex items-center gap-4 flex-wrap">
            <h2 class="text-xl md:text-2xl font-extrabold tracking-wide drop-shadow flex items-center gap-2">
                💎 <span>THƯƠNG HIỆU NỔI BẬT</span>
            </h2>
            <span class="text-white/90 text-sm md:text-base">⭐ Ưu đãi đến 50%</span>
            <span class="text-white/90 text-sm md:text-base">🚚 Miễn phí vận chuyển</span>
            <span class="text-white/90 text-sm md:text-base">🛒 Chính hãng 100%</span>
        </div>
        <a href="{{ route('site.product') }}" 
           class="text-white font-medium text-sm hover:text-yellow-100 transition duration-300 flex items-center gap-1">
            Xem tất cả →
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-5 gap-0 p-5">
        <!-- 🖼️ Banner bên trái -->
        <div class="col-span-1 md:col-span-2 relative overflow-hidden group">
            @if ($ads)
                <img src="{{ asset('assets/images/banner/' . $ads->image) }}"
                     alt="{{ $ads->name }}"
                     class="w-full h-full object-cover rounded-l-2xl group-hover:scale-105 transition-transform duration-700 ease-in-out brightness-95 hover:brightness-100 shadow-lg">
                <div class="absolute inset-0 rounded-l-2xl bg-gradient-to-t from-black/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
            @else
                <div class="w-full h-64 bg-gray-100 flex items-center justify-center text-gray-400 rounded-l-2xl">
                    Chưa có banner quảng cáo
                </div>
            @endif
        </div>

        <!-- 🏷️ Danh sách thương hiệu bên phải -->
        <div class="col-span-1 md:col-span-3 relative flex flex-col justify-center">
            <div id="brandCarousel" class="overflow-hidden px-8">
                <div id="brandInner" class="flex transition-transform duration-700 ease-in-out">
                    @foreach (array_chunk($brands->toArray(), 8) as $group)
                        <div class="min-w-full grid grid-cols-4 grid-rows-2 gap-4 place-items-center px-2 py-3">
                            @foreach ($group as $brand)
                                <!-- 🟡 Thẻ thương hiệu có link đến trang sản phẩm lọc theo brand -->
                                <a href="{{ route('site.product', ['brand_slug' => $brand['slug']]) }}"
                                   class="brand-card w-[140px] bg-white border border-yellow-300 rounded-xl p-3 
                                          flex flex-col items-center justify-between text-center 
                                          hover:-translate-y-1 hover:border-yellow-500 hover:shadow-[0_0_15px_rgba(255,220,0,0.4)] 
                                          transition-all duration-500 cursor-pointer group relative overflow-hidden">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-br from-yellow-50 via-transparent to-transparent 
                                                opacity-0 group-hover:opacity-100 transition-all duration-500"></div>
                                    
                                    <div class="relative z-10 flex flex-col items-center">
                                        <img src="{{ asset('assets/images/brand/' . $brand['image']) }}"
                                             alt="{{ $brand['name'] }}"
                                             class="w-20 h-20 object-contain transform group-hover:scale-110 group-hover:rotate-2 transition duration-700 ease-in-out" />
                                        <p class="text-sm font-semibold text-gray-800 group-hover:text-yellow-700 mt-2">
                                            {{ $brand['name'] }}
                                        </p>
                                        <p class="text-xs text-yellow-600 mt-1 italic opacity-0 group-hover:opacity-100 transition duration-500">
                                            {{ $brand['description'] ?? 'Giảm đến 50%' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- 🔄 Nút trượt -->
            <div class="flex justify-between items-center px-3 mt-3">
                <button id="brandPrev"
                        class="w-11 h-11 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button id="brandNext"
                        class="w-11 h-11 bg-yellow-400 hover:bg-yellow-500 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 active:scale-95">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</section>

<!-- 💫 Script + Hoạt họa -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const inner = document.getElementById('brandInner');
    const slides = inner.children.length;
    let current = 0;

    const next = document.getElementById('brandNext');
    const prev = document.getElementById('brandPrev');

    function updateSlide() {
        inner.style.transform = `translateX(-${current * 100}%)`;
    }

    next.addEventListener('click', () => {
        current = (current + 1) % slides;
        updateSlide();
    });

    prev.addEventListener('click', () => {
        current = (current - 1 + slides) % slides;
        updateSlide();
    });

    // Auto slide
    let auto = setInterval(() => {
        current = (current + 1) % slides;
        updateSlide();
    }, 5000);

    inner.addEventListener('mouseenter', () => clearInterval(auto));
    inner.addEventListener('mouseleave', () => {
        auto = setInterval(() => {
            current = (current + 1) % slides;
            updateSlide();
        }, 5000);
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn { animation: fadeIn 1s ease-out forwards; }

.brand-card::after {
    content: "";
    position: absolute;
    top: -120%;
    left: -120%;
    width: 300%;
    height: 300%;
    background: linear-gradient(60deg, rgba(255,240,150,0.3), rgba(255,255,200,0));
    transform: rotate(45deg);
    opacity: 0;
    transition: all 0.6s ease;
}
.brand-card:hover::after {
    top: -50%;
    left: -50%;
    opacity: 1;
}
</style>
