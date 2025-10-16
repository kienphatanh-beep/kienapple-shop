<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:product',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'detail' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'price_root' => 'required',
            'price_sale' => 'required',
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không để trống',
            'name.unique' => 'Tên đã tồn tại',
            'thumbnail.image' => 'Không phải hình ảnh',
            'thumbnail.mimes' => 'Định dạng tập tin không đúng',
            'detail.required' => 'Chi tiết không để trống',
            'category_id.required' => 'Chưa chọn danh mục',
            'brand_id.required' => 'Chưa chọn thương hiệu',
            'price_root.required' => 'Giá bán không để trống',
            'price_sale.required' => 'Giá khuyến mãi không để trống',
        ];
    }
}