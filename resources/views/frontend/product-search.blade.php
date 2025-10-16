@extends('components.layout-user')

@section('title', 'Tìm kiếm sản phẩm')

@section('content')
  <div class="container mx-auto px-4 py-6">
      <div class="bg-yellow-100 p-6 rounded-2xl shadow-lg border border-yellow-300">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-yellow-900 text-xl font-bold">
                    Kết quả tìm kiếm {{ $q ? 'cho: “' . e($q) . '”' : '' }}
                </h1>
                <span class="text-yellow-700 text-sm">
                    {{ $products->total() }} sản phẩm
                </span>
            </div>

            @if ($products->count())
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach ($products as $p)
                        <a href="{{ route('site.product_detail', ['slug' => $p->slug]) }}"
                           class="bg-yellow-50 rounded-xl p-3 hover:bg-yellow-200 transition block border border-yellow-200">
                            <div class="aspect-[4/3] bg-yellow-200 rounded-lg overflow-hidden">
                                <img src="{{ asset('assets/images/product/' . $p->thumbnail) }}"
                                     alt="{{ $p->name }}"
                                     class="w-full h-full object-cover">
                            </div>
                            <div class="mt-3">
                                <p class="text-yellow-900 font-semibold line-clamp-2">{{ $p->name }}</p>
                                @if (!empty($p->price_sale))
                                    <p class="text-orange-500 font-bold mt-1">
                                        {{ number_format($p->price_sale, 0, ',', '.') }}đ
                                    </p>
                                    <p class="text-yellow-700 line-through text-sm">
                                        {{ number_format($p->price_root, 0, ',', '.') }}đ
                                    </p>
                                @else
                                    <p class="text-orange-500 font-bold mt-1">
                                        {{ number_format($p->price_root ?? $p->price, 0, ',', '.') }}đ
                                    </p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-yellow-700">
                    Không tìm thấy sản phẩm nào{{ $q ? ' cho “' . e($q) . '”' : '' }}.
                </div>
            @endif
        </div>
    </div>
@endsection
