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
                    <form action="{{ route("user-auth.password_update") }}" method="post">
                        @csrf
                        <input type="hidden" value="{{ $request["token"] }}" name="token">
                        <input type="hidden" value="{{ $request["email"] }}" name="email">
                        <div class="form-outline mb-1">
                            <label for="password"></label>
                            <input type="password" id="password" class="form-control" name="password"
                                   placeholder="Yeni Parola"/>
                        </div>

                        <div class="form-outline mb-5">
                            <label for="password_confirmation"></label>
                            <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"
                                   placeholder="Yeni Parola Tekrar"/>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-4">Değiştir</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("js")
@endsection
