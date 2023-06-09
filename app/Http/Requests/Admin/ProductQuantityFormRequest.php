<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumericOrDecimal;
use Illuminate\Foundation\Http\FormRequest;

class ProductQuantityFormRequest extends FormRequest
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
            "price.*" => ['required',
                'min:1',
                new NumericOrDecimal()],
            "size.*" => 'required|min:1',
            "color.*" => 'required|min:1',
            "quantity.*" => 'required|min:1|numeric',
            "product_id" => "required",
        ];
    }
}
