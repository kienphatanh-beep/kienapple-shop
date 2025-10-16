<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBrandRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:brand,slug,' . $this->route('brand'),
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên thương hiệu không được để trống',
            'name.max' => 'Tên thương hiệu quá dài',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn slug khác',
            'image.image' => 'File tải lên phải là hình ảnh',
            'image.mimes' => 'Định dạng ảnh không hợp lệ (chỉ chấp nhận jpeg, png, jpg, gif, webp)',
        ];
    }
}
