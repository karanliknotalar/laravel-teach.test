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
                    @if(session()->has("status"))
                            <div class="alert alert-success">
                                {{ session("status") }}
                            </div>
                    @endif
                    <form action="{{ route("password.reset") }}" method="post">
                        @csrf

                        <div class="form-outline mb-4">
                            <label for="email"></label>
                            <input type="email" id="email" class="form-control" placeholder="Email" name="email"/>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-4">Şifre Sıfırla</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section("js")
@endsection
