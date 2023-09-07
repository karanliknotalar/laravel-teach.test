@extends("admin.layout.layout")

@section("css")
    {{--    <style>--}}
    {{--        /*body{margin-top:20px;*/--}}
    {{--        /*    background-color:#eee;*/--}}
    {{--        /*}*/--}}

    {{--        /*.card {*/--}}
    {{--        /*    box-shadow: 0 20px 27px 0 rgb(0 0 0 / 5%);*/--}}
    {{--        /*}*/--}}
    {{--        .card {--}}
    {{--            position: relative;--}}
    {{--            display: flex;--}}
    {{--            flex-direction: column;--}}
    {{--            min-width: 0;--}}
    {{--            word-wrap: break-word;--}}
    {{--            background-color: #fff;--}}
    {{--            background-clip: border-box;--}}
    {{--            border: 0 solid rgba(0,0,0,.125);--}}
    {{--            border-radius: 1rem;--}}
    {{--        }--}}
    {{--    </style>--}}
@endsection

@section("content")
    <x-admin.helpers.page-title-box
        :title="'Ürün Detay'"/>

    <div class="row">
        <div class="col-lg-12 p-3">
            <div class="card">
                <div class="card-body p-4">
                    <div class="invoice-title">
                        <h4 class="float-end font-size-15">Fatura #{{ $invoice->id }}
                            @if($invoice->payment_status == 1)
                                <span class="badge bg-success font-size-12 ms-2">Ödendi</span>
                            @endif
                        </h4>
                        <div class="mb-4">
                            <h2 class="mb-1 text-muted">Blabla.com</h2>
                        </div>
                        <div class="text-muted">
                            <p class="mb-1">Site Adı</p>
                            <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i>Site Mail</p>
                            <p><i class="uil uil-phone me-1"></i>Site Telefon</p>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="text-muted">
                                <h5 class="font-size-16 mb-3">Ödeyen:</h5>
                                <h5 class="font-size-15 mb-2">{{ $invoice->f_name . " " . $invoice->l_name }}</h5>
                                <p class="mb-1">{{ $invoice->address ?? "" }}</p>
                                <p class="mb-1">{{ $invoice->province ?? "" }}/{{ $invoice->district }}</p>
                                <p class="mb-1">{{ strtoupper($invoice->country ?? "") }}</p>
                                <p class="mb-1"><i class="uil uil-envelope-alt me-1"></i>{{ $invoice->email ?? "" }}</p>
                                <p><i class="uil uil-phone me-1"></i>{{ $invoice->phone ?? "" }}</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-muted text-sm-end">
                                <div>
                                    <h5 class="font-size-15 mb-1">Fatura No:</h5>
                                    <p>#{{ $invoice->id }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Fatura Tarihi:</h5>
                                    <p>{{ Carbon::parse($invoice->created_at)->format("d.m.y H:i") }}</p>
                                </div>
                                <div class="mt-4">
                                    <h5 class="font-size-15 mb-1">Sipariş No:</h5>
                                    <p>{{ $invoice->order_no }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <h5 class="font-size-15">Sipariş Özeti</h5>

                        <div class="table-responsive">
                            <table class="table align-middle table-nowrap table-centered mb-0">
                                <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Ürün</th>
                                    <th>Fiyat</th>
                                    <th>KDV</th>
                                    <th>Adet</th>
                                    <th class="text-end" style="width: 120px;">Toplam</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php
                                    $total = 0;
                                    $total_vat = 0;
                                @endphp
                                @if(isset($invoice) and isset($invoice->orders) and $invoice->orders->count() > 0)
                                    @foreach($invoice->orders as $order)
                                        @php
                                            $total += ($order->price * $order->quantity);
                                            $total_vat += (Helper::getVat($order->price, $order->VAT) * $order->quantity);
                                        @endphp
                                        <tr>
                                            <th scope="row">01</th>
                                            <td>
                                                <div>
                                                    <h5 class="text-truncate font-size-14 mb-1">{{ $order->product->name ?? ""}}</h5>
                                                    <p class="text-muted mb-0">{{ $order->size ?? "" }}, {{ $order->color ?? "" }}</p>
                                                </div>
                                            </td>
                                            <td>{{ number_format($order->price, 2) }} ₺</td>
                                            <td>{{ $order->VAT }}%</td>
                                            <td>{{ $order->quantity ?? 1 }}</td>
                                            <td class="text-end">{{ number_format($order->price * $order->quantity, 2) }} ₺</td>
                                        </tr>
                                    @endforeach
                                @endif
                                <tr>
                                    <th scope="row" colspan="5" class="text-end">Ara Toplam:</th>
                                    <td class="text-end">{{ number_format($total, 2) }} ₺</td>
                                </tr>
                                <tr>
                                    <th scope="row" colspan="5" class="border-0 text-end">KDV Toplam:</th>
                                    <td class="border-0 text-end">{{ number_format($total_vat, 2) }} ₺</td>
                                </tr>
                                @if(isset($invoice) and isset($invoice->coupon))
                                    <tr>
                                        <th scope="row" colspan="5" class="border-0 text-end">
                                            İndirim/Kupon ({{ $invoice->coupon->name ?? "" }}):
                                        </th>
                                        <td class="border-0 text-end">-{{ number_format($invoice->coupon->price ?? 0, 2) }} ₺</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th scope="row" colspan="5" class="border-0 text-end">Toplam:</th>
                                    <td class="border-0 text-end"><h4 class="m-0 fw-semibold">{{ number_format($invoice->amount_paid, 2) }} ₺</h4></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-print-none mt-4">
                            <div class="float-end">
                                <a href="javascript:window.print()" class="btn btn-success me-1"><i
                                        class="fa fa-print"></i>Yazdır</a>
                                <a href="#" class="btn btn-primary w-md">Gönder</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section("js")
@endsection
