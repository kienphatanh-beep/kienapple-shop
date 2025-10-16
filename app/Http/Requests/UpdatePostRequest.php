<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Xác định người dùng có quyền gửi yêu cầu này không.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các luật kiểm tra dữ liệu đầu vào.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
            'detail' => 'required',
            'topic_id' => 'required',
        ];
    }

    /**
     * Thông báo lỗi tùy chỉnh cho các rule.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tên không để trống',
            'thumbnail.image' => 'Không phải hình ảnh',
            'thumbnail.mimes' => 'Định dạng tập tin không đúng',
            'detail.required' => 'Chi tiết không để trống',
            'topic_id.required' => 'Chưa chọn topic',
        ];
    }
}
