@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$product ?? null"
        :page-title="'Ürün'"
        :image="$product->image ?? ''">
        <x-slot name="contents">
            @if(count($errors) > 0)
                @foreach($errors->all() as $error)
                    <div
                        class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                        role="alert">
                        <button type="button" class="btn-close btn-close-white"
                                data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ $error }}
                    </div>
                @endforeach
            @endif
            @if(session()->has("status"))
                <div
                    class="alert alert-success alert-dismissible bg-success text-white border-0 fade show"
                    role="alert">
                    <button type="button" class="btn-close btn-close-white"
                            data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session("status") }}
                </div>
            @endif
            <form
                action="{{ isset($product) ? route("slider.update", ["slider" => encrypt($product->id)]) : route("slider.store")  }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($product))
                    @method('PUT')
                @endif
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Başlık" name="name"
                           id="name" value="{{ $product->name ?? "" }}">
                    <label for="name">Başlık</label>
                </div>
                <div class="mb-3">
                    <input type="hidden" name="content" id="quilltext">
                    <h6 class="mb-2">İçerik</h6>
                    <div id="snow-editor" style="height: 300px;">
                        {!! $product->content ?? "" !!}
                    </div>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" placeholder="Başlık" name="shop_url"
                           id="shop_url" value="{{ $product->shop_url ?? "" }}">
                    <label for="shop_url">Url</label>
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
                               name="status" {{ isset($product) && $product->status == 1 ? "checked" : ""}}/>
                        <label for="status" data-on-label="On" data-off-label="Off"
                               class="mb-0 d-block"></label>
                    </div>
                </div>
                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($product) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <x-admin.quill.quill-js
        :quill-element-id="'quilltext'"/>
@endsection
