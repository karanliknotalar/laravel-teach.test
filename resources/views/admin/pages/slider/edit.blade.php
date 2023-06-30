@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$slider ?? null"
        :page-title="'Slider'"
        :image="$slider->image ?? ''">
        <x-slot name="contents">
            <form
                action="{{ isset($slider) ? route("slider.update", ["slider" => encrypt($slider->id)]) : route("slider.store")  }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($slider))
                    @method('PUT')
                @endif
                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$slider->name ?? ''"
                    :title="'Başlık'"/>
                <div class="mb-3">
                    <input type="hidden" name="content" id="quilltext">
                    <h6 class="mb-2">İçerik</h6>
                    <div id="snow-editor" style="height: 300px;">
                        {!! $slider->content ?? "" !!}
                    </div>
                </div>

                <x-admin.helpers.input-text
                    :name="'shop_url'"
                    :value="$slider->shop_url ?? ''"
                    :title="'Url'"/>

                <div class="mb-3">
                    <label for="image" class="mb-1">Resim Seç (1900x890)</label>
                    <input type="file" id="image" class="form-control" name="image">
                </div>
                <div class="mb-4">
                    <div class="d-flex">
                        <label class="label-default me-2">Durum:</label>
                        <input type="checkbox" id="status"
                               data-switch="success"
                               name="status" {{ isset($slider) && $slider->status == 1 ? "checked" : ""}}/>
                        <label for="status" data-on-label="On" data-off-label="Off"
                               class="mb-0 d-block"></label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($slider) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-element-id="'quilltext'"/>
@endsection
