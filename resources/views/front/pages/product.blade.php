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
                        <input type="hidden" name="id" value="{{ $product->id }}">
                        <h2 class="text-black">{{ $product->name }}</h2>
                        {!! $product->description  ?? "" !!}
                        <p><strong class="text-primary h4">{{ number_format($product->price, 2) }} TL</strong></p>
                        <div class="d-flex">
                            @foreach(explode(",", $product->size) as $size)
                                <label for="option-{{ $size }}" class="d-flex mr-3 mb-3">
                            <span class="d-inline-block mr-2" style="top:-2px; position: relative;">
                                <input type="radio" id="option-{{ $size }}" name="size" value="{{ $size }}">
                            </span>
                                    <span class="d-inline-block text-black">{{ $size }}</span>
                                </label>
                            @endforeach
                        </div>
                        <div class="mb-5">
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
@endsection
