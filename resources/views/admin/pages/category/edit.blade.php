@extends("admin.layout.layout")

@section("css")
    <!-- Quill css -->
    <link href="{{ $asset }}vendor/quill/quill.core.css" rel="stylesheet" type="text/css"/>
    <link href="{{ $asset }}vendor/quill/quill.snow.css" rel="stylesheet" type="text/css"/>
@endsection

@section("content")
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">{{ isset($category) ? "Kategori Düzenle" : "Kategori Ekle" }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="floating-preview">
                            <div class="row">
                                <div class="col-12">
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
                                        action="{{ isset($category) ? route("category.update", ["category" => encrypt($category->id)]) : route("category.store")  }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if(isset($category))
                                            @method('PUT')
                                        @endif
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Başlık" name="name"
                                                   id="name" value="{{ $category->name ?? "" }}">
                                            <label for="name">Başlık</label>
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" name="description" id="quilltext">
                                            <h6 class="mb-2">Açıklama</h6>
                                            <div id="snow-editor" style="height: 100px;">
                                                {!! $category->description ?? "" !!}
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Seo Açıklaması"
                                                   name="seo_description"
                                                   id="seo_description" value="{{ $category->seo_description ?? "" }}">
                                            <label for="seo_description">Seo Açıklaması</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Seo Meta Etiketleri"
                                                   name="seo_keywords"
                                                   id="seo_keywords" value="{{ $category->seo_description ?? "" }}">
                                            <label for="seo_keywords">Seo Meta Etiketleri</label>
                                        </div>
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
                                                    value="alt" {{ isset($category) ? $parent_id ? "selected" : "" : "" }}>Alt
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
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->

        @if(isset($category))
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="floating-preview">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="page-title-box">
                                            <h4 class="page-title">Resim Önizlemesi</h4>
                                            <img class="d-block img-fluid"
                                                 src="{{ asset($category->image ?? "") }}"
                                                 alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end tab-content-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div><!-- end col -->
        @endif
    </div><!-- end row -->

@endsection

@section("js")
    <!-- quill js -->
    <script src="{{ $asset }}vendor/quill/quill.min.js"></script>
    <!-- SimpleMDE init -->
    <script>
        jQuery(window).on("load", function () {
            const quill = new Quill("#snow-editor", {
                theme: "snow",
                modules: {toolbar: [[{font: []}, {size: []}], ["bold", "italic", "underline", "strike"], [{color: []}, {background: []}], [{header: [!1, 1, 2, 3, 4, 5, 6]}], ["direction", {align: []}], ["clean"]]}
            });

            const loadquil = function () {
                document.getElementById("quilltext").value = quill.root.innerHTML
            };
            loadquil();
            quill.on('text-change', function (delta, oldDelta, source) {
                loadquil()
            });
        });
    </script>
    <script>
        jQuery(window).on("load", function () {
            const categoryTypeSelect = function () {

                let type = $("#categoryTypeSelect").val();
                let mainCategory = $("#mainCategorySelect").parent();
                let image = $("#image").parent();

                console.log(type);

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
