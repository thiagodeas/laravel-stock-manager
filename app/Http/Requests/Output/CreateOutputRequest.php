<?php

namespace App\Http\Requests\Output;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateOutputRequest extends FormRequest
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
                Rule::in(['Venda', 'Roubo/Furto', 'Devolução', 'Ajuste', 'Produto Vencido']),
            ],
        ];
    }
}
