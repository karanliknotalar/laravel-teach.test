@extends("admin.layout.layout")

@section("css")
    <link
        rel="stylesheet"
        href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css"
        type="text/css"
    />
    <style>
        .frame {
            border-radius: 10px;
            border: 1px solid darkgrey;
            background: white;
            height: 10%;
            width: 100%;
            margin: auto;
            box-shadow: 0 1px 5px #0000001a;
        }

        .image-container {
            position: relative;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(255, 255, 255, 0.7);
            padding: 10px;
            border-radius: 5px;
            display: none;
        }

        .image-container:hover .overlay {
            display: block;
        }

        .image-container img {
            transition: opacity 0.3s ease;
        }

        .image-container:hover img {
            opacity: 0.7;
        }

        .overlay button.no-opacity {
            opacity: 1 !important;
        }
    </style>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <x-admin.jquery-toast.jquery-toast-css/>
@endsection

@section("content")
    <x-admin.helpers.page-title-box
        :title="'Ürün : ' . $product->name . ' | Renk: ' . $color"/>

    @if(isset($product->product_media))
        <div class="col-md-12 mb-3">
            <form action="{{ route('delete-all-image') }}" method="post">
                @csrf
                <input type="hidden" name="product_media_id" value="{{ encrypt($product->product_media->id) }}">

                <button class="btn btn-danger btnAllDelete" type="button">
                    <i class="mdi mdi-delete"></i>Tümünü Sil
                </button>
                <a href="{{ URL::previous() }}" class="btn btn-soft-info">Geri Git</a>
            </form>
        </div>
    @endif

    <div class="col-12 mb-3">
        <form id="ImageUp" method="post"
              class="frame dropzone dz-clickable" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="product_id" value="{{ encrypt($product->id) }}">
            <input type="hidden" name="color" value="{{ $color }}">
            <div class="dz-default dz-message">
                <button class="dz-button" type="button" style="font-size: medium">
                    <h3>Resmi sürükle bırak.</h3>
                </button>
            </div>
        </form>
    </div>
    @if(!empty($product->product_media) and $product->product_media->count() > 0)
        <div class="row m-2">
            <span class="badge badge-info-lighten pt-3">
                <p>Ürün: <span class="text-danger">{{  $product->name }}</span></p>
                <p>Renk: <span class="text-danger">{{  $color }}</span></p>
                <p>
                    Toplam Resim Sayısı:
                    <span class="img_count">
                        <span class="text-danger">{{ count(json_decode($product->product_media->images)) }}</span>
                    </span>
                </p>
            </span>
        </div>
        <div class="row" data-id="{{ encrypt($product->product_media->id) }}">
            @foreach(json_decode($product->product_media->images) as $key=>$value)
                <div class="col-lg-4 col-md-12 mb-4 mb-lg-0 img-data">
                    <div class="image-container position-relative">
                        <div class="product-image">
                            <img src="{{ asset($value) }}" class="w-100 shadow-1-strong rounded mb-3 p-2" alt=""/>
                            <div class="overlay">
                                <button type="button" class="btn btn-danger btnDelete" data-img="{{ $value }}">
                                    <i class="mdi mdi-delete"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-img="{{ $value }}">
                                    <i class="mdi mdi-eye"></i>
                                </button>
                                <button type="button" class="btn btn-primary btnShowcase" data-img="{{ $value }}">
                                    <i class="mdi mdi-image-move"></i>
                                </button>
                            </div>
                            @if($product->product_media->showcase_id == $key)
                                <span class="badge bg-success position-absolute"
                                      style="top: 14px !important; left: 14px !important;">Vitrin</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection

@section("js")
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <x-admin.jquery-toast.jquery-toast-js-show/>
    <script>
        Dropzone.autoDiscover = false;
        new Dropzone("#ImageUp", {
            url: "{{ route("add-image") }}",
            paramName: "image",
            maxFilesize: 1,
            uploadMultiple: true,
            parallelUploads: 10,
            acceptedFiles: ".jpg, .jpeg, .png, .gif, .webp",
            init: function () {
                this.on("success", function (file, response) {
                    showToast(response.message, "success", 1200);
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                });

                this.on("error", function (file, response) {
                    showToast(response.message, "error", 1200);
                });
            },
        });
    </script>

    <script src=" {{ asset("sweetalert2/sweetalert2.min.js") }} "></script>
    <script>
        <!-- Delete Slider js -->
        const swal = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        });

        const swal_opt = {
            title: 'Silinsin mi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ever, Sil',
            cancelButtonText: 'Hayır, Silme',
            reverseButtons: true,
        }

        $(".btnDelete").on("click", function (p) {
            const btn = $(this);
            const id = btn.closest(".row").data("id");
            const image = btn.data("img");

            swal.fire(swal_opt).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        method: "DELETE",
                        url: "{{ route("delete-image") }}",
                        data: {"_token": "{{ csrf_token() }}", "image": image, "id": id},
                        success: function (response) {
                            if (response.result) {
                                showToast(response.message, "success", 1200);
                                $(".img_count").text(response.img_count);
                                btn.closest("div.image-container").remove();
                            } else {
                                swal.fire(response.message, '', 'error');
                            }
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swal.fire('Silme işlemi iptal edildi', '', 'error')
                }
            });
        });

        $(".btnAllDelete").on("click", function (e) {
            swal.fire(swal_opt).then((result) => {
                if (result.isConfirmed) {
                    $(this).closest("form").submit();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swal.fire('Silme işlemi iptal edildi', '', 'error');
                }
            });
        });

        $(".btnShowcase").on("click", function (p) {
            const btn = $(this);
            const id = btn.closest(".row").data("id");
            const image = btn.data("img");

            $.ajax({
                method: "POST",
                url: "{{ route("set-showcase") }}",
                data: {"_token": "{{ csrf_token() }}", "image": image, "id": id},
                success: function (response) {
                    if (response.result) {
                        showToast(response.message, "success", 1200);
                        $(".product-image span").each(function () {
                            $(this).remove();
                        })
                        btn.closest("div.product-image")
                            .append('<span class="badge bg-success position-absolute" style="top: 14px !important; left: 14px !important;">Vitrin</span>');
                    } else {
                        showToast(response.message, "error", 1200);
                    }
                }
            })
        });
    </script>
@endsection
