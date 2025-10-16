@extends('components.layout-user')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="container mx-auto px-4 py-6" 
     x-data="{ openSort:false, openCategory:false, openBrand:false, openPrice:false }">

    <!-- 🔹 Thanh tiêu đề -->
    <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
        <h1 class="text-yellow-900 text-xl font-extrabold drop-shadow">
            {{ request('q') ? 'Kết quả cho: “' . e(request('q')) . '”' : 'Tất cả sản phẩm' }}
        </h1>
        <span class="text-yellow-700 text-sm">{{ $product_list->total() }} sản phẩm</span>
    </div>

    <!-- 🔸 Thanh lọc & sắp xếp -->
    <div class="flex flex-wrap items-center gap-5 text-sm font-medium mb-6 border-b border-gray-200 pb-3 relative z-40">

        <!-- 🔹 Sắp xếp -->
        <div class="relative" @click.away="openSort=false">
            <button @click="openSort=!openSort"
                class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 hover:bg-yellow-50 transition shadow-sm hover:shadow-md hover:scale-[1.03]
                    {{ request('sort') ? 'text-yellow-700 border-yellow-400 bg-yellow-50' : 'text-gray-700' }}">
                <i class="fa-solid fa-arrow-down-short-wide"></i> 
                <span>Sắp xếp</span>
                <i class="fa-solid fa-chevron-down text-xs ml-1 transition" :class="{ 'rotate-180': openSort }"></i>
            </button>

            <div x-show="openSort" x-transition.origin.top.right
                class="absolute mt-2 w-48 bg-white border border-gray-200 rounded-xl shadow-lg overflow-hidden">
                @foreach([
                    'featured' => 'Nổi bật',
                    'bestseller' => 'Bán chạy',
                    'discount' => 'Giảm giá',
                    'newest' => 'Mới',
                    'price_asc' => 'Giá thấp - cao',
                    'price_desc' => 'Giá cao - thấp'
                ] as $key => $label)
                    <a href="{{ route('site.product', ['sort' => $key] + request()->except('page')) }}"
                       class="block px-4 py-2 hover:bg-yellow-50 transition-all 
                              {{ request('sort')==$key ? 'text-yellow-600 font-semibold bg-yellow-50' : 'text-gray-700' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

    <!-- 🔹 Lọc danh mục -->
<div class="relative" @click.away="openCategory=false">
    <button @click="openCategory=!openCategory"
        class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 hover:bg-yellow-50 transition shadow-sm hover:shadow-md hover:scale-[1.03]
            {{ request('category_slug') ? 'text-yellow-700 border-yellow-400 bg-yellow-50' : 'text-gray-700' }}">
        <i class="fa-solid fa-layer-group"></i> 
        <span>{{ request('category_slug') ? $category_list->firstWhere('slug', request('category_slug'))->name : 'Danh mục' }}</span>
        <i class="fa-solid fa-chevron-down text-xs ml-1 transition" :class="{ 'rotate-180': openCategory }"></i>
    </button>

    <div x-show="openCategory" x-transition.origin.top.left
        class="absolute mt-2 w-[360px] bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden p-3 grid grid-cols-2 gap-3">
        @foreach($category_list as $cat)
            <a href="{{ route('site.product', ['category_slug'=>$cat->slug] + request()->except('page')) }}"
               class="group flex flex-col items-center justify-center gap-2 py-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-yellow-50 transition-all duration-200 hover:shadow-md hover:scale-[1.03]
                      {{ request('category_slug')==$cat->slug ? 'border-yellow-400 bg-yellow-50 shadow-md text-yellow-700' : 'text-gray-700' }}">
                <img src="{{ asset('assets/images/category/' . ($cat->image ?? 'default.png')) }}" 
                     class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110" 
                     alt="{{ $cat->name }}">
                <span class="text-xs font-semibold text-center px-2 leading-tight line-clamp-2">{{ $cat->name }}</span>
            </a>
        @endforeach
    </div>
</div>

<!-- 🔹 Lọc thương hiệu -->
<div class="relative" @click.away="openBrand=false">
    <button @click="openBrand=!openBrand"
        class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 hover:bg-yellow-50 transition shadow-sm hover:shadow-md hover:scale-[1.03]
            {{ request('brand_slug') ? 'text-yellow-700 border-yellow-400 bg-yellow-50' : 'text-gray-700' }}">
        <i class="fa-solid fa-tags"></i> 
        <span>{{ request('brand_slug') ? $brand_list->firstWhere('slug', request('brand_slug'))->name : 'Thương hiệu' }}</span>
        <i class="fa-solid fa-chevron-down text-xs ml-1 transition" :class="{ 'rotate-180': openBrand }"></i>
    </button>

    <div x-show="openBrand" x-transition.origin.top.left
        class="absolute mt-2 w-[360px] bg-white border border-gray-200 rounded-xl shadow-2xl overflow-hidden p-3 grid grid-cols-2 gap-3">
        @foreach($brand_list as $brand)
            <a href="{{ route('site.product', ['brand_slug'=>$brand->slug] + request()->except('page')) }}"
               class="group flex flex-col items-center justify-center gap-2 py-3 rounded-xl border border-gray-100 bg-gray-50 hover:bg-yellow-50 transition-all duration-200 hover:shadow-md hover:scale-[1.03]
                      {{ request('brand_slug')==$brand->slug ? 'border-yellow-400 bg-yellow-50 shadow-md text-yellow-700' : 'text-gray-700' }}">
                <img src="{{ asset('assets/images/brand/' . ($brand->image ?? 'default.png')) }}" 
                     class="w-10 h-10 object-contain transition-transform duration-200 group-hover:scale-110" 
                     alt="{{ $brand->name }}">
                <span class="text-xs font-semibold text-center px-2 leading-tight line-clamp-2">{{ $brand->name }}</span>
            </a>
        @endforeach
    </div>
</div>


        <!-- 🔹 Lọc giá -->
        <div class="relative" @click.away="openPrice=false">
            <button @click="openPrice=!openPrice"
                class="flex items-center gap-1 px-3 py-1.5 rounded-lg bg-gray-50 border border-gray-200 hover:bg-yellow-50 transition shadow-sm hover:shadow-md hover:scale-[1.03]
                    {{ request('min_price')||request('max_price') ? 'text-yellow-700 border-yellow-400 bg-yellow-50' : 'text-gray-700' }}">
                <i class="fa-solid fa-money-bill-wave"></i> 
                <span>Khoảng giá</span>
                <i class="fa-solid fa-chevron-down text-xs ml-1 transition" :class="{ 'rotate-180': openPrice }"></i>
            </button>

            <form x-show="openPrice" x-transition.origin.top.left method="GET"
                  action="{{ route('site.product') }}"
                  class="absolute mt-2 bg-white border border-gray-200 rounded-xl shadow-lg p-4 w-64 space-y-3">
                <div class="flex items-center gap-2">
                    <input type="number" name="min_price" placeholder="Từ" value="{{ request('min_price') }}"
                        class="w-1/2 border rounded-lg text-sm px-2 py-1 focus:ring-yellow-500 focus:border-yellow-500" min="0">
                    <input type="number" name="max_price" placeholder="Đến" value="{{ request('max_price') }}"
                        class="w-1/2 border rounded-lg text-sm px-2 py-1 focus:ring-yellow-500 focus:border-yellow-500" min="0">
                </div>
                <button type="submit"
                        class="w-full bg-gradient-to-r from-yellow-400 to-yellow-600 text-white text-sm font-semibold py-1.5 rounded-lg shadow hover:scale-[1.02] transition">
                    Áp dụng
                </button>
            </form>
        </div>

        <!-- Nút reset -->
        @if(request()->anyFilled(['sort','category_slug','brand_slug','min_price','max_price']))
            <a href="{{ route('site.product') }}" 
               class="text-gray-500 hover:text-red-500 transition text-sm flex items-center gap-1 ml-auto">
               <i class="fa-solid fa-xmark"></i> Xóa bộ lọc
            </a>
        @endif
    </div>

    <!-- 🛒 Danh sách sản phẩm -->
    <div class="bg-yellow-100 p-6 rounded-2xl shadow-lg border border-yellow-300 animate-fadeIn">
        @if ($product_list->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                @foreach ($product_list as $product)
                    @php
                        $sold = $product->sold ?? 0;
                        $stock = $product->stock ?? 0;
                        $total = max($sold + $stock, 1);
                        $soldPercent = min(100, round(($sold / $total) * 100));
                    @endphp

                    <div class="card relative min-w-[260px] max-w-[260px] bg-white rounded-2xl border shadow-sm p-3 flex flex-col
                        {{ $product->is_liked ? 'border-red-400 shadow-[0_0_15px_rgba(255,0,0,0.2)]' : 'border-gray-200' }}">
                        
                        @if($product->is_liked)
                            <div class="liked-badge absolute top-2 right-2 bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded-full shadow-md animate-pulse">
                                ❤️ Đã yêu thích
                            </div>
                        @endif

                        <a href="{{ route('site.product_detail', ['slug' => $product->slug]) }}" class="block">
                            <div class="relative">
                                <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                                     alt="{{ $product->name }}"
                                     class="w-full h-40 object-contain rounded-xl bg-gray-50 transition-transform duration-300 hover:scale-105" />
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

                            <div class="mt-3">
                                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                                    <div class="h-3 bg-yellow-500 transition-all duration-500"
                                         style="width: {{ $soldPercent }}%;"></div>
                                </div>
                                <div class="mt-1 text-xs text-gray-500">
                                    Đã bán {{ $sold }} / Còn {{ $stock }} sản phẩm
                                </div>
                            </div>

                            <div class="mt-3 flex gap-2">
                                <a href="{{ route('site.product_detail', ['slug' => $product->slug]) }}"
                                   class="flex-1 py-2 rounded-full text-center font-semibold transition
                                        {{ $stock > 0
                                            ? 'bg-yellow-600 text-white hover:bg-yellow-700'
                                            : 'bg-gray-400 text-white cursor-not-allowed' }}">
                                    {{ $stock > 0 ? 'Mua ngay' : 'Hết hàng' }}
                                </a>

                                <button class="like-btn w-10 h-10 rounded-full border flex items-center justify-center text-yellow-600 hover:bg-yellow-50"
                                        data-id="{{ $product->id }}">
                                    <i class="fa fa-heart {{ $product->is_liked ? 'liked' : '' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">{{ $product_list->links() }}</div>
        @else
            <div class="text-yellow-700 text-center font-medium py-10 animate-pulse">
                Không tìm thấy sản phẩm nào 😢
            </div>
        @endif
    </div>
</div>

<style>
.card { transition: transform .25s ease, box-shadow .25s ease; }
.card:hover { transform: translateY(-8px); }
.animate-fadeIn { animation: fadeIn 0.6s ease-out; }
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
@endsection
