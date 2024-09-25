<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'company_id' => 'required|exists:companies,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名は必須項目です。',
            'company_id.required' => 'メーカー名は必須項目です。',
            'price.required' => '価格は必須項目です。',
            'stock.required' => '在庫数は必須項目です。',
        ];
    }
}
