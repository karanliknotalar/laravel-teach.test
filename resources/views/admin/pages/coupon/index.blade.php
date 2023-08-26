@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
            :title="'Kuponlar'"/>

    <x-admin.datatable.layout.datatable-items
            :add-new-route='route("coupon.create")'>

        <x-slot name="ths">
            <th style="width: 20%">Kupon Adı</th>
            <th style="width: 20%">İndirim Tutarı</th>
            <th>Durum</th>
            <th>Sona Erme</th>
            <th>Eylem</th>
            <th>Oluşturulma</th>
        </x-slot>

        <x-slot name="tbody">
            @foreach($coupons as $coupon)
                @php
                    $couponId = encrypt($coupon->id);
                @endphp
                <tr itemid="{{ $couponId }}">

                    <td>{{ $coupon->name }}</td>
                    <td>{{ number_format($coupon->price, 2) }} TL</td>
                    <td>
                        <x-admin.helpers.datatable-checkbox
                                :id="$couponId"
                                :status="$coupon->status"
                                :select-class="'couponStatus'"/>
                    </td>
                    <td>{{ $coupon->expired_at }}<br>
                        @php
                            $secondCheck = Helper::timeToSecond($coupon->expired_at) > 0;
                        @endphp
                        <span class="small {{ $secondCheck ? "link-success" : "link-danger" }}">
                            {{  $secondCheck ? "Aktif" : "Süresi Dolmuş" }}
                        </span>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("coupon.edit", ["coupon" => $couponId]) }}">
                                <x-admin.helpers.button
                                        :over-text="true"
                                        :message="'Kuponu düzenle'"
                                        :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Kuponu sil'"
                                    :class="'btn btn-danger p-1 btnDelete mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                    <td>{{ $coupon->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
            :column-defs-targets="'[2, 4]'"
            :order-index="'0'"
            :director="'desc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
            :use-delete-js="true"
            :select-btn-query="'.btnDelete'"
            :destroy-route='route("coupon.destroy", ["coupon" => ":id"])'
            :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

    <x-admin.jquery-toast.jquery-toast-js
            :use-toast-status="true"
            :select-checkbox-query="'.couponStatus'"
            :update-route='route("coupon.update-status", ["id" => ":id"])'
            :method="'POST'">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>
@endsection
