@extends('components.layout-user')

@section('title', 'Chi tiết sản phẩm')

@section('content')
<div class="container mx-auto px-4 py-10 animate-fade-in">

    {{-- 🪄 Thông báo --}}
    @if (session('success'))
        <div id="alert" class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded-lg shadow-md">
            ✅ {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div id="alert" class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg shadow-md">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    {{-- 💎 Thông tin sản phẩm --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 bg-yellow-100 p-8 rounded-2xl shadow-lg">

        {{-- 🖼️ Ảnh --}}
        <div class="col-span-1 flex flex-col justify-start">
            <div class="border border-yellow-400 p-4 rounded-xl bg-yellow-50 flex items-center justify-center h-[420px]">
                <img id="mainImage"
                     src="{{ asset('assets/images/product/' . $product_item->thumbnail) }}"
                     alt="{{ $product_item->name }}"
                     class="object-contain w-full h-full rounded-lg transition-transform duration-500 hover:scale-105">
            </div>

            {{-- Thư viện ảnh --}}
            @php
                $gallery = is_string($product_item->images ?? null)
                    ? json_decode($product_item->images, true)
                    : ($product_item->images ?? []);
                $gallery = is_array($gallery) ? $gallery : [];
            @endphp
            @if (count($gallery))
                <div class="flex gap-2 mt-4 overflow-x-auto">
                    @foreach ($gallery as $img)
                        <img onclick="changeImage(this)"
                             src="{{ asset('assets/images/product/' . $img) }}"
                             class="w-20 h-20 object-cover border border-yellow-400 rounded-lg cursor-pointer hover:scale-110 transition-all">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- 🧾 Thông tin --}}
        <div class="col-span-1 flex flex-col justify-between">
            <div>
                <h1 class="text-yellow-700 text-3xl font-extrabold">{{ $product_item->name }}</h1>
                <p class="mt-2 text-gray-700">
                    Thương hiệu:
                    <span class="font-semibold text-yellow-700">{{ $product_item->brand->name ?? 'Không rõ' }}</span> |
                    @php $inStock = $product_item->stock > 0; @endphp
                    <span class="{{ $inStock ? 'text-green-600' : 'text-red-500' }}">
                        {{ $inStock ? 'Còn hàng' : 'Hết hàng' }}
                    </span>
                    @if ($inStock)
                        <span class="text-sm text-yellow-600 ml-2">(Còn {{ $product_item->stock }} sản phẩm)</span>
                    @endif
                </p>

                {{-- 💰 Giá --}}
                @php
                    $hasSale = !empty($product_item->price_sale) && $product_item->price_sale > 0;
                    $priceSale = $hasSale ? $product_item->price_sale : null;
                    $priceRoot = $product_item->price_root ?? $product_item->price ?? 0;
                @endphp
                <div class="mt-3">
                    @if ($hasSale)
                        <p class="text-orange-500 text-4xl font-extrabold">{{ number_format($priceSale, 0, ',', '.') }}đ</p>
                        <p class="line-through text-gray-400">{{ number_format($priceRoot, 0, ',', '.') }}đ</p>
                    @else
                        <p class="text-orange-500 text-4xl font-extrabold">{{ number_format($priceRoot, 0, ',', '.') }}đ</p>
                    @endif
                </div>

                {{-- 📊 Thanh tiến trình bán hàng --}}
                @php
                    $sold = $product_item->sold ?? 0;
                    $stock = $product_item->stock ?? 0;
                    $total = $sold + $stock;
                    $percentSold = $total > 0 ? round(($sold / $total) * 100) : 0;
                @endphp
                <div class="mt-4">
                    <div class="w-full bg-gray-300 rounded-full h-3 overflow-hidden">
                        <div class="h-3 bg-yellow-500 transition-all" style="width: {{ $percentSold }}%"></div>
                    </div>
                    <p class="text-sm text-gray-700 mt-1">
                        🔥 Đã bán <strong>{{ $sold }}</strong> / Tổng <strong>{{ $total }}</strong> sản phẩm
                    </p>
                </div>

                {{-- 📜 Mô tả --}}
                <div class="mt-4 text-gray-700 text-sm leading-relaxed">
                    {!! $product_item->detail ?? $product_item->description !!}
                </div>
            </div>

            {{-- 🛒 Giỏ hàng --}}
            <div class="mt-6 flex items-center gap-4">
                <div class="flex items-center gap-2">
                    <button type="button" onclick="changeQuantity(-1)" class="w-8 h-8 bg-gray-700 text-white rounded hover:bg-gray-600">-</button>
                    <input id="quantity" type="number" min="1" value="1" class="w-12 text-center border border-gray-300 rounded">
                    <button type="button" onclick="changeQuantity(1)" class="w-8 h-8 bg-gray-700 text-white rounded hover:bg-gray-600">+</button>
                </div>

                @if ($inStock)
                    <form action="{{ route('cart.add', ['id' => $product_item->id]) }}" method="POST" class="flex-1">
                        @csrf
                        <input type="hidden" name="quantity" id="formQuantity" value="1">
                        <button type="submit"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-xl font-semibold transition-all hover:scale-[1.02] shadow-md">
                            🛒 Thêm vào giỏ hàng
                        </button>
                    </form>
                @else
                    <button disabled
                        class="flex-1 bg-gray-400 text-white py-3 rounded-xl font-semibold cursor-not-allowed shadow-inner">
                        🚫 ĐÃ HẾT HÀNG
                    </button>
                @endif
            </div>
        </div>

        {{-- 💡 Chính sách + Liên quan --}}
        <div class="col-span-1 space-y-6">
            <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-300 shadow-inner">
                <h3 class="text-yellow-700 font-bold text-lg mb-3">CHÍNH SÁCH CỦA CHÚNG TÔI</h3>
                <ul class="text-yellow-800 text-sm space-y-2">
                    <li>✅ Miễn phí vận chuyển tại TP.HCM</li>
                    <li>✅ Bảo hành chính hãng toàn quốc</li>
                    <li>✅ Cam kết chính hãng 100%</li>
                    <li>✅ 1 đổi 1 nếu sản phẩm lỗi</li>
                </ul>
            </div>

            {{-- 🧩 Sản phẩm liên quan --}}
            @if (!empty($product_list) && $product_list->count())
            <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-300 shadow-inner relative overflow-hidden">
                <h3 class="text-yellow-700 font-bold text-lg mb-4">SẢN PHẨM LIÊN QUAN</h3>
                <div id="relatedWrapper" class="flex gap-4 overflow-x-auto scroll-smooth hide-scrollbar">
                    @foreach ($product_list as $p)
                        <a href="{{ route('site.product_detail', ['slug' => $p->slug]) }}"
                           class="flex-shrink-0 w-[180px] bg-white border border-yellow-100 rounded-xl p-3 hover:shadow-md hover:scale-[1.03] transition">
                            <img src="{{ asset('assets/images/product/' . $p->thumbnail) }}"
                                 class="w-full h-32 object-cover rounded-lg border border-yellow-300">
                            <p class="mt-2 text-sm text-yellow-800 font-semibold truncate">{{ $p->name }}</p>
                            @if (!empty($p->price_sale))
                                <p class="text-yellow-600 font-bold text-sm">{{ number_format($p->price_sale, 0, ',', '.') }}đ</p>
                                <p class="line-through text-yellow-400 text-xs">{{ number_format($p->price_root, 0, ',', '.') }}đ</p>
                            @else
                                <p class="text-yellow-600 font-bold text-sm">{{ number_format($p->price_root ?? $p->price, 0, ',', '.') }}đ</p>
                            @endif
                        </a>
                    @endforeach
                </div>
                <button onclick="scrollCarousel(-1)" class="absolute left-1 top-1/2 -translate-y-1/2 bg-yellow-400 text-white rounded-full w-8 h-8 shadow hover:bg-yellow-500">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
                <button onclick="scrollCarousel(1)" class="absolute right-1 top-1/2 -translate-y-1/2 bg-yellow-400 text-white rounded-full w-8 h-8 shadow hover:bg-yellow-500">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
            @endif
        </div>
    </div>

    {{-- ⭐ ĐÁNH GIÁ --}}
    <div class="mt-10 bg-yellow-50 p-8 rounded-2xl border border-yellow-300 shadow-inner w-full">
        <h3 class="text-yellow-700 text-2xl font-bold mb-6 flex items-center gap-2">
            <i class="fa-solid fa-star text-yellow-500"></i> ĐÁNH GIÁ SẢN PHẨM
        </h3>

        @php
            $avgRating = round($product_item->reviews->avg('rating') ?? 0, 1);
            $totalReviews = $product_item->reviews->count();
            $userReviewed = auth()->check() ? $product_item->reviews->where('user_id', auth()->id())->first() : null;
        @endphp

        <div class="flex items-center mb-6">
            <div class="flex text-yellow-400 text-2xl" id="avgStars">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa{{ $i <= $avgRating ? 's' : 'r' }} fa-star"></i>
                @endfor
            </div>
            <span class="ml-3 text-gray-800 font-semibold">{{ $avgRating }}/5 ({{ $totalReviews }} đánh giá)</span>
        </div>

        {{-- Danh sách đánh giá --}}
        @foreach ($product_item->reviews as $review)
            <div class="border-t border-yellow-200 pt-4 mt-4">
                <div class="flex justify-between">
                    <div>
                        <p class="font-semibold text-yellow-800">{{ $review->user->name ?? 'Khách hàng' }}</p>
                        <div class="flex text-yellow-400 text-sm">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                            @endfor
                        </div>
                    </div>
                    <p class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</p>
                </div>

                @if ($review->comment)
                    <p class="text-gray-700 mt-2">{{ $review->comment }}</p>
                @endif

                {{-- ✅ Hiển thị ảnh review --}}
                @if (!empty($review->images))
                    @php $imgs = is_array($review->images) ? $review->images : json_decode($review->images, true); @endphp
                    @if (is_array($imgs))
                        <div class="flex gap-2 mt-3 flex-wrap">
                            @foreach ($imgs as $img)
                                <img src="{{ asset('assets/images/reviews/' . $img) }}"
                                     class="w-24 h-24 object-cover rounded-lg border border-yellow-300 hover:scale-105 transition">
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        @endforeach

        {{-- Form đánh giá --}}
        @auth
            @if (!$userReviewed)
                <form action="{{ route('product.addReview', $product_item->id) }}" method="POST" enctype="multipart/form-data"
                      class="mt-6 bg-yellow-100 border border-yellow-300 p-5 rounded-xl shadow-inner space-y-3 w-full md:w-3/4">
                    @csrf
                    <div class="flex items-center gap-3">
                        <label class="font-semibold text-gray-700">Chọn sao:</label>
                        <div id="ratingStars" class="flex text-yellow-400 text-xl cursor-pointer">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="far fa-star transition-all hover:scale-125" data-value="{{ $i }}"></i>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="ratingValue" value="5">
                    </div>

                    <textarea name="comment" rows="3" placeholder="Nhập cảm nhận của bạn..."
                              class="w-full border border-yellow-300 rounded-lg p-2 focus:ring-2 focus:ring-yellow-400"></textarea>

                    <div>
                        <label class="font-semibold text-gray-700">📸 Tải ảnh (tối đa 3 ảnh):</label>
                        <input type="file" name="images[]" id="reviewImages" multiple accept="image/*"
                               class="block w-full border border-yellow-300 rounded-lg bg-yellow-50 p-2 mt-1">
                        <div id="imagePreview" class="flex gap-2 mt-3 flex-wrap"></div>
                    </div>

                    <button type="submit"
                            class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-bold transition hover:scale-105 shadow">
                        Gửi đánh giá
                    </button>
                </form>
            @else
                <div class="mt-4 bg-yellow-100 p-4 rounded-lg border border-yellow-300 text-yellow-800">
                    🌟 Bạn đã đánh giá sản phẩm này rồi. Cảm ơn bạn!
                </div>
            @endif
        @else
            <p class="text-gray-600 mt-3 text-sm">
                🔒 Vui lòng <a href="{{ route('login') }}" class="text-yellow-600 underline">đăng nhập</a> để đánh giá sản phẩm.
            </p>
        @endauth
    </div>
</div>

{{-- 🔧 CSS + JS --}}
<style>
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
function changeImage(el){document.getElementById('mainImage').src=el.src;}
function changeQuantity(d){let i=document.getElementById('quantity'),f=document.getElementById('formQuantity');let v=parseInt(i.value)||1;v+=d;if(v<1)v=1;i.value=v;f.value=v;}
function scrollCarousel(dir){document.getElementById('relatedWrapper').scrollBy({left: dir*220, behavior:'smooth'});}

// ⭐ Chọn sao
document.addEventListener("DOMContentLoaded", () => {
    const stars = document.querySelectorAll('#ratingStars i');
    const input = document.getElementById('ratingValue');
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const value = parseInt(this.dataset.value);
            input.value = value;
            stars.forEach((s, idx) => {
                s.classList.toggle('fas', idx < value);
                s.classList.toggle('far', idx >= value);
            });
        });
    });

    // 📸 Preview ảnh upload
    const reviewInput = document.getElementById('reviewImages');
    const preview = document.getElementById('imagePreview');
    reviewInput?.addEventListener('change', (e) => {
        preview.innerHTML = '';
        Array.from(e.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e2 => {
                const img = document.createElement('img');
                img.src = e2.target.result;
                img.className = 'w-24 h-24 object-cover rounded-lg border border-yellow-300 hover:scale-105 transition';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
});
</script>
@endsection
