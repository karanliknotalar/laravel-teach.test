<?php

namespace App\Http\Requests;

use App\Rules\IsSelected;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class InvoiceRequest extends FormRequest
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
            'country' => [new IsSelected(), "required"],
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'company_name' => 'required|string',
            'address' => 'required|string',
            'province' => 'required|string',
            'district' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'password' => $this->getPasswordRule(),
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':attribute alanı zorunludur.',
            'email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.min' => 'Parola en az :min karakter olmalıdır.',
            'string' => ':attribute alanı metin türünde olmalıdır.',
        ];
    }

    public function attributes(): array
    {
        return [
            'country' => 'Ülke',
            'f_name' => 'Ad',
            'l_name' => 'Soyad',
            'company_name' => 'Firma Adı',
            'address' => 'Adres',
            'province' => 'İl',
            'district' => 'İlçe',
            'email' => 'Email',
            'phone' => 'Telefon',
            'password' => 'Hesap Şifresi',
        ];
    }

    protected function getPasswordRule(): string
    {
        if (!Auth::user()) {
            return 'required|min:8';
        }
        return 'nullable|min:8';
    }
}
