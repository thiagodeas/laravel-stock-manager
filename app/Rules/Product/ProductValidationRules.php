<?php

namespace App\Rules\Product;

class ProductValidationRules
{
    public static function createRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0.01',
        ];
    }

    public static function updateRules(): array
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'price' => 'sometimes|required|numeric|min:0.01',
        ];
    }
}
