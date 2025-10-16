<x-admin-site>
    <form action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="content-wrapper">
            <!-- 🧭 Header -->
            <div class="border border-blue-100 mb-3 rounded-lg p-2 flex items-center justify-between">
                <h2 class="text-xl font-bold text-blue-600">✏️ CHỈNH SỬA SẢN PHẨM</h2>
                <div class="text-right flex gap-2">
                    <button type="submit" class="bg-green-500 px-4 py-2 cursor-pointer rounded-xl text-white hover:bg-green-600 transition">
                        <i class="fa fa-save"></i> Cập nhật
                    </button>
                    <a href="{{ route('admin.product.index') }}" class="bg-sky-500 px-4 py-2 rounded-xl text-white hover:bg-sky-600 transition">
                        <i class="fa fa-arrow-left"></i> Về danh sách
                    </a>
                </div>
            </div>

            <!-- 📋 Form chính -->
            <div class="border border-blue-100 rounded-lg p-5 bg-white">
                <div class="flex flex-col lg:flex-row gap-6">
                    <div class="basis-9/12">
                        <!-- 🔹 Tên sản phẩm -->
                        <div class="mb-4">
                            <label for="name" class="font-semibold">Tên sản phẩm</label>
                            <input type="text" name="name" id="name"
                                   value="{{ old('name', $product->name) }}"
                                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
                            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- 🔹 Chi tiết sản phẩm -->
                        <div class="mb-4">
                            <label for="detail" class="font-semibold">Chi tiết sản phẩm</label>
                            <textarea name="detail" id="detail" rows="5"
                                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ old('detail', $product->detail) }}</textarea>
                            @error('detail') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                        </div>

                        <!-- 🔹 Mô tả -->
                        <div class="mb-4">
                            <label for="description" class="font-semibold">Mô tả</label>
                            <textarea name="description" id="description" rows="3"
                                      class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $product->description) }}</textarea>
                        </div>

                        <!-- 💰 Giá bán & Giá khuyến mãi -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="price_root" class="font-semibold">Giá bán</label>
                                <input type="number" name="price_root" id="price_root"
                                       value="{{ old('price_root', $product->price_root) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div>
                                <label for="price_sale" class="font-semibold">Giá khuyến mãi</label>
                                <input type="number" name="price_sale" id="price_sale"
                                       value="{{ old('price_sale', $product->price_sale) }}"
                                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                                @error('price_sale') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <!-- 📦 Số lượng -->
                        <div class="mt-4">
                            <label for="qty" class="font-semibold">Số lượng</label>
                            <input type="number" name="qty" id="qty"
                                   value="{{ old('qty', $product->qty) }}" min="1"
                                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- 🗂️ Danh mục -->
                        <div class="mt-4">
                            <label for="category_id" class="font-semibold">Danh mục</label>
                            <select name="category_id" id="category_id"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn danh mục</option>
                                @foreach ($list_category as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🏷️ Thương hiệu -->
                        <div class="mt-4">
                            <label for="brand_id" class="font-semibold">Thương hiệu</label>
                            <select name="brand_id" id="brand_id"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                                <option value="">Chọn thương hiệu</option>
                                @foreach ($list_brand as $brand)
                                    <option value="{{ $brand->id }}"
                                        {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 🖼️ Hình ảnh -->
                        <div class="mt-4">
                            <label for="thumbnail" class="font-semibold">Hình ảnh</label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                   class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                            @if ($product->thumbnail)
                                <div class="mt-3">
                                    <img src="{{ asset('assets/images/product/' . $product->thumbnail) }}"
                                         alt="Ảnh sản phẩm"
                                         class="w-36 h-36 object-cover rounded-lg shadow border border-gray-200">
                                </div>
                            @endif
                        </div>

                        <!-- ⚙️ Trạng thái -->
                        <div class="mt-4">
                            <label for="status" class="font-semibold">Trạng thái</label>
                            <select name="status" id="status"
                                    class="w-full border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                                <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>Xuất bản</option>
                                <option value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>Không xuất bản</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- ✨ CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editors = ['#detail', '#description'];
            editors.forEach(selector => {
                ClassicEditor.create(document.querySelector(selector), {
                    ckfinder: {
                        uploadUrl: '{{ route("admin.ckeditor.upload") . "?_token=" . csrf_token() }}'
                    },
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'link', '|',
                        'bulletedList', 'numberedList', 'blockQuote', '|',
                        'insertTable', 'imageUpload', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ],
                    placeholder: selector === '#detail'
                        ? 'Nhập chi tiết sản phẩm đầy đủ, mô tả kỹ thuật...'
                        : 'Nhập mô tả ngắn cho sản phẩm...'
                }).then(editor => {
                    editor.ui.view.editable.element.style.minHeight = '250px';
                    editor.ui.view.editable.element.style.borderRadius = '8px';
                }).catch(error => console.error(error));
            });
        });
    </script>

    <style>
        .ck-editor__editable {
            border-radius: 8px !important;
            border: 1px solid #d1d5db !important;
            padding: 12px !important;
            background-color: #fff !important;
            min-height: 200px !important;
        }
        .ck-toolbar {
            border-radius: 8px 8px 0 0 !important;
            background-color: #f9fafb !important;
        }
        .ck-focused {
            border-color: #3b82f6 !important;
            box-shadow: 0 0 0 2px rgba(59,130,246,0.25) !important;
        }
    </style>
</x-admin-site>
