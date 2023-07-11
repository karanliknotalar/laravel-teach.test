@extends("admin.layout.layout")

@section("css")
    <x-admin.quill.quill-css/>
    <!-- Select2 css -->
    <link href="{{ $asset }}vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <style>
        .select2-selection, .select2-selection--single,
        .select2-container .select2-selection--single {
            height: 2.5rem;
            padding: 6px;
        }

        .select2-arrow, .select2-chosen {
            padding-top: 6px;
        }
    </style>
@endsection

@section("content")
    <x-admin.helpers.layout.edit-page-layout
        :model="$site_setting ?? null"
        :page-title="'Site Ayarı'"
        :image="isset($site_setting) && $site_setting->type == 'image' ? $site_setting->content : ''">
        <x-slot name="contents">
            <form
                action="{{ isset($site_setting) ? route("site-settings.update", ["site_setting" => encrypt($site_setting->id)]) : route("site-settings.store") }}"
                method="post" enctype="multipart/form-data">
                @csrf
                @if(isset($site_setting))
                    @method('PUT')
                @endif
                <div class="mb-3">
                    <select class="form-control select2" data-toggle="select2" name="type">
                        <optgroup label="Türü Seç">
                            <option value="text"
                                {{ isset($site_setting->type) && ($site_setting->type == "text") ? "selected" : "" }}>
                                Text
                            </option>
                            <option value="textarea"
                                {{ isset($site_setting->type) && ($site_setting->type == "textarea") ? "selected" : "" }}>
                                Textarea
                            </option>
                            <option value="email"
                                {{ isset($site_setting->type) && ($site_setting->type == "email") ? "selected" : "" }}>
                                Email
                            </option>
                            <option value="image"
                                {{ isset($site_setting->type) && ($site_setting->type == "image") ? "selected" : "" }}>
                                Resim
                            </option>
                        </optgroup>
                    </select>
                </div>

                <x-admin.helpers.input-text
                    :name="'name'"
                    :value="$site_setting->name ?? ''"
                    :title="'Anahtar (Key)'"/>

                <div class="input-area">
                    @if(isset($site_setting))
                        @switch($site_setting->type)
                            @case("text")
                            @case("email")
                                <x-admin.helpers.input-text
                                    :name="'content'"
                                    :value="$site_setting->content ?? ''"
                                    :title="'Değer (Value)'"/>
                                @break
                            @case("textarea")
                                <x-admin.helpers.quill-text-area
                                    :quill-style="'height: 200px;'"
                                    :hidden-id="'quilltext'"
                                    :content="$site_setting->content ?? ''"
                                    :name="'content'"
                                    :title="'Değer (Value)'"/>
                                @break
                            @case("image")
                                <x-admin.helpers.input-file
                                    :name="'image'"
                                    :title="'Resim Seç (1900x890)'"/>
                                @break
                        @endswitch
                    @endif
                </div>

                <button type="submit" class="btn btn-success mx-auto form-control">
                    {{ isset($site_setting) ? "Güncelle" : "Kaydet" }}
                </button>
            </form>
        </x-slot>
    </x-admin.helpers.layout.edit-page-layout>
@endsection

@section("js")
    <!--  Select2 Js -->
    <script src="{{ $asset }}vendor/select2/js/select2.min.js"></script>
    <script>
        $('.select2').select2({height: '100%'});
    </script>
    @if(isset($site_setting) && $site_setting->type == "textarea")
        <x-admin.quill.quill-js
            :quill-hidden-id="'quilltext'"/>
    @else
        <script src="{{ $asset }}vendor/quill/quill.min.js"></script>
    @endif
    <script>
        let tempVal = "";

        $(".select2").on("change", function () {
            getInputNode($(this).val());
        });
        getInputNode($(".select2").val());

        function getInputNode(type) {
            $.ajax({
                method: "POST",
                url: "{{ route("site-settings.store") }}",
                data: {"_token": "{{ csrf_token() }}", "type": type},
                success: function (response) {
                    if (response.result) {

                        let val = $(".input-area input").val() != undefined ? $(".input-area input").val() : "";
                        tempVal = val.length > 5 ? val : tempVal;

                        $(".input-area").empty().html(response.html);

                        if (type === "textarea") {
                            const quill = new Quill("#snow-editor", {
                                theme: "snow",
                                modules: {toolbar: [[{font: []}, {size: []}], ["bold", "italic", "underline", "strike"], [{color: []}, {background: []}], [{header: [!1, 1, 2, 3, 4, 5, 6]}], ["direction", {align: []}], ["clean"]]},
                            });
                            quill.root.innerHTML = tempVal;
                            const loadquil = function () {
                                document.getElementById("quilltext").value = quill.root.innerHTML;
                            };
                            loadquil();
                            quill.on('text-change', function () {
                                loadquil();
                            });
                        } else {
                            if (type !== "image")
                                $(".input-area input").val(tempVal);
                        }
                    }
                }
            });
        }
    </script>
@endsection
