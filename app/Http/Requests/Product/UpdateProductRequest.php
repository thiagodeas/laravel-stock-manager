<?php

namespace App\Http\Requests\Product;

use App\Rules\Product\ProductValidationRules;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     type="object",
 *     required={"name", "price", "stock"},
 *     properties={
 *         @OA\Property(property="name", type="string", example="Updated Laptop"),
 *         @OA\Property(property="price", type="number", format="float", example=1600.00),
 *         @OA\Property(property="stock", type="integer", example=120)
 *     }
 * )
 */

class UpdateProductRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return ProductValidationRules::updateRules();
    }
}
