@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <!-- Jquery Toast css -->
    <link href="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Products'"/>

    <x-admin.datatable.layout.datatable-items
        :edit-all-route='route("product-quantity.edit", ["product_quantity" => encrypt($quantities[0]->product_id)])'>

        <x-slot name="ths">
            <th>Ürün Adı</th>
            <th>Beden</th>
            <th>Renk</th>
            <th>Fiyat</th>
            <th>Eylem</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($quantities as $quantity)
                @php
                    $quantityId = encrypt($quantity->id);
                @endphp
                <tr itemid="{{ $quantityId }}">
                    <td>{{ $quantity->product->name ?? ""}}</td>
                    <td>{{ $quantity->size ?? ""}}</td>
                    <td>{{ $quantity->color ?? "" }}</td>
                    <td>{{ number_format($quantity->price ?? 0, 2)}} TL</td>
                    <td class="table-action">
                        <div class="d-flex">
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Stoğu sil'"
                                :class="'btn btn-danger p-1 btnsil mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>
@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[4]'"
        :order-index="'0'"
        :director="'desc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnsil'"
        :destroy-route='route("product-quantity.destroy", ["product_quantity" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>
@endsection
