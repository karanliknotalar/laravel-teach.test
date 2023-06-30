<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {

            return redirect(route("dashboard.index"));
        }
        return view("auth.admin-login");

    }

    public function login_auth(LoginRequest $request)
    {

        $remember = $request->remember_token == "on";
        $admin = User::where("email", $request->email)->get()->first();


        if (!isset($admin->email)) {
            return back()->withErrors([
                'email' => 'Bu email ile kayıtlı bir yönetici hesabı bulunmuyor.',
            ]);
        }

        if ($admin->status == 0 && $admin->is_admin == 1) {
            return back()->withErrors([
                'status' => 'Bu yönetici hesabı pasiftir.',
            ]);
        }

        if ($admin->status == 1 && $admin->is_admin == 0) {
            return back()->withErrors([
                'status' => 'Bu bir yönetici hesabı değildir. Üye giriş sayfasından giriş yapın.',
            ]);
        }

        if (Auth::attempt(["email" => $request->email, "password" => $request->password, "status" => 1, "is_admin" => 1], $remember)) {

            $request->session()->regenerate();
            return redirect(route("dashboard.index"));
        }

        return back()->withErrors([
            'password' => 'Şifre hatalı.',
        ]);
    }

    public function logout()
    {
        if (Auth::check())
            Auth::logout();
        return redirect(route("auth.login"));
    }
}
