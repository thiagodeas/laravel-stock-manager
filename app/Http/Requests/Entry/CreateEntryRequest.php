<?php

namespace App\Http\Requests\Entry;

use Illuminate\Foundation\Http\FormRequest;

class CreateEntryRequest extends FormRequest
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
            'entry_date' => 'required|date',
        ];
    }
}
