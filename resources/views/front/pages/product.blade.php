@extends("front.layout.layout")

@section("css")
    <link rel="stylesheet" href="{{ asset('/') }}jquery-toast/jquery.toast.min.css">
    <link rel="stylesheet"
          href="https://mdbcdn.b-cdn.net/wp-content/themes/mdbootstrap4/docs-app/css/dist/mdb5/plugins/standard/ecommerce-gallery.min.css">
@endsection

@section("content")
    <x-front.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"
        :child-url="route('page.product', ['slug_name' => $product->slug_name])"
        :child-url-name="$product->name"/>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 product-gallery" id="product-gallery">

                </div>
                <div class="col-md-6 col-lg-6 my-sm-3 my-md-0">
                    <form id="cartForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}">
                        <h2 class="text-black">{{ $product->name }}</h2>
                        <div class="mb-4">
                            <span class="text-success small">Ürün Kodu: {{ $product->product_code }}</span>
                            <div class="small">
                                Stok Durumu: <span class="small quantity-status">-</span>
                            </div>
                        </div>

                        <div>{!! $product->description  ?? "" !!}</div>

                        <div class="form-group my-3">
                            <select class="form-control" id="size" name="size">
                                @foreach($product->product_size as $product_size)
                                    <option
                                        {{ $product_size->size == $product->low_price_product->size ? "selected" : "" }}
                                        value="{{ $product_size->size }}">
                                        {{ $product_size->size }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="color">Renk Seçin: </label>
                            <select class="form-control" id="color" name="color" disabled>
                            </select>
                        </div>

                        <div class="mb-4">
                            <div class="input-group mb-3" style="max-width: 120px;">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary js-btn-minus" type="button">&minus;</button>
                                </div>
                                <input type="text" class="form-control text-center js-input-quantity" value="1"
                                       name="quantity">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                </div>
                            </div>
                        </div>
                        <p class="mb-2">
                            <strong
                                class="text-primary h5 price">Fiyat: {{ number_format(($product->low_price_product->price ?? 0), 2) ?? "" }}
                                ₺</strong>
                        </p>
                        <p class="mb-2">
                            <strong
                                class="text-primary h5 vat">KDV: {{ number_format((($product->low_price_product->price ?? 0) * $product->vat->VAT) / 100, 2) ?? "" }}
                                ₺</strong>
                        </p>
                        <p class="mb-2">
                            <strong
                                class="text-primary h5 total">Toplam: {{ number_format(Helper::getVatIncluded(($product->low_price_product->price ?? 0), $product->vat->VAT),2) ?? "" }}
                                ₺</strong>
                        </p>
                        <p class="mt-4">
                            <span id="addCart" class="buy-now btn btn-sm btn-primary">Sepete Ekle</span>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($f_products) && $f_products->count() > 0)
        <div class="site-section block-3 site-blocks-2 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7 site-section-heading text-center pt-4">
                        <h2>Diğer Ürünlerimiz</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="nonloop-block-3 owl-carousel">
                            @foreach($f_products as $f_product)
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <a href="{{ route("page.product", [$product->id, $product->slug_name]) }}">
                                                @php
                                                    $images = isset($f_product->product_media) ? json_decode($f_product->product_media->images) : [$f_product->image ?? "images/cloth_1.jpg"];
                                                    $image = $images[$f_product->product_media ? $f_product->product_media->showcase_id : 0];
                                                @endphp
                                                <img src="{{ asset($image) }}" alt="{{ $f_product->name }}"
                                                     class="img-fluid">
                                            </a>
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3>
                                                <a href="{{ route("page.product", [$f_product->id, $f_product->slug_name]) }}">{{ $f_product->name }}</a>
                                            </h3>
                                            <p class="mb-0">{{ $f_product->sort_description ?? "" }}</p>
                                            <p class="text-primary font-weight-bold">{{ number_format($f_product->low_price_product->price, 2) }}
                                                TL</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section("js")
    <script src="{{ asset('/') }}jquery-toast/jquery.toast.min.js"></script>
    <script>
        $("#cartForm").bind("keyup keypress", function (e) {
            const keyCode = e.keyCode || e.which;
            if (keyCode === 13) {
                e.preventDefault();
                return false;
            }
        });

        let quantity = $(".js-input-quantity");

        $(".js-btn-plus").on("click", function () {
            quantity.val(parseInt(quantity.val()) + 1);
        })
        $(".js-btn-minus").on("click", function () {
            quantity.val(parseInt(quantity.val()) > 1 ? parseInt(quantity.val()) - 1 : quantity.val());
        })
    </script>
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

        $(document).ready(function () {
            $("#addCart").click(function () {
                $.ajax({
                    method: "POST",
                    url: "{{ route("cart.add-cart") }}",
                    data: $("#cartForm").serialize(),
                    success: function (response) {
                        if (response.success) {
                            $("#cart_count").addClass("d-block").text(response.cartCount);
                            toastMsg("success", "Başarılı", response.message);
                        } else
                            toastMsg("error", response.error, response.message);
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function () {
            let first = true;

            function getColor() {
                $.ajax({
                    method: "POST",
                    url: "{{ route("product.size") }}",
                    data: {
                        'size': $("#size").val(),
                        '_token': '{{ csrf_token() }}',
                        'id': '{{ encrypt($product->id) }}'
                    },
                    success: function (response) {
                        if (!response.error) {
                            const color = $("#color");
                            color.prop("disabled", false);
                            color.empty();
                            response.forEach(function (p) {
                                color.append($('<option>', {
                                    value: p.color,
                                    text: p.color
                                }));
                                color.find('option[value="{{ $product->low_price_product ? $product->low_price_product->color : "" }}"]')
                                    .prop('selected', first && (p.color === "{{ $product->low_price_product ? $product->low_price_product->color : "" }}"));
                            });
                            getPrice();
                        }
                    }
                });
            }

            function getPrice() {
                $.ajax({
                    method: "POST",
                    url: "{{ route("product.color") }}",
                    data: {
                        'size': $("#size").val(),
                        'color': $("#color").val(),
                        '_token': '{{ csrf_token() }}',
                        'id': '{{ encrypt($product->id) }}'
                    },
                    success: function (response) {
                        $(".price").text("Fiyat: " + response.price + " ₺")
                        $(".vat").text("KDV: " + response.vat + " ₺")
                        $(".total").text("Toplam: " + response.total + " ₺")
                        $(".product-gallery").html(response.images);
                        $(".quantity-status").text(response.quantity).parent("div")
                            .addClass(response.quantity > 0 ? "text-success" : "text-danger");
                    }
                });
            }

            getColor();

            $("#size").on("change", function () {
                getColor();
            });
            $("#color").on("change", function () {
                getPrice();
            });
        });

    </script>
@endsection
