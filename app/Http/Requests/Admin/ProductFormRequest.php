<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumericOrDecimal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class ProductFormRequest extends FormRequest
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
        if (Route::is("product.update")) {

            return [
                "name" => "required|min:5",
                "product_code" => "required",
                "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                "description" => 'required|min:25',
                "sort_description" => 'required|min:15',
                "category_id" => 'required|numeric'
            ];
        }

        return [
            "product_code" => "required",
            "name" => "required|min:5",
            "image" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            "description" => 'required|min:25',
            "sort_description" => 'required|min:15',
            "size.*" => 'required|min:1',
            "color.*" => 'required|min:1',
            "price.*" => ['required',
                'min:1',
                new NumericOrDecimal()],
            "quantity.*" => 'required|min:1|numeric',
            "category_id" => 'required|numeric',
        ];
    }
}
