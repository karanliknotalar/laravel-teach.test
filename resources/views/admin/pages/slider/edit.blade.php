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
                <h4 class="page-title">{{ isset($slider) ? "Slider Düzenle" : "Slider Ekle" }}</h4>
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
                                        action="{{ isset($slider) ? route("slider.update", ["slider" => encrypt($slider->id)]) : route("slider.store")  }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @if(isset($slider))
                                            @method('PUT')
                                        @endif
                                        <h5 class="mb-3">Slider</h5>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Başlık" name="name"
                                                   id="name" value="{{ $slider->name ?? "" }}">
                                            <label for="name">Başlık</label>
                                        </div>
                                        <div class="mb-3">
                                            <input type="hidden" name="content" id="quilltext">
                                            <h6 class="mb-2">İçerik</h6>
                                            <div id="snow-editor" style="height: 300px;">
                                                {!! $slider->content ?? "" !!}
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" placeholder="Başlık" name="shop_url"
                                                   id="shop_url" value="{{ $slider->shop_url ?? "" }}">
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
                                                       name="status" {{ isset($slider) && $slider->status == 1 ? "checked" : ""}}/>
                                                <label for="status" data-on-label="On" data-off-label="Off"
                                                       class="mb-0 d-block"></label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-success mx-auto form-control">
                                            {{ isset($slider) ? "Güncelle" : "Kaydet" }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end tab-content-->
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div><!-- end col -->

        @if(isset($slider))
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
                                                 src="{{ asset($slider->image ?? "") }}"
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
    </script>
@endsection
