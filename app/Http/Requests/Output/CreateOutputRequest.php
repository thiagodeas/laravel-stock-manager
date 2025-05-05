<?php

namespace App\Http\Requests\Output;

use Illuminate\Foundation\Http\FormRequest;

class CreateOutputRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => 'required|string|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'reason' => 'required|string',
        ];
    }
}
