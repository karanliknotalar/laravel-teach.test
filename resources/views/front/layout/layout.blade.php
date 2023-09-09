<!DOCTYPE html>
<html lang="tr">
<head>
    <title>{{ config("app.name") }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ $seo["seo_description"] ?? ($site_settings["seo_description"] ?? "") }}">
    <meta name="keywords" content="{{ $seo["seo_keywords"] ?? ($site_settings["seo_keywords"] ?? "") }}">
    <meta name="author" content="{{ config("app.name") }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700">
    <!-- Twitter Metas -->
    <meta name="twitter:title" content="{{ $seo["seo_title"] ?? ($site_settings["seo_title"] ?? "") }}">
    <meta name="twitter:description" content="{{ $seo["seo_description"] ?? ($site_settings["seo_description"] ?? "") }}">
    <meta name="twitter:site" content="{{ $site_settings["twitter_site"] ?? "" }}">
    <meta name="twitter:creator" content="{{ $site_settings["twitter_author"] ?? "" }}">
    <meta name="twitter:image" content="{{ asset($seo["seo_image"] ?? ($site_settings["seo_image"] ?? ""))  }}">
    <meta name="twitter:image:src" content="{{ asset($seo["seo_image"] ?? ($site_settings["seo_image"] ?? ""))  }}">
    <meta name="twitter:card" content="summary">
    <!-- Facebook Metas -->
    <meta property="og:title" content="{{ $seo["seo_title"] ?? ($site_settings["seo_title"] ?? "") }}">
    <meta property="og:description" content="{{ $seo["seo_description"] ?? ($site_settings["seo_description"] ?? "") }}">
    <meta property="og:url" content="{{ URL::current() ?? "" }}">
    <meta property="og:site_name" content="{{ config("app.name") }}">
    <meta property="og:image" content="{{ asset($seo["seo_image"] ?? ($site_settings["seo_image"] ?? ""))  }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="tr_TR">
    <!-- No Cache -->
    <meta http-equiv="content-type" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="refresh" content="no-cache">
    <link rel="stylesheet" href="{{ asset('/') }}fonts/icomoon/style.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/magnific-popup.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/jquery-ui.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/aos.css">
    @yield("css")
    <link rel="stylesheet" href="{{ asset('/') }}css/style.css">
</head>
<body>

<div class="site-wrap">

    @include("front.inc.header")

    @yield("content")

    @include("front.inc.footer")

</div>

<script src="{{ asset("/") }}js/jquery-3.3.1.min.js"></script>
<script src="{{ asset("/") }}js/jquery-ui.js"></script>
<script src="{{ asset('/') }}js/popper.min.js"></script>
<script src="{{ asset('/') }}js/bootstrap.min.js"></script>
<script src="{{ asset('/') }}js/owl.carousel.min.js"></script>
<script src="{{ asset('/') }}js/jquery.magnific-popup.min.js"></script>
<script src="{{ asset('/') }}js/aos.js"></script>
@yield("js")
<script src="{{ asset('/') }}js/main.js"></script>

</body>
</html>
