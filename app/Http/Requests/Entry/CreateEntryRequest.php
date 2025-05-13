<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="CreateEntryRequest",
 *     type="object",
 *     required={"product_id", "quantity"},
 *     properties={
 *         @OA\Property(property="product_id", type="string", example="1"),
 *         @OA\Property(property="quantity", type="integer", example=50)
 *     }
 * )
 */

class CreateEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'reason' => [
                'required',
                'string',
                Rule::in(['Compra', 'Devolução de Venda', 'Ajuste', 'Troca', 'Doação/Bonificação']),
            ],
        ];
    }
}
