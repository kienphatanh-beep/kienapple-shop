<x-admin-site>
<div class="p-6 animate-fade-in">
    <div class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2">
            <div class="p-6 flex justify-center items-center bg-gray-50">
                <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                     alt="{{ $product->name }}"
                     class="rounded-xl w-80 h-80 object-cover shadow-md">
            </div>
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ $product->name }}</h2>

                <div class="space-y-2 text-gray-700">
                    <p><strong>Slug:</strong> {{ $product->slug }}</p>
                    <p><strong>Danh mục:</strong> {{ $product->category->name }}</p>
                    <p><strong>Thương hiệu:</strong> {{ $product->brand->name }}</p>
                    <p><strong>Giá gốc:</strong> {{ number_format($product->price_root, 0, ',', '.') }} đ</p>
                    <p><strong>Giá khuyến mãi:</strong> {{ number_format($product->price_sale, 0, ',', '.') }} đ</p>
                    <p><strong>Số lượng:</strong> {{ $product->qty }}</p>
                    <p><strong>Trạng thái:</strong> 
                        <span class="{{ $product->status ? 'text-green-600' : 'text-red-600' }}">
                            {{ $product->status ? 'Hiển thị' : 'Ẩn' }}
                        </span>
                    </p>
                    <p><strong>Mô tả ngắn:</strong> {{ $product->description }}</p>
                    <p><strong>Chi tiết:</strong></p>
                    <div class="prose max-w-none">{!! $product->detail !!}</div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.product.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg">
                        ← Quay lại
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</x-admin-site>
