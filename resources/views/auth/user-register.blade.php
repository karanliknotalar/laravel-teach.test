@extends("front.layout.layout")

@section("css")
@endsection

@section("content")
    <section class="h-100 h-custom gradient-custom-2">
        <div class="container h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-5">
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <form action="{{ route("auth.user_register") }}" method="post">
                        @csrf
                        <div class="form-outline mb-1">
                            <label for="name"></label>
                            <input type="text" id="name" class="form-control" placeholder="İsim" name="name"/>
                        </div>

                        <div class="form-outline mb-1">
                            <label for="email"></label>
                            <input type="email" id="email" class="form-control" placeholder="Email" name="email"/>
                        </div>

                        <div class="form-outline mb-1">
                            <label for="password"></label>
                            <input type="password" id="password" class="form-control" name="password"
                                   placeholder="Parola"/>
                        </div>

                        <div class="form-outline mb-5">
                            <label for="password_confirmation"></label>
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                                   placeholder="Parola Tekrar"/>
                        </div>

                        <div class="form-check d-flex mb-5">
                            <input class="form-check-input me-2" type="checkbox" id="agreement" name="agreement"/>
                            <label class="form-check-label" for="agreement">
                                I agree all statements in <a href="#!">Terms of service</a>
                            </label>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-4">Kayıt Ol</button>

                        <div class="text-center">
                            <p>Zaten üye misin? <a href="{{ route("auth.user_login") }}">Giriş Yap</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("js")
@endsection
