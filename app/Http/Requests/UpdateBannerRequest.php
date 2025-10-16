<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif,webp',
            'position' => 'nullable|string|max:255', // nếu có thêm vị trí hiển thị banner
            'status' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên banner không được để trống',
            'name.max' => 'Tên banner không được vượt quá 255 ký tự',
            'image.image' => 'Tệp tải lên phải là hình ảnh',
            'image.mimes' => 'Hình ảnh không đúng định dạng (jpeg, png, jpg, gif, webp)',
            'status.required' => 'Trạng thái không được để trống',
            'status.boolean' => 'Trạng thái không hợp lệ',
        ];
    }
}
