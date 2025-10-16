<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTopicRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ];
    }
    
    public function messages(): array
    {
        return [
            'name.required' => 'Tên chủ đề không được để trống',
            'name.string' => 'Tên chủ đề phải là chuỗi',
            'name.max' => 'Tên chủ đề không được vượt quá 255 ký tự',
            'status.required' => 'Trạng thái là bắt buộc',
            'status.in' => 'Trạng thái không hợp lệ',
        ];
    }
    
    
}
