<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterFormRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserAuthController extends Controller
{
    public function user_login()
    {
        return view("auth.user-login");
    }

    public function user_login_post(LoginRequest $request)
    {

        $remember = $request->remember_token == "on";
        $user = User::where("email", $request->email)->get()->first();


        if (!isset($user->email)) {
            return back()->withErrors([
                'email' => 'Bu email ile kayıtlı bir kullanıcı bulunmuyor.',
            ]);
        }

        if ($user->status == 0 && $user->is_admin == 0) {
            return back()->withErrors([
                'status' => 'Bu kullanıcı hesabı pasiftir.',
            ]);
        }

        if ($user->status == 1 && $user->is_admin == 1) {
            return back()->withErrors([
                'status' => 'Bu bir yönetici hesabıdır. Admin sayfasından giriş yapın.',
            ]);
        }

        if (Auth::attempt(["email" => $request->email, "password" => $request->password, "status" => 1, "is_admin" => 0], $remember)) {

            $request->session()->regenerate();
            return redirect(route("home.index"));
        }

        return back()->withErrors([
            'password' => 'Şifre hatalı.',
        ]);
    }

    public function user_register()
    {
        return view("auth.user-register");
    }

    public function user_register_post(RegisterFormRequest $request)
    {
        $user = $request->only("name", "email", "password");

        $user["password"] = bcrypt($user["password"]);
        $user["status"] = 1;
        $user["agreement"] = 1;

        User::create($user);

        return redirect(route("auth.user_login"))->with([
            "status" => "Kayıt Başarılı. Giriş yapabilirsiniz."
        ]);
    }

    public function user_logout()
    {
        if (Auth::check())
            Auth::logout();
        return redirect(route("home.index"));
    }

    public function password_reset(Request $request)
    {

        if ($request->getMethod() == "POST") {

            $request->validate(['email' => 'required|email']);

            $status = Password::sendResetLink(
                $request->only('email')
            );

            return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
        }

        if (isset($request["email"]) && isset($request["token"])) {
            return view("auth.password-update", compact("request"));
        }

        return view("auth.password-reset");

    }

    public function password_update(Request $request)
    {

        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('auth.user_login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
