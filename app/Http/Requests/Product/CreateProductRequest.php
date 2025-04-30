<?php

namespace App\Http\Requests;

use App\Rules\Product\ProductValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ProductValidationRules::rules();
    }
}
