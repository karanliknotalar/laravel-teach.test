@extends("front.layout.layout")

@section("css")
    <link rel="stylesheet" href="{{ asset('/') }}jquery-toast/jquery.toast.min.css">
@endsection

@section("content")
    <x-front.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"
        :child-url="route('page.cart')"
        :child-url-name="'Sepet'"/>

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
                                @foreach($cartItems as $cartId=>$cartItem)
                                    <tr cart-id="{{ encrypt($cartId) }}">
                                        <td class="product-thumbnail">
                                            <img src="{{ asset($cartItem["image"] ?? "images/cloth_1.jpg")  }}"
                                                 alt="{{ $cartItem["name"] }}" class="img-fluid">
                                        </td>
                                        <td class="product-name">
                                            <a href="{{ route("page.product", [$cartItem["slug_name"] ?? ""]) }}">
                                                <h2 class="h5 text-black">{{ $cartItem["name"] }}</h2>
                                            </a>
                                            <span>{{ $cartItem["color"] ?? "" }}</span> -
                                            <span>{{ $cartItem["size"] ?? "" }}</span>
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
                                                       name="quantity" disabled>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-primary js-btn-plus"
                                                            type="button">
                                                        &plus;
                                                    </button>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            {{ number_format($cartItem["price"] * $cartItem["quantity"], 2) }}TL
                                        </td>
                                        <td>
                                            <form action="{{ route("cart.remove-cart") }}" method="post">
                                                @csrf
                                                <input type="hidden" name="product_id"
                                                       value="{{ encrypt($cartItem["product_id"]) }}">
                                                <input type="hidden" name="product_quantity_id"
                                                       value="{{ encrypt($cartItem["product_quantity_id"]) }}">
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
                <form action="{{ route('cart.add-coupon') }}" method="post" class="col-md-6">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="text-black h4" for="coupon">Kupon</label>
                            <p>Kupon kodunuz var ise ekleyin</p>
                        </div>
                        <div class="col-md-8 mb-3 mb-md-0">
                            <input type="text" class="form-control py-3" id="coupon" placeholder="Kupon Kodu"
                                   name="coupon_name">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm">Kuponu Ekle</button>
                        </div>
                    </div>
                </form>
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Cart Totals</h3>
                                </div>
                            </div>

                            <div class="row mb-5">
                                @if(session()->has("coupon"))
                                    <div class="col-md-6">
                                        <span class="text-black">Kupon ({{ session("coupon")['name'] }})</span>
                                    </div>
                                    <div class="col-md-6 text-right">
                                        <strong class="text-black">{{ number_format(session("coupon")['price'], 2) ?? 0 }} TL</strong>
                                    </div>
                                @endif
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
    <script src="{{ asset('/') }}jquery-toast/jquery.toast.min.js"></script>
    <script>
        function toastMsg(icon, title, message) {
            $.toast({
                heading: title,
                text: message,
                showHideTransition: 'slide',
                icon: icon,
                position: 'bottom-right',
                hideAfter: 1500,
            });
        }

        function updateCartQuantity(btn, action) {
            let cartId = btn.closest("tr").attr("cart-id");
            let quantity = parseInt(btn.closest("td").find("input").attr("value"));

            $.ajax({
                method: "POST",
                url: "{{ route("cart.update-cart-quantity") }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "cartId": cartId,
                    "quantity": action === "+" ? quantity + 1 : quantity - 1,
                },
                success: function (response) {
                    if (response.success)
                        location.reload();
                    else
                        toastMsg("error", response.error, response.message)
                }
            });
        }

        $(".js-btn-minus").on("click", function () {
            updateCartQuantity($(this), "-")
        });

        $(".js-btn-plus").on("click", function () {
            updateCartQuantity($(this), "+")
        });
    </script>
@endsection
