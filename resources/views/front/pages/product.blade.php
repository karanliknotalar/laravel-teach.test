@extends("front.layout.layout")

@section("css")
    <link rel="stylesheet" href="{{ asset('/') }}jquery-toast/jquery.toast.min.css">
@endsection

@section("content")

    <x-front.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"
        :child-url="route('page.product', [$product->id, $product->slug_name])"
        :child-url-name="$product->name"/>

    <div class="site-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $product->image != null ? asset($product->image) : asset("images/cloth_1.jpg") }}"
                         alt="{{ $product->name }}" class="img-fluid">
                </div>
                <div class="col-md-6 col-lg-6 my-sm-3 my-md-0">
                    <form action="" method="POST" id="cardForm">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}">
                        <h2 class="text-black mb-3">{{ $product->name }}</h2>
                        <div class="mb-3">{!! $product->description  ?? "" !!}</div>

                        <div class="form-group mb-3">
                            <select class="form-control" id="size" name="size">
                                @foreach($product->product_quantity as $product_quantity)
                                    <option value="{{ $product_quantity->size }}">{{ $product_quantity->size }}</option>
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
                                <input type="text" class="form-control text-center" value="1" placeholder=""
                                       aria-label="Example text with button addon" aria-describedby="button-addon1"
                                       name="quantity">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary js-btn-plus" type="button">&plus;</button>
                                </div>
                            </div>
                        </div>

                        <p><strong class="text-primary h4 mb-4 price"></strong></p>
                        <p><span id="addCard" class="buy-now btn btn-sm btn-primary">Sepete Ekle</span></p>
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
                                                <img
                                                    src="{{ $f_product->image != null ? asset($f_product->image) : asset("images/cloth_1.jpg") }}"
                                                    alt="{{ $f_product->name }}" class="img-fluid">
                                            </a>
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3>
                                                <a href="{{ route("page.product", [$f_product->id, $f_product->slug_name]) }}">{{ $f_product->name }}</a>
                                            </h3>
                                            <p class="mb-0">{{ $f_product->sort_description ?? "" }}</p>
                                            <p class="text-primary font-weight-bold">{{ number_format($f_product->price, 2) }}
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
        $(document).ready(function () {
            $("#addCard").click(function () {

                $.ajax({
                    method: "POST",
                    url: "{{ route("cart.add-cart") }}",
                    data: $("#cardForm").serialize(),
                    success: function (sonuc) {
                        if (sonuc === "ok") {
                            $.toast({
                                heading: 'Success',
                                text: 'Başarıyla Sepete Eklendi',
                                showHideTransition: 'slide',
                                icon: 'success',
                                position: 'bottom-right',
                                hideAfter: 1500,
                            });

                        } else {
                            $.toast({
                                heading: 'Stok',
                                text: 'Stok sınırını aştınız',
                                showHideTransition: 'slide',
                                icon: 'error',
                                position: 'bottom-right',
                                hideAfter: 1500,
                            });
                        }
                    }
                })
            });
        });
    </script>
    <script>
        $(document).ready(function () {
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
                        if (!response.error) {
                            $(".price").text(response.price + " TL")
                        }
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
