<?php

namespace App\Http\Requests\Entry;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class GetByDateRangeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ];
    }

    public function prepareForValidation():void
    {
        if ($this->has('start_date')) {
            $this->merge([
                'start_date' => Carbon::createFromFormat('d/m/Y', $this->input('start_date'))->startOfDay(),
            ]);
        }

        if ($this->has('end_date')) {
            $this->merge([
                'end_date' => Carbon::createFromFormat('d/m/Y', $this->input('end_date'))->endOfDay(),
            ]);
        }
    }
}
