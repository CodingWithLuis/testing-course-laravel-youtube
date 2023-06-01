<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string'
            ],
            'price' => [
                'required',
                'numeric'
            ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre del producto es obligatorio',
            'price.numeric' => 'El precio debe ser numerico',
        ];
    }
}
