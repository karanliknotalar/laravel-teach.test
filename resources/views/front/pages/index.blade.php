@extends("front.layout.layout")

@section("css")
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.7/css/swiper.min.css'>
    <link rel="stylesheet" href="{{ asset("/") }}css/slider.css">
@endsection

@section("content")

    @if(isset($sliders) && $sliders->count() > 0)
        <!-- start of hero -->
        <section class="hero-slider hero-style">
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach($sliders as $slider)
                        <div class="swiper-slide">
                            <div class="slide-inner slide-bg-image"
                                 data-background="{{ asset($slider->image ?? "images/hero_1.jpg") }}">
                                <div class="container">
                                    <div class="row align-items-start align-items-md-center justify-content-end">
                                        <div class="col-md-5 col-lg-5 col-sm-5">
                                            <div data-swiper-parallax="300" class="slide-title">
                                                <h2>{{ $slider->name ?? "" }}</h2>
                                            </div>
                                            <div data-swiper-parallax="400" class="slide-text">
                                                {!! $slider->content ?? "" !!}
                                            </div>
                                            <div class="clearfix"></div>
                                            <div data-swiper-parallax="500" class="slide-btns">
                                                <a href="{{ url($slider->shop_url ?? "/urunler") }}"
                                                   class="btn btn-sm btn-primary">Alışverişe
                                                    Başla</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- end swiper-wrapper -->
                {{--            <!-- swipper controls -->--}}
                {{--            <div class="swiper-button-next"></div>--}}
                {{--            <div class="swiper-button-prev"></div>--}}
            </div>
        </section>
        <!-- end of hero slider -->
    @endif

    @if(isset($services) && $services->count() > 0)
        <div class="site-section site-section-sm site-blocks-1">
            <div class="container">
                <div class="row">
                    @foreach($services as $service)
                        <div class="col-md-6 col-lg-4 d-lg-flex mb-4 mb-lg-0 pl-4 my-4" data-aos="fade-up"
                             data-aos-delay="">
                            <div class="icon mr-4 align-self-start">
                                <span class="{{ $service->icon ?? "" }}"></span>
                            </div>
                            <div class="text">
                                <h2 class="text-uppercase">{{ $service->title ?? "" }}</h2>
                                {!! $service->content ?? "" !!}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="site-section site-blocks-2">
        <div class="container">
            <div class="row">
                @if(isset($categories))
                    @foreach($categories->where("parent_id", null) as $category)
                        <div class="col-sm-6 col-md-6 col-lg-4 mb-4 mb-lg-0 my-5" data-aos="fade"
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
    @if(isset($featured_products) and $featured_products->count() > 0)
        <div class="site-section block-3 site-blocks-2 bg-light">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-7 site-section-heading text-center pt-4">
                        <h2>Öne Çıkan Ürünler</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="nonloop-block-3 owl-carousel">
                            @foreach($featured_products as $featured_product)
                                <div class="item">
                                    <div class="block-4 text-center">
                                        <figure class="block-4-image">
                                            <img src="{{ asset($featured_product->image ?? "images/cloth_1.jpg") }}" alt="Image placeholder"
                                                 class="img-fluid">
                                        </figure>
                                        <div class="block-4-text p-4">
                                            <h3><a href="{{ route("page.product", ["slug_name" => $featured_product->slug_name]) }}">{{ $featured_product->name ?? "" }}</a></h3>
                                            <p class="mb-0">{{ $featured_product->sort_description ?? ""}}</p>
                                            <p class="text-primary font-weight-bold">{{ number_format($featured_product->low_price->price, 2) }} TL</p>
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

    <div class="site-section block-8">
        <div class="container">
            <div class="row justify-content-center  mb-5">
                <div class="col-md-7 site-section-heading text-center pt-4">
                    <h2>Big Sale!</h2>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-7 mb-5">
                    <a href="{{ route("page.indirimdeki-urunler") }}">
                        <img src="{{ asset("images/blog_1.jpg") }}" alt="Image placeholder"
                             class="img-fluid rounded">
                    </a>
                </div>
                <div class="col-md-12 col-lg-5 text-center pl-md-5">
                    <h2><a href="#">50% less in all items</a></h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quisquam iste dolor accusantium facere
                        corporis ipsum animi deleniti fugiat. Ex, veniam?</p>
                    <p><a href="{{ route("page.indirimdeki-urunler") }}" class="btn btn-primary btn-sm">Shop Now</a></p>
                </div>
            </div>
        </div>
    </div>

@endsection

@section("js")
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.5.1/js/swiper.min.js'></script>
    <script src="{{ asset('/') }}js/slider.js"></script>
@endsection
