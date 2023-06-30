<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8" />
    <title>Giriş Yap | Admin Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset("admin-assets")."/" }}images/favicon.ico">

    <!-- Theme Config Js -->
    <script src="{{ asset("admin-assets")."/" }}js/hyper-config.js"></script>

    <!-- App css -->
    <link href="{{ asset("admin-assets")."/" }}css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="{{ asset("admin-assets")."/" }}css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body class="authentication-bg">
<div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">
                <div class="card">

                    <!-- Logo -->
                    <div class="card-header py-4 text-center bg-primary">
                        <a href="{{ route("home.index") }}">
                            <span><img src="{{ asset("admin-assets")."/" }}images/logo.png" alt="logo" height="22"></span>
                        </a>
                    </div>

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <h4 class="text-dark-50 text-center pb-0 fw-bold">Admin Panel</h4>
                            <p class="text-muted mb-4">Email adresi ve şifrenizi girin.</p>
                        </div>

                        @if(count($errors) > 0)
                            @foreach($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <form action="{{ route("auth.login") }}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input class="form-control" type="email" id="email" placeholder="Email adresinizi girin" name="email">
                            </div>

                            <div class="mb-3">
                                <a href="{{ route("password.reset") }}" class="text-muted float-end"><small>Şifreni mi unuttun?</small></a>
                                <label for="password" class="form-label">Şifre</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" placeholder="Şifrenizi girin" name="password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3 mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked name="remember_token">
                                    <label class="form-check-label" for="checkbox-signin">Beni Hatırla</label>
                                </div>
                            </div>

                            <div class="mb-3 mb-0 text-center">
                                <button class="btn btn-primary" type="submit"> Giriş Yap </button>
                            </div>

                        </form>
                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->

<footer class="footer footer-alt">
    {{ date("Y") }} © blabla.com
</footer>
<!-- Vendor js -->
<script src="{{ asset("admin-assets")."/" }}js/vendor.min.js"></script>

<!-- App js -->
<script src="{{ asset("admin-assets")."/" }}js/app.min.js"></script>

</body>
</html>
