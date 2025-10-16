<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'required|unique:category,name', // thêm name vào cột cho chắc
            'slug'        => 'nullable|unique:category,slug', // slug không bắt buộc, nhưng nếu có thì phải unique
            'sort_order'  => 'required|integer',
            'parent_id'   => 'nullable|integer',
            'status'      => 'required|in:0,1',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // file hình ảnh, tối đa 2MB
            'description' => 'nullable|string|max:1000', // mô tả tối đa 1000 ký tự
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Tên danh mục không được để trống',
            'name.unique'         => 'Tên danh mục đã tồn tại',
            'slug.unique'         => 'Slug đã tồn tại',
            'sort_order.required' => 'Vị trí sắp xếp không được để trống',
            'sort_order.integer'  => 'Vị trí sắp xếp phải là số',
            'parent_id.integer'   => 'Danh mục cha không hợp lệ',
            'status.required'     => 'Trạng thái không được để trống',
            'status.in'           => 'Trạng thái không hợp lệ',
            'image.image'         => 'Tệp tải lên phải là hình ảnh',
            'image.mimes'         => 'Hình ảnh phải có định dạng jpeg, png, jpg hoặc gif',
            'image.max'           => 'Hình ảnh tối đa 2MB',
            'description.string'  => 'Mô tả phải là chuỗi',
            'description.max'     => 'Mô tả tối đa 1000 ký tự',
        ];
    }
}
