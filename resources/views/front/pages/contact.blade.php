@extends("front.layout.layout")

@section("css")
@endsection

@section("content")
    <x-front.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"/>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="h3 mb-3 text-black">İletişime Geçin</h2>
                </div>
                <div class="col-md-7">
                    @if(session()->has("process"))
                        @switch(session()->get("process"))
                            @case('success')
                                <div class="alert alert-success">
                                    {{ session()->get('process') }}
                                </div>
                                @break
                            @case('failed')
                                <div class="alert alert-danger">
                                    {{ session()->get('process') }}
                                </div>
                                @break
                        @endswitch
                    @endif
                    @if(count($errors) > 0)
                        @foreach($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    <form action="{{ route("page.contact_post") }}" method="post">
                        @csrf
                        <div class="p-3 p-lg-5 border">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="firstname" class="text-black">Ad
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="lastname" class="text-black">Soyad
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email" class="text-black">Email
                                        <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder=""
                                           required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="subject" class="text-black">Konu
                                        <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="message" class="text-black">Mesaj
                                        <span class="text-danger">*</span></label>
                                    <textarea name="message" id="message" cols="30" rows="7"
                                              class="form-control" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="submit" class="btn btn-primary btn-lg btn-block" value="Mesaj Gönder">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-5 ml-auto">
                    @if(isset($site_settings))
                        @if(isset($site_settings['address']))
                            <x-front.helpers.contact-detail
                                :name="'Adres'"
                                :content="$site_settings['address']"/>
                        @endif
                        @if(isset($site_settings['email']))
                            <x-front.helpers.contact-detail
                                :name="'Email'"
                                :content="$site_settings['email']"/>
                        @endif
                        @if(isset($site_settings['phone']))
                            <x-front.helpers.contact-detail
                                :name="'Telefon'"
                                :content="$site_settings['phone']"/>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
@endsection
