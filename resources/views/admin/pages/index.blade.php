@extends("admin.layout.layout")

@section("css")
    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="{{ $asset }}vendor/daterangepicker/daterangepicker.css">
    <!-- Vector Map css -->
    <link rel="stylesheet" href="{{ $asset }}vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control form-control-light" id="dash-daterange">
                            <span class="input-group-text bg-primary border-primary text-white">
                                                    <i class="mdi mdi-calendar-range font-13"></i>
                                                </span>
                        </div>
                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </a>
                        <a href="javascript: void(0);" class="btn btn-primary ms-1">
                            <i class="mdi mdi-filter-variant"></i>
                        </a>
                    </form>
                </div>
                <h4 class="page-title">Dashboard</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-4">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-account-multiple widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Müşteri sayısı">Müşteriler</h5>
                            <h3 class="mt-3 mb-3">{{ $customerCount ?? 0 }}</h3>
                            <x-admin.index.change-rate-area
                            :rate="$rate['customer']"/>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-cart-plus widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Siparişler</h5>
                            <h3 class="mt-3 mb-3">{{ $orderCount ?? 0}}</h3>
                            <x-admin.index.change-rate-area
                                :rate="$rate['order']"/>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

            <div class="row">
                <div class="col-sm-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-currency-usd widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Hasılat</h5>
                            <h3 class="mt-3 mb-3">{{ number_format($revenue->total_revenue ?? 0, 2) }} ₺</h3>
                            <x-admin.index.change-rate-area
                                :rate="$rate['revenue']"/>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->

                <div class="col-sm-6">
                    <div class="card widget-flat">
                        <div class="card-body">
                            <div class="float-end">
                                <i class="mdi mdi-pulse widget-icon"></i>
                            </div>
                            <h5 class="text-muted fw-normal mt-0" title="Growth">Growth</h5>
                            <h3 class="mt-3 mb-3">+ 30.56%</h3>
                            <p class="mb-0 text-muted">
                                <span class="text-success me-2"><i class="mdi mdi-arrow-up-bold"></i> 4.87%</span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div> <!-- end row -->

        </div> <!-- end col -->
        <div class="col-xl-3 col-lg-6">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Total Sales</h4>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <i class="mdi mdi-dots-vertical"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div id="average-sales" class="apex-charts mb-4 mt-2"
                         data-colors="#727cf5,#0acf97,#fa5c7c,#ffbc00"></div>


                    <div class="chart-widget-list">
                        <p>
                            <i class="mdi mdi-square text-primary"></i> Direct
                            <span class="float-end">$300.56</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-danger"></i> Affilliate
                            <span class="float-end">$135.18</span>
                        </p>
                        <p>
                            <i class="mdi mdi-square text-success"></i> Sponsored
                            <span class="float-end">$48.96</span>
                        </p>
                        <p class="mb-0">
                            <i class="mdi mdi-square text-warning"></i> E-mail
                            <span class="float-end">$154.02</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-5 col-lg-6">
            <div class="card">
                <div class="d-flex card-header justify-content-between align-items-center">
                    <h4 class="header-title">Hasılat</h4>
                </div>
                <div class="card-body pt-0">
                    <div class="chart-content-bg">
                        <div class="row text-center">
                            <div class="col-sm-6">
                                <p class="text-muted mb-0 mt-3">Bu Hafta</p>
                                <h2 class="fw-normal mb-3">
                                    <small class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                    <span>{{ number_format($revenue->current_week_revenue ?? 0, 2) }} ₺</span>
                                </h2>
                            </div>
                            <div class="col-sm-6">
                                <p class="text-muted mb-0 mt-3">Geçen Hafta</p>
                                <h2 class="fw-normal mb-3">
                                    <small class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                    <span>{{ number_format($revenue->last_week_revenue ?? 0, 2) }} ₺</span>
                                </h2>
                            </div>
                        </div>
                    </div>

                    <div class="dash-item-overlay d-none d-md-block" dir="ltr">
                        <h5>Bugün Kazanılan: {{ number_format($revenue->today_revenue ?? 0, 2) }} ₺</h5>
                    </div>
                    <div dir="ltr">
                        <div id="revenue-chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(isset($topProducts) and $topProducts->count() > 0)
        <div class="row">
            <div class="col-xl-12 col-lg-12 order-lg-2 order-xl-1">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Çok Satılan {{ $topProducts->count() }} ürün</h4>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <tbody>
                                <th>Ürün Adı</th>
                                <th>Net Fiyat (Renge/Boyuta Göre Listelenir)</th>
                                <th>Toplam Stok Satış</th>
                                <th>Toplam Ödenen + KDV</th>
                                @foreach($topProducts as $topProduct)
                                    <tr>
                                        <td>
                                            <h5 class="font-14 my-1 fw-normal">{{ $topProduct->product->name }}</h5>
                                            <span
                                                class="text-muted font-13">{{ Carbon::create($topProduct->product->created_at)->format("d/m/y H:i") }}</span>
                                        </td>
                                        <td>
                                            @foreach($topProduct->productQuantity as $quantity)
                                                <h5 class="font-14 my-1 fw-normal">{{ number_format($quantity->price, 2) }}
                                                    ₺</h5>
                                            @endforeach
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 fw-normal">{{ $topProduct->total_quantity }}</h5>
                                        </td>
                                        <td>
                                            <h5 class="font-14 my-1 fw-normal">{{ number_format($topProduct->total_amount, 2) }}
                                                ₺</h5>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection

@section("js")
    <!-- Daterangepicker js -->
    <script src="{{ $asset }}vendor/daterangepicker/moment.min.js"></script>
    <script src="{{ $asset }}vendor/daterangepicker/daterangepicker.js"></script>
    <!-- Apex Charts js -->
    <script src="{{ $asset }}vendor/apexcharts/apexcharts.min.js"></script>
    <!-- Vector Map js -->
    <script src="{{ $asset }}vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="{{ $asset }}vendor/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js"></script>
    <!-- Dashboard App js -->
    {{--    <script src="{{ $asset }}js/dashboard.js"></script>--}}
    <script>
        $(document).ready(function (e) {

            // use this code if ajax request for chart data
            {{--$.ajax({--}}
            {{--    method: "GET",--}}
            {{--    url: "{{ route("dashboard.index") }}",--}}
            {{--    data: {"_token": "{{ csrf_token() }}",},--}}
            {{--    success: function (response) {--}}

            {{--        const lineOpt = {--}}
            {{--            chart: {height: 370, type: "line", dropShadow: {enabled: !0, opacity: .2, blur: 7, left: -7, top: 7}},--}}
            {{--            dataLabels: {enabled: !1},--}}
            {{--            stroke: {curve: "smooth", width: 4},--}}
            {{--            series: response.data,--}}
            {{--            colors: ["#727cf5", "#0acf97"],--}}
            {{--            zoom: {enabled: !1},--}}
            {{--            legend: {show: !1},--}}
            {{--            xaxis: {--}}
            {{--                type: "string",--}}
            {{--                categories: ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],--}}
            {{--                tooltip: {enabled: !1},--}}
            {{--                axisBorder: {show: !1}--}}
            {{--            },--}}
            {{--            grid: {strokeDashArray: 7},--}}
            {{--            yaxis: {--}}
            {{--                labels: {--}}
            {{--                    formatter: function (e) {--}}
            {{--                        return e + "K"--}}
            {{--                    }, offsetX: -15--}}
            {{--                }--}}
            {{--            }--}}
            {{--        };--}}
            {{--        new ApexCharts(document.querySelector("#revenue-chart"), lineOpt).render();--}}
            {{--    }--}}
            {{--});--}}
            // use this code if ajax request for chart data end

            $("#dash-daterange").daterangepicker({singleDatePicker: !0});

            const donutOpt = {
                chart: {height: 202, type: "donut"},
                legend: {show: !1},
                stroke: {colors: ["transparent"]},
                series: [44, 55, 41, 17],
                labels: ["Direct", "Affilliate", "Sponsored", "E-mail"],
                colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
                responsive: [{breakpoint: 480, options: {chart: {width: 200}, legend: {position: "bottom"}}}]
            };
            new ApexCharts(document.querySelector("#average-sales"), donutOpt).render();


            window.Apex = {
                chart: {parentHeightOffset: 0, toolbar: {show: !1}},
                grid: {padding: {left: 0, right: 0}},
            };

            const lineOpt = {
                chart: {height: 370, type: "line", dropShadow: {enabled: !0, opacity: .2, blur: 7, left: -7, top: 7}},
                dataLabels: {enabled: !1},
                stroke: {curve: "smooth", width: 4},
                series:
                    [
                        {name: "Bu Hafta", data: [{{ $chartData['currentWeek'] }}]},
                        {name: "Geçen Hafta", data: [{{ $chartData['subWeek'] }}]},
                    ],
                colors: ["#727cf5", "#0acf97"],
                zoom: {enabled: !1},
                legend: {show: !1},
                xaxis: {
                    type: "string",
                    categories: ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                    tooltip: {enabled: !1},
                    axisBorder: {show: !1}
                },
                grid: {strokeDashArray: 7},
                yaxis: {
                    labels: {
                        formatter: function (e) {
                            return e + "K"
                        }, offsetX: -15
                    }
                }
            };
            new ApexCharts(document.querySelector("#revenue-chart"), lineOpt).render();
        })
    </script>
@endsection
