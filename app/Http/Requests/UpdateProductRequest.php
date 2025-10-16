<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('product'); // lấy id từ route

        return [
            'name'        => 'required|string|max:255',
            'slug'        => 'required|string|unique:products,slug,' . $id,
            'price'       => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'brand_id'    => 'nullable|exists:brands,id',
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'status'      => 'required|in:0,1',
        ];
    }
}
