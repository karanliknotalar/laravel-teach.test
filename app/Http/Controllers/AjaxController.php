<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Contact;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Controller;
use Request;

class AjaxController extends Controller
{
    public function contact_post(ContactFormRequest $request)
    {
//        $request->validate([
//            "firstname" => "required|string|min:3",
//            "lastname" => "required|string|min:2",
//            "email" => "required|email",
//            "subject" => "required|string|min:5",
//            "message" => "required|string|min:25"
//        ], [
//            "firstname.required" => "İsim alanı zorunludur!",
//            "firstname.min" => "İsim minimum 3 karakter olabilir!",
//            "lastname.required" => "Soyisim alanı zorunludur!",
//            "lastname.min" => "Soyisim minimum 2 karakter olabilir!",
//            "email.required" => "Email alanı zorunludur!",
//            "email.email" => "Geçersiz email formatı!",
//            "subject.required" => "Konut alanı zorunludur!",
//            "subject.min" => "Konu minimum 5 karakter olabilir!",
//            "message.required" => "Mesaj alanı zorunludur!",
//            "message.min" => "Mesaj minimum 25 karakter olabilir!"
//        ]);

        $contact = $request->all();
        $contact['ip'] = $request->ip();

        try {
            $result = Contact::create($contact);
        } catch (QueryException $exception) {
            $result = false;
        }

        return back()->with(["process" => $result ? "success" : "failed"]);
    }

}
