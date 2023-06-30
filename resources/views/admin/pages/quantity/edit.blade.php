@extends("admin.layout.layout")

@section("css")
@endsection

@section("content")
    <form
        action="{{ route("product-quantity.store") }}"
        method="post" enctype="multipart/form-data">
        @csrf

        <x-admin.helpers.layout.edit-page-layout
            :model="$quantities ?? null"
            :page-title="'Ürün Stokları'">
            <x-slot name="contents">

                <h4 class="page-title">{{ $imageElementTitle ?? "Ürün Detayları"}}
                    <x-admin.helpers.button
                        :class="'mx-2 px-1 py-1 btn btn-success'"
                        :id="'addProductDetail'"
                        :message="'Alan Ekle'">
                        <x-slot:text>
                            <i class="mdi mdi-plus"></i>
                        </x-slot:text>
                    </x-admin.helpers.button>
                </h4>

                @if(isset($quantities))
                    <input type="hidden"
                           value="{{ isset($quantities[0]->product_id) ? encrypt($quantities[0]->product_id) : "" }}"
                           name="product_id">
                    @foreach($quantities as $quantity)
                        <div class="d-flex productDetail">
                            <x-admin.helpers.input-text
                                :main-class="'mx-1 mb-2'"
                                :name="'size[]'"
                                :value="$quantity->size ?? ''"
                                :title="'Beden'"
                                :input-type="'numeric'"/>

                            <x-admin.helpers.input-text
                                :main-class="'mx-1 mb-2'"
                                :name="'color[]'"
                                :value="$quantity->color ?? ''"
                                :title="'Renk'"/>

                            <x-admin.helpers.input-text
                                :main-class="'mx-1 mb-2'"
                                :name="'price[]'"
                                :value="$quantity->price ?? '0.00'"
                                :title="'Fiyat'"
                                :input-type="'numeric'"/>

                            <x-admin.helpers.input-text
                                :main-class="'mx-1 mb-2'"
                                :name="'quantity[]'"
                                :value="$quantity->quantity ?? '0'"
                                :title="'Stok'"
                                :input-type="'numeric'"/>

                            <div class="px-1 py-1">
                                <x-admin.helpers.button
                                    :class="'btn btn-danger p-1 mx-1 btnRemove d-none'"
                                    :message="'Sil'"
                                    :over-text="true">
                                    <x-slot:text>
                                        <i class="mdi mdi-delete"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </div>
                        </div>
                    @endforeach
                @endif

                <x-admin.helpers.button
                    :class="'btn btn-success mx-auto form-control btnSave'"
                    :type="'submit'"
                    :text="'Kaydet'"/>
            </x-slot>

        </x-admin.helpers.layout.edit-page-layout>
    </form>
@endsection

@section("js")
    <script>
        $("#addProductDetail").on("click", function () {
            let product = $(".productDetail");
            product.last().clone().insertBefore(product.last());
            product.last().find("button").removeClass("d-none")
        });
        $(document).on("click", ".btnRemove", function () {
            if ($(".productDetail").length > {{ $quantities->count() }})
                $(this).parent().parent().remove();
        });
    </script>
@endsection
