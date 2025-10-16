<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'type' => 'required|in:custom,category,brand,page,topic',
            'table_id' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|integer|min:0',
            'position' => 'required|in:mainmenu,footer',
            'status' => 'required|boolean',
        ];
    }
}

