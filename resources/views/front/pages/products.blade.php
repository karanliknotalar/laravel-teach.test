@extends("front.layout.layout")

@section("css")
@endsection

@section("content")
    <x-front.helpers.header-url
        :main-url="route('home.index')"
        :main-url-name="'Anasayfa'"/>

    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <div class="col-md-9 order-2">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                            <div class="float-md-left mb-4"><h2 class="text-black h5">Ürünler</h2></div>
                            <div class="d-flex">
                                <div class="dropdown mr-1 ml-md-auto btn-group">
                                    <button type="button" class="btn btn-secondary btn-sm dropdown-toggle"
                                            id="dropdownMenuReference" data-toggle="dropdown">Sırala
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuReference">
                                        <a class="dropdown-item"
                                           href="{{ request()->fullUrlWithQuery(["order" => "name", "director" => "asc"]) }}"
                                           data-order="a_to_z_order" onclick="productsListGet('')">A dan Z ye</a>
                                        <a class="dropdown-item"
                                           href="{{ request()->fullUrlWithQuery(["order" => "name", "director" => "desc"]) }}"
                                           data-order="z_to_a_order">Z Den A ya</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="{{ request()->fullUrlWithQuery(["order" => "price", "director" => "asc"]) }}"
                                           data-order="low_to_high_price">Artan Fiyat</a>
                                        <a class="dropdown-item"
                                           href="{{ request()->fullUrlWithQuery(["order" => "price", "director" => "desc"]) }}"
                                           data-order="high_to_low_price">Azalan Fiyat </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="productList">
                        <div class="row mb-5">
                            @if(isset($products) && $products->count() > 0)
                                @foreach($products as $product)
                                    <div class="col-sm-6 col-lg-4 mb-4" data-aos="fade-up">
                                        <div class="block-4 text-center border">
                                            <figure class="block-4-image">
                                                <a href="{{ route("page.product", ["slug_name" => $product->slug_name]) }}">
                                                    @php
                                                        $images = isset($product->product_media) ? json_decode($product->product_media->images) : [$product->image ?? "images/cloth_1.jpg"];
                                                        $image = $images[$product->product_media ? $product->product_media->showcase_id : 0];
                                                    @endphp
                                                    <img class="img-fluid" src="{{ asset($image) }}"
                                                         alt="{{ $product->name }}">
                                                </a>
                                            </figure>
                                            <div class="block-4-text p-4">
                                                <h3>
                                                    <a href="{{ route("page.product", ["slug_name" => $product->slug_name]) }}">{{ $product->name }}</a>
                                                </h3>
                                                <p class="mb-0">{{ $product->sort_description }}</p>
                                                @php
                                                    $total = Helper::getVatIncluded($product->price, $product->vat->VAT);
                                                @endphp
                                                <p class="text-primary font-weight-bold">{{ number_format($total, 2) }}
                                                    ₺</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        {!! $products->links('pagination::front-products') !!}
                        {{--                        @include("front.ajax.products-list")--}}
                    </div>
                </div>

                <div class="col-md-3 order-1 mb-5 mb-md-0">
                    <div class="border p-4 rounded mb-4">
                        <h3 class="mb-3 h6 text-uppercase text-black d-block">
                            <a class="px-1 py-0 rounded-2 text-center" data-toggle="collapse"
                               href="#collapseSubCategory" role="button" aria-expanded="false"
                               aria-controls="collapseSubCategory">
                                <i class="icon-plus" id="plusicon"></i> Kategoriler
                            </a>
                        </h3>
                        <ul class="list-unstyled mb-0">
                            @if(isset($categories))
                                @foreach($categories as $category)
                                    @if($category->parent_id == null)
                                        <li class="mb-1">
                                            <a href="{{ route("page.products", ['id'=> $category->id, 'category'=>$category->slug_name]) }}"
                                               class="d-flex">
                                                <b><span>{{ $category->name }}</span></b>
                                                <span
                                                    class="text-black ml-auto">({{ $category->mainCategoryCounts() }})</span></a>
                                        </li>
                                    @endif
                                    @foreach($category->sub_categories as $sub_category)
                                        <li class="mb-1 collapse" id="collapseSubCategory">
                                            <a href="{{ route("page.products", ['id'=> $sub_category->id, 'category'=>$sub_category->slug_name]) }}"
                                               class="d-flex">
                                                <i><span>&nbsp;&nbsp;&nbsp;{!! $sub_category->name !!}</span></i>
                                                <span
                                                    class="text-black ml-auto">({{ $sub_category->items_count }})</span>
                                            </a>
                                        </li>
                                    @endforeach
                                @endforeach
                            @endif
                        </ul>
                    </div>
                    <div class="border p-4 rounded mb-4">
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Fiyata Göre Filtrele</h3>
                            <div id="slider-range" class="border-primary"></div>
                            <label for="amount">
                                <input type="text" name="text" id="amount" class="form-control border-0 pl-0 bg-white"/>
                            </label>
                        </div>
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Beden</h3>
                            @if(isset($sizes))
                                @foreach($sizes as $size)
                                    <label for="{{ $size->size }}" class="d-flex">
                                        <input type="checkbox" id="{{ $size->size }}" class="mr-2 mt-1 sizeList"
                                               name="size[{{ $size->size }}]" value="{{ $size->size }}"
                                            {{ isset(request()->size) && in_array($size->size, explode(",", request()->size)) ? "checked" : "" }}>
                                        <span class="text-black">{{ $size->size }} ({{ $size->size_count }})</span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        <div class="mb-4">
                            <h3 class="mb-3 h6 text-uppercase text-black d-block">Renk</h3>
                            @if(isset($colors))
                                @foreach($colors as $color)
                                    <label for="{{ $color->color }}" class="d-flex">
                                        <input type="checkbox" id="{{ $color->color }}" class="mr-2 mt-1 colorList"
                                               name="color[{{ $color->color }}]" value="{{ $color->color }}"
                                            {{ isset(request()->color) && in_array($color->color, explode(",", request()->color)) ? "checked" : "" }}>
                                        <span
                                            class="text-black">{{ $color->color }} ({{ $color->color_count }})</span>
                                    </label>
                                @endforeach
                            @endif
                        </div>
                        <div class="row">
                            <div class="col-5">
                                <button class="btn btn-group btnReset"
                                        onclick="location.href = '{{ URL::current() }}'">Sıfırla
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-warning btnFilter">Filtrele</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="site-section site-blocks-2">
                        <div class="row justify-content-center text-center mb-5">
                            <div class="col-md-7 site-section-heading pt-4">
                                <h2>Kategoriler</h2>
                            </div>
                        </div>
                        <div class="row">
                            @if(isset($categories))
                                @foreach($categories->where("parent_id", null) as $category)
                                    <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0" data-aos="fade"
                                         data-aos-delay="">
                                        <a class="block-2-item"
                                           href="{{ route("page.products", ['id'=> $category->id, 'category'=>$category->slug_name]) }}">
                                            <figure class="image">
                                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}"
                                                     class="img-fluid">
                                            </figure>
                                            <div class="text">
                                                <span class="text-uppercase">Koleksiyonlar</span>
                                                <h3>{{ $category->name }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
    <script>
        const min_price = {{ $products->min("price") ?? 0 }};
        const max_price = {{ $products->max("price") ?? $min_max_price["max"]}};

        (function () {
            const range = $("#slider-range");
            range.slider({
                range: true,
                min: {{ $min_max_price["min"] ?? 0 }},
                max: {{ $min_max_price["max"] ?? 0 }},
                values: [min_price ?? 0, max_price ?? 0],
                slide: function (event, ui) {
                    $("#amount").val(ui.values[0] + " ₺ - " + ui.values[1] + " ₺");

                    $("#amount").on("mouseleave", function () {
                        priceBetween(ui.values[0], ui.values[1])
                    })

                }
            });
            $("#amount").val(range.slider("values", 0) +
                " ₺ - " + range.slider("values", 1) + " ₺");
        })();

        function addQueryParamsToURL(url, params) {
            let queryString = $.param(params);
            let separator = url.includes('?') && !url.endsWith("&") ? '&' : '?';
            return decodeURIComponent(url + separator + queryString);
        }

        function priceBetween(min, max) {
            let params = {
                min: min,
                max: max
            };
            location.href = addQueryParamsToURL("{!! request()->fullUrlWithoutQuery(["min", "max"]) !!}", params);
        }

        $('a[aria-controls="collapseSubCategory"]').on('click', function (e) {
            e.currentTarget.children[0].className = $("#collapseSubCategory").is(":visible") ? "icon-plus" : "icon-minus"
        });

        $(".btnFilter").on("click", function () {
            let sizeList = [];
            let colorList = [];

            $(".sizeList:checked").each(function () {
                sizeList.push(this.value);
            });
            $(".colorList:checked").each(function () {
                colorList.push(this.value);
            });
            let params = {};
            if (sizeList.length > 0)
                params["size"] = sizeList.join(",");
            if (colorList.length > 0)
                params["color"] = colorList.join(",");
            location.href = addQueryParamsToURL("{!! request()->fullUrlWithoutQuery(["size","color"]) !!}", params)
        });

        function productsListGet(url) {
            $.ajax({
                method: "GET",
                url: url,
                success: function (response) {
                    $(".productList").html(response.data);
                }
            });
        }
    </script>

@endsection
