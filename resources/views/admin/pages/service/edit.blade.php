@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
    <!-- Select2 css -->
    <link href="{{ $asset }}vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$service ?? null"
        :page-title="'Hizmet'">

        <x-slot name="contents">
            <form
                action="{{ isset($service) ? route("service.update", ["service" => encrypt($service->id)]) : route("service.store")  }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($service))
                    @method('PUT')
                @endif

                <x-admin.helpers.input-text
                    :name="'title'"
                    :value="$service->title ?? ''"
                    :title="'Başlık'"/>

                <x-admin.helpers.quill-text-area
                    :quill-style="'height: 200px;'"
                    :hidden-id="'quilltext'"
                    :content="$service->content ?? ''"
                    :name="'content'"
                    :title="'İçerik'"/>

                <div class="mb-4">
                    <select class="form-control select2" data-toggle="select2" name="icon">
                        <option value="-1">İkon Seç</option>
                        <optgroup label="İkon Listesi">
                            @if(preg_match_all("/\.(.*?)\:/", file_get_contents(public_path('fonts/icomoon/style.css')), $matches))
                                @foreach($matches[1] as $match)
                                    <option value="{{ $match }}"
                                        {{ isset($service->icon) && ($service->icon == trim($match)) ? "selected" : "" }}>{{ $match }}
                                    </option>
                                @endforeach
                            @endif
                        </optgroup>
                    </select>
                </div>

                <x-admin.helpers.input-checkbox
                    :label-title="'Durum:'"
                    :name="'status'"
                    :checked-status="isset($service) && $service->status == 1 ? 'checked' : ''"/>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($service) ? "Güncelle" : "Kaydet" }}
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
