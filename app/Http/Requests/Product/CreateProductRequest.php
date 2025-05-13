<?php

namespace App\Http\Requests\Product;

use App\Rules\Product\ProductValidationRules;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateProductRequest",
 *     type="object",
 *     required={"name", "category_id", "price", "stock"},
 *     properties={
 *         @OA\Property(property="name", type="string", example="Laptop"),
 *         @OA\Property(property="category_id", type="string", example="1"),
 *         @OA\Property(property="price", type="number", format="float", example=1500.00),
 *         @OA\Property(property="stock", type="integer", example=100)
 *     }
 * )
 */

class CreateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ProductValidationRules::createRules();
    }
}
