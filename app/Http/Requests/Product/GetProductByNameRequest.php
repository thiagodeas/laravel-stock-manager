<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class GetProductByNameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }
}
