<?php

namespace App\Http\Requests;

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
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ];
    }

    public function prepareForValidation(): void
    {
        $startDate = $this->safeDate('start_date');
        $endDate = $this->safeDate('end_date');

        if ($startDate && $endDate) {
            $startDate->setTime(0, 0, 0); 
            $endDate->setTime(23, 59, 59);
        }

        $this->merge([
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    private function safeDate(?string $key): ?Carbon
    {
        $value = $this->input($key);

        if (empty($value)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d/m/Y', $value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
