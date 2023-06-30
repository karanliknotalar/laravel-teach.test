<footer class="site-footer border-top">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="footer-heading mb-4">Menü</h3>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <ul class="list-unstyled">
                            <li><a href="{{ route("home.index") }}">Anasayfa</a></li>
                            <li><a href="{{ route("page.products") }}">Ürünler</a></li>
                            <li><a href="{{ route("page.about") }}">Hakkımızda</a></li>
                            <li><a href="{{ route("page.contact") }}">İletişim</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6">
                <div class="block-5 mb-5">
                    @if(isset($site_contact_setting))
                        <h3 class="footer-heading mb-4">İletişim</h3>
                        <ul class="list-unstyled">
                            @if(isset($site_contact_setting['address']))
                                <li class="address">{{ $site_contact_setting['address'] ?? "" }}</li>
                            @endif
                            @if(isset($site_contact_setting['phone']))
                                <li class="phone">
                                    <a href="tel://{{$site_contact_setting['phone'] ?? ""}}">{{ $site_contact_setting['phone'] ?? "" }}</a>
                                </li>
                            @endif
                            @if(isset($site_contact_setting['email']))
                                <li class="email">{{ $site_contact_setting['email'] }}</li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
        <div class="row pt-5 mt-5 text-center">
            <div class="col-md-12">
                <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy; {{ date("Y") }}
                    All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a
                        href="https://colorlib.com" target="_blank" class="text-primary">Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                </p>
            </div>
        </div>
    </div>
</footer>
