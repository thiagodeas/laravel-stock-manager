<?php

namespace App\Rules\Product;

class ProductValidationRules
{
    public static function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0.01',
        ];
    }
}
