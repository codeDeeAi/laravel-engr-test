<?php

namespace App\Http\Requests\v1\Providers;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'provider' => ['required', 'string', 'max:100'],
            'hmo_code' => ['bail', 'required', 'exists:hmos,code'],
            'encounter_date' => ['bail', 'required', 'date'],
            'total_items_cost' => ['bail', 'required', 'numeric'],
            'items' => ['bail', 'required', 'array', 'min:1'],
            'items.*.name' => ['required', 'string'],
            'items.*.unit_price' => ['required', 'numeric', 'min:1'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.sub_total' => ['required', 'numeric'],
        ];
    }
}
