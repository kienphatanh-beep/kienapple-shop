<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    /**
     * Cho phép thực hiện request này.
     */
    public function authorize(): bool
    {
        return true; // Cho phép mọi user (hoặc tuỳ theo phân quyền sau này)
    }

    /**
     * Các quy tắc kiểm tra dữ liệu đầu vào.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'    => 'required|string|max:255',
            'phone'   => 'required|string|max:20',
            'email'   => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'note'    => 'nullable|string|max:1000',
            'status'  => 'nullable|boolean',
        ];
    }

    /**
     * Tùy chỉnh thông báo lỗi (nếu muốn).
     */
    public function messages(): array
    {
        return [
            'name.required'    => 'Vui lòng nhập tên khách hàng.',
            'phone.required'   => 'Vui lòng nhập số điện thoại.',
            'email.email'      => 'Email không hợp lệ.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
        ];
    }
}
