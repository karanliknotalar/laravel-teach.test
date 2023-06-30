<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="utf-8"/>
    <title>Admin Paneli</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
    <meta content="Coderthemes" name="author"/>
    <!-- No Cache -->
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ $asset }}images/favicon.ico">
    <!-- Theme Config Js -->
    <script src="{{ $asset }}js/hyper-config.js"></script>
    <!-- App css -->
    <link href="{{ $asset }}css/app-saas.min.css" rel="stylesheet" type="text/css" id="app-style"/>
    <!-- Icons css -->
    <link href="{{ $asset }}css/icons.min.css" rel="stylesheet" type="text/css"/>
    <!-- Custom css -->
    @yield("css")

</head>

<body>
<!-- Begin page -->
<div class="wrapper">

    <!-- ========== Topbar Start ========== -->
    @include("admin.inc.header")
    <!-- ========== Topbar End ========== -->

    <!-- ========== Left Sidebar Start ========== -->
    @include("admin.inc.left-sidebar")
    <!-- ========== Left Sidebar End ========== -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                @yield("content")
            </div> <!-- container -->

        </div>
        <!-- content -->

        <!-- Footer Start -->
        @include("admin.inc.footer")
        <!-- end Footer -->

    </div>
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->

</div>
<!-- END wrapper -->

{{--<!-- Theme Settings -->--}}
{{--@include("admin.inc.theme-settings")--}}

<!-- Vendor js -->
<script src="{{ $asset }}js/vendor.min.js"></script>

<!-- App js -->
<script src="{{ $asset }}js/app.min.js"></script>

<!-- Custom Js -->
@yield("js")

</body>
</html>
