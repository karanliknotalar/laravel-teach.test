@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$category ?? null"
        :page-title="'Ürün'"
        :image="$category->image ?? ''">
        <x-slot name="contents">
            <form
                action="{{ isset($category) ? route("category.update", ["category" => encrypt($category->id)]) : route("category.store")  }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($category))
                    @method('PUT')
                @endif
                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$category->name ?? ''"
                    :title="'Başlık'"/>
                <div class="form-floating mb-3">
                    <input type="hidden" name="description" id="quilltext">
                    <h6 class="mb-2">Açıklama</h6>
                    <div id="snow-editor" style="height: 100px;">
                        {!! $category->description ?? "" !!}
                    </div>
                </div>

                <x-admin.helpers.input-text
                    :name="'seo_description'"
                    :value="$category->seo_description ?? ''"
                    :title="'Seo Açıklaması'"/>
                <x-admin.helpers.input-text
                    :name="'seo_keywords'"
                    :value="$category->seo_keywords ?? ''"
                    :title="'Seo Meta Etiketleri'"/>

                <div class="form-floating mb-3">
                    @php
                        $parent_id = $category->parent_id ?? null;
                    @endphp
                    <select class="form-select" id="categoryTypeSelect"
                            aria-label="Kategori Türü" name="categoryType">
                        <option {{ isset($category) ? "" : "selected" }}>Kategori Türü</option>
                        <option
                            value="main" {{ isset($category) ? $parent_id ? "" : "selected" : "" }}>
                            Main
                        </option>
                        <option
                            value="alt" {{ isset($category) ? $parent_id ? "selected" : "" : "" }}>
                            Alt
                        </option>
                    </select>
                    <label for="categoryTypeSelect">Kategori Türünü Seçin</label>
                </div>
                <div class="form-floating mb-3">
                    <select class="form-select" id="mainCategorySelect"
                            aria-label="Ana Kategori Türü" name="parent_id">
                        <option>Ana Kategori Türü</option>
                        @if(isset($main_categories))
                            @foreach($main_categories as $main_category)
                                <option
                                    value="{{ $main_category->id }}"
                                    {{ $parent_id == $main_category->id ? "selected" : "" }}>{{ $main_category->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    <label for="mainCategorySelect">Ana Kategori Seçin</label>
                </div>

                <div class="mb-3">
                    <label for="image" class="mb-1">Resim Seç (1900x890)</label>
                    <input type="file" id="image" class="form-control" name="image">
                </div>
                <div class="mb-4">
                    <div class="d-flex">
                        <label class="label-default me-2">Durum:</label>
                        <input type="checkbox" id="status"
                               data-switch="success"
                               name="status" {{ isset($category) && $category->status == 1 ? "checked" : ""}}/>
                        <label for="status" data-on-label="On" data-off-label="Off"
                               class="mb-0 d-block"></label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($category) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>

@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-element-id="'quilltext'"/>
    <script>
        jQuery(window).on("load", function () {
            const categoryTypeSelect = function () {

                let type = $("#categoryTypeSelect").val();
                let mainCategory = $("#mainCategorySelect").parent();
                let image = $("#image").parent();

                if (type === "main") {
                    mainCategory.hide();
                    image.show();
                } else if (type === "alt") {
                    image.hide();
                    mainCategory.show();
                } else {
                    image.show();
                    mainCategory.hide();
                }
            };
            categoryTypeSelect();

            $("#categoryTypeSelect").change(function () {
                categoryTypeSelect();
            });
        });
    </script>
@endsection
