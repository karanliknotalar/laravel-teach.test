@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>
@endsection

@section("content")

    <x-admin.helpers.page-title-box
        :title="'Ürünler'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("product.create")'>

        <x-slot name="ths">
            <th style="width: max-content">Resim</th>
            <th>Ürün</th>
            <th>Kategori</th>
            <th>Kısa Açıklama</th>
            <th>Durum</th>
            <th>Özellikli</th>
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
                        <img src="{{ asset($product->image ?? "images/cloth_1.jpg") }}" alt="{{ $product->name }}"
                             style="width: 6rem">
                    </td>
                    <td>{{ $product->name }} <br><span
                            class="small text-success">Ürün Kodu: {{ $product->product_code }}</span></td>
                    <td>{{ $product->category_name }}</td>
                    <td>
                        <p class="text-wrap w-100">
                            {{ $product->sort_description ?? "" }}
                        </p>
                    </td>
                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="$productId"
                            :status="$product->status"
                            :select-class="'productStatus'"/>
                    </td>
                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="'featured_'.$productId"
                            :status="$product->featured"
                            :select-class="'featuredStatus'"/>
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
                               href="{{ route("product-quantity.index", ["product_id" => $productId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Ürün resim ve stoklarını düzenle'"
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
        :column-defs-targets="'[0,4,5,6]'"
        :order-index="'7'"
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
        :update-route='route("product.update-status", ["id" => ":id"])'
        :method="'POST'">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>

    <x-admin.jquery-toast.jquery-toast-js
        :use-toast-status="true"
        :select-checkbox-query="'.featuredStatus'"
        :update-route='route("product.featured-status", ["id" => ":id"])'
        :method="'POST'">
        <x-slot name="id">
            $(this).closest("tr").attr("itemid")
        </x-slot>
    </x-admin.jquery-toast.jquery-toast-js>

@endsection
