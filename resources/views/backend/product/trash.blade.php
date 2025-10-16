<x-admin-site>
    <x-slot:title>
        Thùng Rác Sản Phẩm
    </x-slot:title>

    <div class="content-wrapper">
        <div class="border border-blue-100 rounded-lg p-2">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-bold text-red-600">THÙNG RÁC SẢN PHẨM</h2>
                <div class="text-right">
                    <a href="{{ route('admin.product.index') }}" class="bg-gray-500 px-2 py-2 rounded-xl mx-1 text-white">
                        <i class="fa fa-arrow-left"></i> Quay lại danh sách sản phẩm
                    </a>
                </div>
            </div>
        </div>

        <div class="border border-blue-100 rounded-lg p-2 mt-3">
            <table class="border-collapse border border-gray-400 w-full">
                <thead>
                    <tr>
                        <th class="border border-gray-300 p-2 w-20">ID</th>
                        <th class="border border-gray-300 p-2">Tên sản phẩm</th>
                        <th class="border border-gray-300 p-2">Slug</th>
                        <th class="border border-gray-300 p-2">Đã xóa lúc</th>
                        <th class="border border-gray-300 p-2">Chức năng</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr>
                            <td class="border border-gray-300 p-2 text-center">{{ $product->id }}</td>
                            <td class="border border-gray-300 p-2">{{ $product->name }}</td>
                            <td class="border border-gray-300 p-2">{{ $product->slug }}</td>
                            <td class="border border-gray-300 p-2">{{ $product->deleted_at }}</td>
                            <td class="border border-gray-300 p-2 text-center">
                                <a href="{{ route('admin.product.restore', $product->id) }}" 
                                   class="text-green-600 mx-1 hover:underline">Khôi phục</a>
                                <form action="{{ route('admin.product.forceDelete', $product->id) }}" 
                                      method="POST" class="inline-block" 
                                      onsubmit="return confirm('Xóa vĩnh viễn sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        <i class="fa fa-trash"></i> Xóa vĩnh viễn
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 p-4">Không có sản phẩm nào trong thùng rác.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-admin-site>
