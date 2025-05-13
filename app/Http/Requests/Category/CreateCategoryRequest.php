<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="CreateCategoryRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", maxLength=255, example="Electronics")
 * )
 */

class CreateCategoryRequest extends FormRequest
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