@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
@endsection

@section("content")
    <form
        action="{{ isset($product) ? route("product.update", ["product" => encrypt($product->id)]) : route("product.store")  }}"
        method="post" enctype="multipart/form-data">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif

        <x-admin.helpers.layout.edit-page-layout
            :model="$product ?? null"
            :page-title="'Ürün'"
            :image="$product->image ?? ''">
            <x-slot name="contents">

                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$product->name ?? ''"
                    :title="'Başlık'"/>

                <x-admin.helpers.input-text
                    :name="'product_code'"
                    :value="$product->product_code ?? ''"
                    :title="'Ürün Kodu'"/>

                <x-admin.helpers.quill-text-area
                    :quill-style="'height: 250px;'"
                    :hidden-id="'quilltext'"
                    :content="$product->description ?? ''"
                    :name="'description'"
                    :title="'İçerik'"/>

                <x-admin.helpers.input-text
                    :name="'sort_description'"
                    :value="$product->sort_description ?? ''"
                    :title="'Kısa Açıklama'"/>

                <div class="form-floating mb-3">
                    <select class="form-select" aria-label="Kategori Seçin" name="category_id">
                        <option>---Kategori Seçin---</option>
                        @if(isset($categories))
                            @foreach($categories as $category)
                                <option
                                    value="{{ $category->id }}"
                                    {{ isset($product->category_id) && $product->category_id == $category->id ? "selected" : "" }}>
                                    {!! $category->parent_id == null ? "$category->name" : "&nbsp;&nbsp;&nbsp;&nbsp;$category->name"  !!}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <label for="mainCategorySelect">Kategoriler</label>
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" aria-label="KDV Oranı Seçin" name="VAT_id">
                        <option>---KDV Oranı Seçin---</option>
                        @if(isset($vats))
                            @foreach($vats as $vat)
                                <option
                                    value="{{ $vat->id }}"
                                    {{ isset($product->VAT_id) && $product->VAT_id == $vat->id ? "selected" : "" }}>
                                    {{ $vat->VAT }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <label for="mainCategorySelect">KDV Oranı</label>
                </div>

                <x-admin.helpers.input-file
                    :name="'image'"
                    :title="'Resim Seç (1900x890)'"/>

                <x-admin.helpers.input-checkbox
                    :label-title="'Durum:'"
                    :name="'status'"
                    :checked-status="isset($product) && $product->status == 1 ? 'checked' : ''"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($product) ? "Güncelle" : "Kaydet" }}
                </button>
            </x-slot>
            @if(!isset($product))
                <x-slot name="productDetail">
                    <div class="d-flex productDetail">
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
                                :class="'btn btn-danger p-1 mx-1 btnRemove'"
                                :message="'Sil'"
                                :over-text="true">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </div>
                </x-slot>
            @endif
        </x-admin.helpers.layout.edit-page-layout>
    </form>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-hidden-id="'quilltext'"/>
    <script>
        $("#addProductDetail").on("click", function () {
            let product = $(".productDetail");
            product.last().clone().insertBefore(product.last());
        });
    </script>
    <script>
        $(document).on("click", ".btnRemove", function () {
            if ($(".productDetail").length > 1)
                $(this).parent().parent().remove();
        });
    </script>
@endsection
