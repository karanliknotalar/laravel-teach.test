@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Products'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("product.create")'>

        <x-slot name="ths">
            <th>Resim</th>
            <th>Ürün</th>
            <th>Kategori</th>
            <th>Kısa Açıklama</th>
            <th>Durum</th>
            <th>Eylem</th>
            <th>Eklenme T.</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($products as $product)
                @php
                    $productId = encrypt($product->id);
                @endphp
                <tr itemid="{{ $productId }}">
                    <td>
                        <img src="{{ asset($product->image ?? "images/cloth_1.jpg") }}" alt="image"
                             class="img-fluid avatar-lg">
                    </td>
                    <td>{{ $product->name }} <br><span class="small text-success">Ürün Kodu: {{ $product->product_code }}</span></td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->sort_description ?? "" }}</td>

                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="$productId"
                            :status="$product->status"
                            :select-class="'productStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("product.edit", ["product" => $productId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Ürünü düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <a class="mx-1"
                               href="{{ route("product-quantity.show", ["product_quantity" => $productId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Ürün stoklarını düzenle'"
                                    :class="'btn btn-warning p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-stocking"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Ürünü sil'"
                                :class="'btn btn-danger p-1 btnDelete mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                    <td>{{ $product->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>
@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[0,4,5]'"
        :order-index="'6'"
        :director="'desc'"/>

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnDelete'"
        :destroy-route='route("product.destroy", ["product" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

    <x-admin.jquery-toast.jquery-toast-js
        :use-toast-status="true"
        :select-checkbox-query="'.productStatus'"
        :update-route='route("product.update", ["product" => ":id"])'>
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>

@endsection
