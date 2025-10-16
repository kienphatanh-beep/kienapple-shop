<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true; // Cho phép request
    }

    /**
     * Luật kiểm tra dữ liệu nhập vào.
     */
    public function rules(): array
{
    return [
        'name' => 'required|string|max:255',
'slug' => 'required|string|max:255|unique:topic,slug,',        'description' => 'nullable|string|max:1000', // ✅ thêm mô tả
        'status' => 'required|in:0,1',                // ✅ thêm trạng thái
    ];
}


    /**
     * Tuỳ chỉnh thông báo lỗi (không bắt buộc)
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên chủ đề không được để trống.',
            'name.max' => 'Tên chủ đề quá dài.',
            'slug.unique' => 'Slug đã tồn tại.',
        ];
    }
}