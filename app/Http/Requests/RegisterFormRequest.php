<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
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
            "name" => "required|min:5",
            "email" => "required|email",
            "password" => "required|min:8|confirmed",
            "agreement" => "required",
        ];
    }
    public function messages(): array
    {
        return [
            "email.required" => "Email alanı zorunludur!",
            "email.email" => "Geçersiz email formatı!",
            "password.required" => "Parola alanı zorunludur!",
            "agreement" => "Sözleşmeyi kabul etmediniz!",
            "name.required" => "İsim alanı zorunludur!",
            "name.min" => "İsim minimum 5 karakter olabilir!",
        ];
    }
}
