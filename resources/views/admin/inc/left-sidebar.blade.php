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

        <!--- Sidemenu -->
        <ul class="side-nav">

            <li class="side-nav-title">Menü</li>

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("dashboard.index")'
                :name="'Dashboards'"
                :icon-name="'uil-home-alt'"
            />

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("category.index")'
                :name="'Kategoriler'"
                :icon-name="'mdi mdi-box-shadow'"
                :count="$categoryCount ?? null"
            />

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarEcommerce" aria-expanded="false" aria-controls="sidebarEcommerce" class="side-nav-link">
                    <i class="uil-store"></i>
                    <span> E-ticaret </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarEcommerce">
                    <ul class="side-nav-second-level">
                        <x-admin.helpers.sidebar-single-menu-item
                            :url='route("product.index")'
                            :name="'Ürünler'"
                            :count="$productCount ?? null"
                        />
                        <x-admin.helpers.sidebar-single-menu-item
                            :url='route("order.index")'
                            :name="'Siparişler'"
                            :count="$orderIncompleteCount ?? null"
                            :counter-color="'bg-danger'"
                        />
                        <x-admin.helpers.sidebar-single-menu-item
                            :url='route("coupon.index")'
                            :name="'Kuponlar'"
                            :count="$couponCount ?? null"
                        />
                        <x-admin.helpers.sidebar-single-menu-item
                            :url='route("vat.index")'
                            :name="'KDV Oranları'"
                            :count="$vatCount ?? null"
                        />
                        <x-admin.helpers.sidebar-single-menu-item
                            :url='route("shipping-company.index")'
                            :name="'Kargo Şirketleri'"
                            :count="$shippingCompanyCount ?? null"
                        />
                    </ul>
                </div>
            </li>

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("slider.index")'
                :name="'Sliders'"
                :icon-name="'uil-sliders-v-alt'"
                :count="$sliderCount"
            />

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("service.index")'
                :name="'Hizmetler'"
                :icon-name="'mdi mdi-truck-minus'"
                :count="$serviceCount"
            />

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("contact.index")'
                :name="'İletişim'"
                :icon-name="'uil-envelope'"
                :count="$contactCount"
                :counter-color="'bg-danger'"
            />

            <x-admin.helpers.sidebar-single-menu-item
                :url='route("about.edit")'
                :name="'Hakkında'"
                :icon-name="'ri-team-fill'"
            />
            <x-admin.helpers.sidebar-single-menu-item
                :url='route("site-settings.index")'
                :name="'Site Ayarları'"
                :icon-name="'ri-settings-fill'"
            />

        </ul>
        <div class="clearfix"></div>
    </div>
</div>
