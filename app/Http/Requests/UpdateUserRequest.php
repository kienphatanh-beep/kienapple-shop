<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; // ✅ THÊM DÒNG NÀY

class UpdateUserRequest extends FormRequest
{
    /**
     * Cho phép tất cả người dùng thực hiện request này.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Các quy tắc kiểm tra dữ liệu.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'position' => 'required|in:mainmenu,footer',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user),
            ],
            'roles' => 'required',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'roles.required' => 'Vui lòng chọn vai trò.',
            'roles.in' => 'Vai trò không hợp lệ.',
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.boolean' => 'Trạng thái không hợp lệ.',
        ];
    }
}
