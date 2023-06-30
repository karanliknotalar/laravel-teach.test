@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
@endsection

@section("content")
    <form
        action="{{ route("product-quantity.store") }}"
        method="post" enctype="multipart/form-data">
        @csrf

        <x-admin.helpers.layout.edit-page-layout
            :model="null"
            :page-title="'Ürün Stokları'">
            <x-slot name="contents">

                <h4 class="page-title">{{ $imageElementTitle ?? "Ürün Detayları"}}
                    <button type="button" class="mx-2 px-1 py-1 btn btn-success"
                            id="addProductDetail"
                            tabindex="0"
                            data-bs-placement="top"
                            data-bs-toggle="popover"
                            data-bs-trigger="hover"
                            data-bs-content="Alan Ekle">
                        <i class="mdi mdi-plus"></i>
                    </button>
                </h4>
                <div class="d-flex productDetail">
                    <input type="hidden" value="{{ $product_id ?? "" }}" name="product_id">
                    <x-admin.helpers.input-text
                        :main-class="'mx-1 mb-2'"
                        :name="'size[]'"
                        :value="$product->size ?? ''"
                        :title="'Beden'"
                        :input-type="'numeric'"/>

                    <x-admin.helpers.input-text
                        :main-class="'mx-1 mb-2'"
                        :name="'color[]'"
                        :value="$product->color ?? ''"
                        :title="'Renk'"/>

                    <x-admin.helpers.input-text
                        :main-class="'mx-1 mb-2'"
                        :name="'price[]'"
                        :value="$product->price ?? '0.00'"
                        :title="'Fiyat'"
                        :input-type="'numeric'"/>

                    <x-admin.helpers.input-text
                        :main-class="'mx-1 mb-2'"
                        :name="'quantity[]'"
                        :value="$product->quantity ?? '0'"
                        :title="'Stok'"
                        :input-type="'numeric'"/>

                    <div class="px-1 py-1">
                        <x-admin.helpers.button
                            :class="'btn btn-danger p-1 btnsil mx-1 btnRemove'"
                            :message="'Sil'">
                            <x-slot:text>
                                <i class="mdi mdi-delete"></i>
                            </x-slot:text>
                        </x-admin.helpers.button>
                    </div>

                </div>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($product) ? "Güncelle" : "Kaydet" }}
                </button>
            </x-slot>

        </x-admin.helpers.layout.edit-page-layout>
    </form>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-hidden-id="'quilltext'"/>
    <script>
        $("#addProductDetail").on("click", function () {
            let product = $(".productDetail");
            product.parent().append(product.last().clone());
        });
    </script>
    <script>
        $(document).on("click", ".btnRemove", function () {
            if ($(".productDetail").length > 1)
                $(this).parent().parent().remove();
        });
    </script>
@endsection
