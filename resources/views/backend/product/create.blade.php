<x-admin-site>
    <form action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="content-wrapper">
            <div class="border border-gray-600 mb-3 rounded-lg p-4 max-w-3xl mx-auto">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-blue-600">THÊM SẢN PHẨM</h2>
                    <div class="text-right">
                        <button type="submit" class="bg-green-500 px-2 py-2 cursor-pointer rounded-xl mx-1 text-white">
                            <i class="fa fa-save" aria-hidden="true"></i> Lưu
                        </button>
                        <a href="{{ route('admin.product.index') }}" class="bg-sky-500 px-2 py-2 rounded-xl mx-1 text-white">
                            <i class="fa fa-arrow-left" aria-hidden="true"></i> Về danh sách
                        </a>
                    </div>
                </div>
            </div>


            <div class="border border-gray-600 rounded-lg p-4 max-w-3xl mx-auto">
                <div class="flex gap-6">
                    <div class="basis-2/3">
                        <div class="mb-3">
                            <label for="name"><strong>Tên sản phẩm</strong></label>
                            <input value="{{ old('name') }}" type="text"
                                class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2"
                                placeholder="Nhập tên sản phẩm" name="name" id="name">
                            @if ($errors->has('name'))
                                <div class="text-red-500">{{ $errors->first('name') }}</div>
                            @endif

                        </div>

                        <div class="mb-3">
                            <label for="detail"><strong>Chi tiết sản phẩm</strong></label>
                            <textarea name="detail" id="detail" rows="4"
                                class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2">{{ old('detail') }}</textarea>
                                @if ($errors->has('detail'))
                                <div class="text-red-500">{{ $errors->first('detail') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="description"><strong>Mô tả</strong></label>
                            <textarea name="description" id="description"
                                class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2">{{ old('description') }}</textarea>
                                @if ($errors->has('description'))
                                <div class="text-red-500">{{ $errors->first('description') }}</div>
                            @endif
                        </div>

                        <div class="flex justify-between gap-5">
                            <div class="mb-3 w-1/3">
                                <strong>Giá bán</strong>
                                <input value="{{ old('price_root') }}" type="text"
                                    class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2"
                                    name="price_root">
                                    @if ($errors->has('price_root'))
                                    <div class="text-red-500">{{ $errors->first('price_root') }}</div>
                                @endif
                            </div>
                            <div class="mb-3 w-1/3">
                                <strong>Giá khuyến mãi</strong>
                                <input value="{{ old('price_sale') }}" type="text"
                                    class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2"
                                    name="price_sale">
                                    @if ($errors->has('price_sale'))
                                    <div class="text-red-500">{{ $errors->first('price_sale') }}</div>
                                @endif
                            </div>
                            <div class="mb-3 w-1/3">
                                <strong>Số lượng</strong>
                                <input value="{{ old('qty', 1) }}" type="number"
                                    class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2"
                                    name="qty">
                            </div>
                        </div>
                    </div>
                    <div class="basis-1/3">
                        <div class="mb-3">
                            <label for="category_id"><strong>Danh mục</strong></label>
                            <select name="category_id" id="category_id" class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2">
                                <option value="">Chọn danh mục</option>
                                @foreach($list_category as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <div class="text-red-500">{{ $errors->first('category_id') }}</div>
                            @endif
                        </div>
                        
                        <div class="mb-3">
                            <label for="brand_id"><strong>Thương hiệu</strong></label>
                            <select name="brand_id" id="brand_id" class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2">
                                <option value="">Chọn thương hiệu</option>
                                @foreach($list_brand as $brand)
                                    <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
                                        {{ $brand->name }}
                                    </option>
                                @endforeach
                            </select>
                        
                            @if ($errors->has('brand_id'))
                                <div class="text-red-500">{{ $errors->first('brand_id') }}</div>
                            @endif
                        </div>
                        

                        <div class="mb-3">
                            <label for="thumbnail"><strong>Hình</strong></label>
                            <input type="file" name="thumbnail" id="thumbnail"
                                class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2"
                                value="{{ old('thumbnail') }}">
                        </div>

                        <div class="mb-3">
                            <label for="status"><strong>Trạng thái</strong></label>
                            <select name="status" id="status"
                                class="w-full border border-gray-600 bg-gray-800 text-white rounded-lg p-2">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Xuất bản</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 text-gray-500">
                Thiết kế bởi: Trần Trung Kiên
            </div>
        </div>
    </form>
    <!-- 📦 CKEditor 5 Classic -->
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.1/classic/ckeditor.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const editors = ['#detail', '#description'];

    editors.forEach(selector => {
        ClassicEditor
            .create(document.querySelector(selector), {
                ckfinder: {
                    uploadUrl: '{{ route("admin.ckeditor.upload")."?_token=".csrf_token() }}'
                },
                toolbar: [
                    'heading', '|',
                    'bold', 'italic', 'underline', 'link', '|',
                    'bulletedList', 'numberedList', 'blockQuote', '|',
                    'insertTable', 'imageUpload', 'mediaEmbed', '|',
                    'undo', 'redo'
                ],
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Đoạn văn', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Tiêu đề 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Tiêu đề 2', class: 'ck-heading_heading2' }
                    ]
                },
                placeholder: selector === '#detail'
                    ? 'Nhập chi tiết sản phẩm (mô tả đầy đủ, thông số kỹ thuật...)'
                    : 'Nhập mô tả ngắn cho sản phẩm...'
            })
            .then(editor => {
                editor.ui.view.editable.element.style.minHeight = '250px';
                editor.ui.view.editable.element.style.borderRadius = '8px';
            })
            .catch(error => console.error(error));
    });
});
</script>

<style>
.ck-editor__editable {
    border-radius: 8px !important;
    border: 1px solid #d1d5db !important;
    padding: 12px !important;
    min-height: 200px !important;
    background-color: #fff !important;
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
