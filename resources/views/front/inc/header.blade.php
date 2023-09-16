<header class="site-navbar" role="banner">
    <div class="site-navbar-top">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
                    <form action="{{ route("page.products") }}" class="site-block-top-search" method="get">
                        <span class="icon icon-search2"></span>
                        <input type="text" class="form-control border-0" name="search" placeholder="Ürünlerde ara...">
                    </form>
                </div>
                <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
                    <div class="site-logo">
                        <a href="{{ route("home.index") }}" class="js-logo-clone">{{ config("app.name") }}</a>
                    </div>
                </div>
                <div class="col-6 col-md-4 order-3 order-md-3 text-right">
                    <div class="site-top-icons">
                        <ul>
                            <li class="dropdown">
                                <a class="{{ Auth::check() && !Auth::user()->is_admin ? "dropdown-toggle" : "" }}"
                                   data-toggle="{{ Auth::check() && !Auth::user()->is_admin ? "dropdown" : "" }}"
                                   href="{{ Auth::check() && !Auth::user()->is_admin ? "" : route("auth.user_login") }}">
                                    <span class="icon icon-person"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                                    @if(Auth::check() && !Auth::user()->is_admin)
                                        <a class="dropdown-item">
                                            <i class="ti-settings text-primary"></i>
                                            Profil
                                        </a>
                                        <a href="{{ route("user-auth.user_logout") }}" class="dropdown-item">
                                            <i class="ti-power-off text-primary"></i>
                                            Çıkış Yap
                                        </a>
                                    @endif
                                </div>
                            </li>

                            <li><a href="#"><span class="icon icon-heart-o"></span></a></li>
                            <li>
                                <a href="{{ route("page.cart") }}" class="site-cart">
                                    <span class="icon icon-shopping_cart"></span>
                                    @php
                                        $countVisible = (session()->has("cart") and count(session("cart")) > 0);
                                    @endphp
                                    <span class="count {{ $countVisible ? "d-block" : "d-none" }}" id="cart_count">{{ $countVisible ? count(session("cart")) : "" }}</span>
                                </a>
                            </li>
                            <li class="d-inline-block d-md-none ml-md-0">
                                <a href="#" class="site-menu-toggle js-menu-toggle">
                                    <span class="icon-menu"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
            <ul class="site-menu js-clone-nav d-none d-md-block">
                {{--                <li class="has-children active">--}}
                <li class="{{ Route::is("home.index") ? "active" : "" }}">
                    <a href="{{ route("home.index") }}">Anasayfa</a>
                </li>
                <li class="has-children">
                    <a>Kategoriler</a>
                    @if(isset($categories))
                        <ul class="dropdown">
                            @foreach($categories->where("parent_id", null) as $category)
                                <li class="has-children">
                                    <a href="{{ route("page.products", ['id'=> $category->id, 'category'=>$category->slug_name]) }}">{{ $category->name }}</a>
                                    <ul class="dropdown">
                                        @foreach($category->sub_categories as $sub_category)
                                            <li>
                                                <a href="{{ route("page.products",
                                                            [
                                                                'category'=> $category->slug_name,
                                                                'sub_category'=>$sub_category->slug_name,
                                                                'id' => $sub_category->id,
                                                            ]) }}">{{ $sub_category->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
                <li class="{{ Route::is("page.products") ? "active" : "" }}">
                    <a href="{{ route("page.products") }}">Ürünler</a>
                </li>
                <li class="{{ Route::is("page.about") ? "active" : "" }}">
                    <a href="{{ route("page.about") }}">Hakkımızda</a>
                </li>
                <li class="{{ Route::is("page.contact") ? "active" : "" }}">
                    <a href="{{ route("page.contact") }}">İletişim</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
