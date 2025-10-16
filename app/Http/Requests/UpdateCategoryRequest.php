<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'       => 'required',
            'sort_order' => 'required|integer',
            'parent_id'  => 'nullable|integer',
            'status'     => 'required|in:0,1',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'        => 'Tên danh mục không được để trống',
            'sort_order.required'  => 'Vị trí sắp xếp bắt buộc nhập',
            'sort_order.integer'   => 'Vị trí sắp xếp phải là số nguyên',
            'parent_id.integer'    => 'Danh mục cha không hợp lệ',
            'status.required'      => 'Trạng thái bắt buộc chọn',
            'status.in'            => 'Trạng thái không hợp lệ',
        ];
    }
}
