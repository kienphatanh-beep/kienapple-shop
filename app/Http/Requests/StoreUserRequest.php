<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    /**
     * Xác nhận người dùng có quyền gửi request không.
     */
    public function authorize(): bool
    {
        return true; // Cho phép gửi request
    }

    /**
     * Các quy tắc kiểm tra dữ liệu gửi lên.
     */
    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:user,email',
            'password' => 'required|string|min:6|confirmed', // phải có cả password_confirmation
            'roles'    => 'required|in:customer,admin', // Vai trò là bắt buộc
            'status'   => 'required|boolean', // Trạng thái là bắt buộc
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi.
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Mật khẩu nhập lại không khớp.',
            'roles.required' => 'Vai trò là bắt buộc.',
            'status.required' => 'Trạng thái là bắt buộc.',
        ];
    }
}
