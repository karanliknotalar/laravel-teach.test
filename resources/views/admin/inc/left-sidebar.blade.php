<div class="leftside-menu">

    <!-- Brand Logo Light -->
    <a href="{{ route("dashboard.index") }}" class="logo logo-light">
                    <span class="logo-lg">
                        <img src="{{ $asset }}images/logo.png" alt="logo">
                    </span>
        <span class="logo-sm">
                        <img src="{{ $asset }}images/logo-sm.png" alt="small logo">
                    </span>
    </a>

    <!-- Brand Logo Dark -->
    <a href="index.html" class="logo logo-dark">
                    <span class="logo-lg">
                        <img src="{{ $asset }}images/logo-dark.png" alt="dark logo">
                    </span>
        <span class="logo-sm">
                        <img src="{{ $asset }}images/logo-dark-sm.png" alt="small logo">
                    </span>
    </a>

    <!-- Sidebar Hover Menu Toggle Button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>

    <!-- Full Sidebar Menu Close Button -->
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar -left -->
    <div class="h-100" id="leftside-menu-container" data-simplebar>
        <!-- Leftbar User -->
        <div class="leftbar-user">
            <a href="pages-profile.html">
                <img src="{{ $asset }}images/users/avatar-1.jpg" alt="user-image" height="42"
                     class="rounded-circle shadow-sm">
                <span class="leftbar-user-name mt-2">Dominic Keller</span>
            </a>
        </div>

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Navigation</li>

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("dashboard.index")'
                :name="'Dashboards'"
                :icon-name="'uil-home-alt'"
            />

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("category.index")'
                :name="'Kategoriler'"
                :icon-name="'mdi mdi-box-shadow'"
                :count="$categoryCount"
            />

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("slider.index")'
                :name="'Sliders'"
                :icon-name="'uil-sliders-v-alt'"
                :count="$sliderCount"
            />
            <x-admin.helpers.sidebar-single-menu-item
                :url='route("product.index")'
                :name="'Ürünler'"
                :icon-name="'ri-product-hunt-fill'"
                :count="$productCount"
            />
            <x-admin.helpers.sidebar-single-menu-item
                :url='route("service.index")'
                :name="'Hizmetler'"
                :icon-name="'mdi mdi-truck-minus'"
                :count="$serviceCount"
            />

            {{--            <li class="side-nav-item">--}}
            {{--                <a href="" class="side-nav-link">--}}
            {{--                    <i class="mdi mdi-room-service"></i>--}}
            {{--                    <span class="badge bg-primary float-end"></span>--}}
            {{--                    <span>Test</span>--}}
            {{--                </a>--}}
            {{--            </li>--}}

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
