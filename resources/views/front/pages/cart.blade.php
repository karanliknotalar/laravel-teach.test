@extends("front.layout.layout")

@section("css")
@endsection

@section("content")
    <x-frontend.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"
        :child-url="route('page.cart')"
        :child-url-name="'Sepet'" xmlns="http://www.w3.org/1999/html"/>

    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-12">
                    <div class="site-blocks-table">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th class="product-thumbnail">Resim</th>
                                <th class="product-name">Ürün</th>
                                <th class="product-price">Fiyat</th>
                                <th class="product-quantity">Adet</th>
                                <th class="product-total">Toplam</th>
                                <th class="product-remove">Kaldır</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($cartItems))
                                @foreach($cartItems as $id=>$cartItem)

                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="{{ asset($cartItem["image"] ?? "images/cloth_1.jpg")  }}"
                                                 alt="{{ $cartItem["name"] }}" class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route("page.product", [$id ?? "", $cartItem["slug_name"] ?? ""]) }}">
                                                <h2 class="h5 text-black">{{ $cartItem["name"] }}</h2></a>
                                        </td>
                                        <td>{{ number_format($cartItem["price"], 2) }} TL</td>
                                        <td>
                                            <div class="input-group mb-3" style="max-width: 120px;">
                                                <div class="input-group-prepend">
                                                    <button class="btn btn-outline-primary js-btn-minus"
                                                            type="button">
                                                        &minus;
                                                    </button>
                                                </div>
                                                <input type="text" class="form-control text-center"
                                                       value="{{ $cartItem["quantity"] }}"
                                                       placeholder=""
                                                       aria-label="Example text with button addon"
                                                       aria-describedby="button-addon1">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus"
                                                            type="button">
                                                        &plus;
                                                    </button>
                                                </div>
                                            </div>

                                        </td>
                                        <td>{{ number_format($cartItem["price"] * $cartItem["quantity"], 2) }}TL
                                        </td>
                                        <td>
                                            <form action="{{ route("cart.remove-cart") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $id }}">
                                                <input role="button" type="submit" value="X"
                                                       class="btn btn-primary btn-sm" id="removeCard">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">Kupon</label>
                            <p>Kupon kodunuz var ise ekleyin</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" placeholder="Kupon Kodu">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-primary btn-sm">Kuponu Ekle</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                </div>
                            </div>

                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Toplam</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">{{ number_format($totalPrice, 2) ?? 0 }} TL</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-lg py-3 btn-block"
                                            onclick="window.location='checkout.html'">Proceed To Checkout
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
@endsection
