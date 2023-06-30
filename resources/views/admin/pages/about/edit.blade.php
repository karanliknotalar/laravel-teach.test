@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
    <!-- Select2 css -->
    <link href="{{ $asset }}vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$about ?? null"
        :page-title="'Hakkında'"
        :image="$about->image ?? ''">

        <x-slot name="contents">
            <form action="{{ route("about.update") }}" method="post" enctype="multipart/form-data">
                @csrf

                <x-admin.helpers.input-text
                    :name="'title'"
                    :value="$about->title ?? ''"
                    :title="'Başlık'"/>

                <x-admin.helpers.quill-text-area
                    :quill-style="'height: 200px;'"
                    :hidden-id="'quilltext'"
                    :content="$about->content ?? ''"
                    :name="'content'"
                    :title="'İçerik'"/>

                <x-admin.helpers.input-text
                    :name="'channel'"
                    :value="$about->channel ?? ''"
                    :title="'Tanıtım Video Linki'"/>

                <x-admin.helpers.input-file
                    :name="'image'"
                    :title="'Resim Seç (900x600)'"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    Güncelle
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-hidden-id="'quilltext'"/>

    <!--  Select2 Js -->
    <script src="{{ $asset }}vendor/select2/js/select2.min.js"></script>

    <script>
        $('.select2').select2({});
    </script>
@endsection
