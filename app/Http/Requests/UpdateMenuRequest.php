<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'position' => 'required|in:mainmenu,footer', // hoặc điều chỉnh các giá trị tùy vào dự án
            'parent_id' => 'nullable|integer',
            'status' => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên menu không được để trống',
            'link.string' => 'Liên kết phải là chuỗi',
            'position.required' => 'Vị trí menu là bắt buộc',
            'position.in' => 'Vị trí không hợp lệ',
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }
}
