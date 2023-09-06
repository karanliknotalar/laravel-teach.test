@extends("front.layout.layout")

@section("css")
@endsection

@section("content")
    <x-front.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"
        :child-url="route('cart.order')"
        :child-url-name="'Ödeme'"/>

    <div class="site-section">
        <div class="container">
            @if(isset($unsetting_product) && count($unsetting_product) > 0)
                <div class="alert alert-warning">
                    {{ count($unsetting_product) }} ürün sepetinizden kaldırıldı.
                </div>
            @endif
            @if(session()->has("status"))
                <div class="alert alert-success">
                    {{ session("status") }}
                </div>
            @endif
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div class="alert alert-warning">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            @if(!Auth::check())
                <div class="row mb-5">
                    <div class="col-md-12">
                        <div class="border p-4 rounded" role="alert">
                            Returning customer? <a href="#">Click here</a> to login
                        </div>
                    </div>
                </div>
            @endif
            <form method="post" action="{{ route("cart.order-complete") }}" name="order-complete">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-5 mb-md-0">
                        <h2 class="h3 mb-3 text-black">Ödeme Detayları</h2>
                        <div class="p-3 p-lg-5 border">
                            <div class="form-group">
                                <label for="country" class="text-black">Ülke <span
                                        class="text-danger">*</span></label>
                                <select id="country" class="form-control" name="country">
                                    <option value="-1">Ülke Seçin</option>
                                    <option value="turkey">Türkiye</option>
                                </select>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="f_name" class="text-black">İsim <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="f_name" name="f_name">
                                </div>
                                <div class="col-md-6">
                                    <label for="l_name" class="text-black">Soyisim <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="l_name" name="l_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="company_name" class="text-black">Firma Adı</label>
                                    <input type="text" class="form-control" id="company_name" name="company_name">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="address" class="text-black">Adres <span
                                            class="text-danger">*</span></label>
                                    <textarea type="text" class="form-control" id="address" name="address"
                                              placeholder="Adresi giriniz.."></textarea>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="province" class="text-black">İl <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="province" name="province">
                                </div>
                                <div class="col-md-6">
                                    <label for="district" class="text-black">İlçe <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="district" name="district">
                                </div>
                            </div>

                            <div class="form-group row mb-5">
                                <div class="col-md-6">
                                    <label for="email" class="text-black">Email <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="email" name="email">
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="text-black">Telefon <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="phone" name="phone">
                                </div>
                            </div>

                            @if(!Auth::check())
                                <div class="form-group row mb-5">
                                    <div class="col-12">
                                        <label for="password" class="text-black">Hesap Şifresi</label>
                                        <input type="password" class="form-control" id="password"
                                               name="password" placeholder="">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="order_notes" class="text-black">Sipariş Notları</label>
                                <textarea name="order_notes" id="order_notes" cols="30" rows="5"
                                          class="form-control"
                                          placeholder="Not yazablirsiniz..."></textarea>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row mb-5">
                            <div class="col-md-12">
                                <h2 class="h3 mb-3 text-black">Siparişiniz</h2>
                                <div class="p-3 p-lg-5 border">
                                    <table class="table site-block-order-table mb-5">
                                        <thead>
                                        <th>Ürün</th>
                                        <th>Toplam</th>
                                        </thead>
                                        <tbody>
                                        @if(isset($cartItems))
                                            @foreach($cartItems as $cartId=>$cartItem)
                                                @php
                                                    $total = Helper::getVatIncluded($cartItem["price"], $cartItem["vat"]);
                                                @endphp
                                                <tr>
                                                    <td>{{ $cartItem["name"] }}<strong
                                                            class="mx-2">x</strong>{{ $cartItem["quantity"] }}</td>
                                                    <td>{{ number_format($total * $cartItem["quantity"], 2) }}
                                                        TL
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        @if(session()->has("coupon"))
                                            <tr>
                                                <td class="text-black font-weight-bold"><strong>Kupon
                                                        ({{ session("coupon")['name'] }})</strong></td>
                                                <td class="text-black">
                                                    -{{ number_format(session("coupon")['price'], 2) ?? 0 }} TL
                                                </td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td class="text-black font-weight-bold"><strong>Sipariş Toplamı</strong>
                                            </td>
                                            <td class="text-black font-weight-bold">
                                                <strong>{{ number_format($totalPrice, 2) ?? 0 }} TL</strong></td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg py-3 btn-block">
                                            Ödeme Yap
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section("js")
    {{--    <script>--}}
    {{--        $("#button-coupon").on("click", function (){--}}

    {{--           const coupon_name = $("#coupon").val();--}}
    {{--           console.log(coupon_name);--}}

    {{--            $.ajax({--}}
    {{--                method: "POST",--}}
    {{--                url: "{{ route("cart.add-coupon") }}",--}}
    {{--                data: {--}}
    {{--                    "_token": "{{ csrf_token() }}",--}}
    {{--                    "coupon_name": coupon_name--}}
    {{--                }--}}
    {{--            });--}}

    {{--        });--}}
    {{--    </script>--}}
@endsection
