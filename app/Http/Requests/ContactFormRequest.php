<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactFormRequest extends FormRequest
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
            "firstname" => "required|string|min:3",
            "lastname" => "required|string|min:2",
            "email" => "required|email",
            "subject" => "required|string|min:5",
            "message" => "required|min:25"
        ];
    }
    public function messages(): array
    {
        return [
            "firstname.required" => "İsim alanı zorunludur!",
            "firstname.min" => "İsim minimum 3 karakter olabilir!",
            "lastname.required" => "Soyisim alanı zorunludur!",
            "lastname.min" => "Soyisim minimum 2 karakter olabilir!",
            "email.required" => "Email alanı zorunludur!",
            "email.email" => "Geçersiz email formatı!",
            "subject.required" => "Konut alanı zorunludur!",
            "subject.min" => "Konu minimum 5 karakter olabilir!",
            "message.required" => "Mesaj alanı zorunludur!",
            "message.min" => "Mesaj minimum 25 karakter olabilir!"
        ];
    }
}
