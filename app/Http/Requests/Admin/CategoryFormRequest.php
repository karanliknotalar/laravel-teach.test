<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CategoryFormRequest extends FormRequest
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
        if (Route::is("category.update")) {

            if (count($this->all()) != 2) {

                return [
                    "name" => "required",
                    "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                    "categoryType" => "required",
                    "status" => "required",
                ];

            } else {
                return [];
            }
        }

        return [
            "name" => "required",
            "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
    }
}
