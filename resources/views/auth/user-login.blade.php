@extends("front.layout.layout")

@section("css")
@endsection

@section("content")
    <section class="h-100 h-custom gradient-custom-2">
        <div class="container py-2 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-4">
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    @if(session()->has("status"))
                        <div class="alert alert-success">
                            {{ session("status") }}
                        </div>
                    @endif
                    <form action="{{ route("auth.user_login") }}" method="post">
                        @csrf
                        <div class="form-outline mb-1">
                            <label for="email"></label>
                            <input type="email" id="email" class="form-control" name="email" placeholder="Email"/>
                        </div>
                        <div class="form-outline mb-4">
                            <label for="password"></label>
                            <input type="password" id="password" class="form-control" name="password"
                                   placeholder="Parola"/>
                        </div>

                        <div class="row mb-4">
                            <div class="col d-flex justify-content-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_token" checked
                                           name="remember_token"/>
                                    <label class="form-check-label" for="remember_token"> Beni Hatırla </label>
                                </div>
                            </div>
                            <div class="col">
                                <a href="{{ route("password.reset") }}">Şifreyi mi unuttun?</a>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block mb-4">Giriş Yap</button>
                        <div class="text-center">
                            <p>Üye değil misin? <a href="{{ route("auth.user_register") }}">Kayıt Ol</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("js")
@endsection
