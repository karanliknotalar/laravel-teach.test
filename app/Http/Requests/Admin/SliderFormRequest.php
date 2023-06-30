<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Route;

class SliderFormRequest extends FormRequest
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
        if (Route::is("slider.update")) {

            if (count($this->all()) != 2) {

                return [
                    "name" => "required",
                    "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ];

            } else {
                return [];
            }
        }

        return [
            "name" => "required",
            "image" => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ];
    }
}
