<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Sản phẩm mới nhất</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://kit.fontawesome.com/a2d9f8b4bb.js" crossorigin="anonymous"></script>

    <style>
        .card { transition: transform .25s ease, box-shadow .25s ease; }
        .card:hover { transform: translateY(-8px); }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* ❤️ Nút tim */
        .fa-heart { transition: transform 0.3s ease, color 0.3s ease; }
        .fa-heart.liked { color: red; transform: scale(1.3); }
        .fa-heart.like-animate { animation: pulse 0.4s ease; }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.4); }
            100% { transform: scale(1); }
        }

        /* 💖 Tim bay lên */
        .flying-heart {
            position: fixed;
            font-size: 20px;
            color: red;
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
            animation: flyUp 1s ease-out forwards;
            z-index: 9999;
        }
        @keyframes flyUp {
            0% { transform: translate(-50%, -50%) scale(1); opacity: 1; }
            50% { transform: translate(-50%, -150%) scale(1.5); opacity: 0.8; }
            100% { transform: translate(-50%, -250%) scale(0.5); opacity: 0; }
        }
    </style>
</head>
<body class="bg-gradient-to-b from-yellow-100 to-yellow-200">

    <div class="max-w-6xl mx-auto px-4 py-8">
        <div class="relative rounded-2xl overflow-hidden bg-gradient-to-b from-yellow-400 to-yellow-300 border border-yellow-500 p-6 shadow-lg">

            {{-- 🌟 Header --}}
            <div class="flex items-center justify-between flex-wrap gap-3">
                <h2 class="text-white font-extrabold text-xl md:text-2xl drop-shadow-lg">
                    🆕 SẢN PHẨM MỚI NHẤT
                </h2>
                <div class="flex items-center space-x-2">
                    <span class="text-white font-semibold">Đang cập nhật liên tục...</span>
                </div>
            </div>

            {{-- 💥 Carousel sản phẩm --}}
            <div class="mt-6 relative">
                <div id="carousel-new" class="flex gap-5 overflow-x-auto hide-scrollbar pb-4">

                    @foreach($newProducts as $product)
                        @php
                            $sold = $product->sold ?? 0;
                            $stock = $product->stock ?? 0;
                            $total = max($sold + $stock, 1);
                            $soldPercent = min(100, round(($sold / $total) * 100));
                        @endphp

                        <div class="card min-w-[260px] max-w-[260px] bg-white rounded-2xl border shadow-sm p-3 flex flex-col">

                            {{-- Ảnh & tên --}}
                            <a href="{{ route('site.product_detail', ['slug' => $product->slug]) }}" class="block">
                                <div class="relative">
                                    <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-40 object-contain rounded-xl bg-gray-50" />
                                    @if(isset($product->discount))
                                        <div class="absolute top-3 left-3 bg-yellow-500 text-white px-2 py-1 text-xs rounded">
                                            -{{ $product->discount }}%
                                        </div>
                                    @endif
                                </div>
                                <div class="mt-3 flex-1">
                                    <h3 class="mt-2 text-sm font-semibold text-gray-800 line-clamp-2">{{ $product->name }}</h3>
                                </div>
                            </a>

                            {{-- Giá & tồn kho --}}
                            <div class="mt-3">
                                <div class="flex items-baseline gap-3">
                                    <div class="text-lg font-extrabold text-yellow-600">
                                        {{ number_format($product->price_sale ?? $product->price_root, 0, ',', '.') }}đ
                                    </div>
                                    @if($product->price_sale)
                                        <div class="text-sm line-through text-gray-400">
                                            {{ number_format($product->price_root, 0, ',', '.') }}đ
                                        </div>
                                    @endif
                                </div>

                                {{-- Thanh tiến trình --}}
                                <div class="mt-3">
                                    <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                        <div class="h-3 bg-yellow-500 transition-all duration-500"
                                             style="width: {{ $soldPercent }}%;"></div>
                                    </div>
                                    <div class="mt-1 text-xs text-gray-500">
                                        Đã bán {{ $sold }} / Còn {{ $stock }} sản phẩm
                                    </div>
                                </div>

                                {{-- Nút hành động --}}
                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('site.product_detail', ['slug' => $product->slug]) }}"
                                       class="flex-1 py-2 rounded-full text-center font-semibold transition
                                            {{ $product->stock > 0
                                                ? 'bg-yellow-600 text-white hover:bg-yellow-700'
                                                : 'bg-gray-400 text-white cursor-not-allowed' }}">
                                        {{ $product->stock > 0 ? 'Mua ngay' : 'Hết hàng' }}
                                    </a>

                                    {{-- ❤️ Nút yêu thích --}}
                                    <button class="like-btn w-10 h-10 rounded-full border flex items-center justify-center text-yellow-600 hover:bg-yellow-50"
                                            data-id="{{ $product->id }}">
                                        <i class="fa fa-heart {{ $product->is_liked ? 'liked' : '' }}"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ❤️ Script Yêu thích + Tim bay --}}
    <script>
    document.querySelectorAll('.like-btn').forEach(btn => {
        const icon = btn.querySelector('i');
        const productId = btn.dataset.id;

        btn.addEventListener('click', async (e) => {
            e.preventDefault();
            icon.classList.add('like-animate');

            // 💖 Hiệu ứng tim bay
            const heart = document.createElement('i');
            heart.className = 'fa fa-heart flying-heart';
            const rect = btn.getBoundingClientRect();
            heart.style.left = rect.left + rect.width / 2 + 'px';
            heart.style.top = rect.top + rect.height / 2 + 'px';
            document.body.appendChild(heart);
            setTimeout(() => heart.remove(), 1000);

            // ✅ Gửi request toggle
            try {
                const res = await fetch(`/wishlist/toggle/${productId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                if (res.status === 401) {
                    alert('🔒 Vui lòng đăng nhập để sử dụng chức năng này!');
                    window.location.href = "{{ route('login') }}";
                    return;
                }

                const data = await res.json();
                if (data.success) {
                    icon.classList.toggle('liked', data.liked);
                }
            } catch (err) {
                console.error('Lỗi yêu thích:', err);
            }

            setTimeout(() => icon.classList.remove('like-animate'), 300);
        });
    });
    </script>
</body>
</html>
