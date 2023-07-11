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
                action="{{ isset($slider) ? route("slider.update", ["slider" => encrypt($slider->id)]) : route("slider.store") }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($slider))
                    @method('PUT')
                @endif
                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$slider->name ?? ''"
                    :title="'Başlık'"/>

                <x-admin.helpers.quill-text-area
                    :quill-style="'height: 200px;'"
                    :hidden-id="'quilltext'"
                    :content="$slider->content ?? ''"
                    :name="'content'"
                    :title="'İçerik'"/>

                <x-admin.helpers.input-text
                    :name="'shop_url'"
                    :value="$slider->shop_url ?? ''"
                    :title="'Url'"/>

                <x-admin.helpers.input-file
                    :name="'image'"
                    :title="'Resim Seç (1900x890)'"/>

                <x-admin.helpers.input-checkbox
                    :label-title="'Durum:'"
                    :name="'status'"
                    :checked-status="isset($slider) && $slider->status == 1 ? 'checked' : ''"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($slider) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-hidden-id="'quilltext'"/>
@endsection
