<?php

namespace App\Http\Requests\Admin;

use App\Rules\NumericOrDecimal;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CouponRequest extends FormRequest
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
        if (count($this->all()) != 2) {

            return [
                "name" => "required|min:3",
                "price" => ['required',
                    'min:1',
                    new NumericOrDecimal()],
                "expired_at" => 'required|date:Y-m-d H:i',
            ];

        } else {
            return [];
        }
    }
}
