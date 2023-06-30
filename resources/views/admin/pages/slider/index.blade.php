@extends("admin.layout.layout")

@section("css")
    <!-- Datatables css -->
    <link href="{{ $asset }}vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <link href="{{ $asset }}vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- sweetalert2 css -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Jquery Toast css -->
    <link href="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">

    <style>
        .swal2-popup {
            font-size: small;
            padding-bottom: 2rem;

        }

        .swal2-icon {
            width: 4rem;
            height: 4rem;
            margin-bottom: -1rem;
        }

        .swal2-cancel {
            margin-right: 1rem;
        }

        .swal-title {
            font-size: 25px;
        }
    </style>
@endsection

@section("content")

    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active">Data Tables</li>
                    </ol>
                </div>
                <h4 class="page-title">Data Tables</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 float-end">
            <a href="{{ route("slider.create") }}" class="btn btn-success my-2 float-end">Yeni EKle</a>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Resim</th>
                            <th>Başlık</th>
                            <th>İçerik</th>
                            <th>Url</th>
                            <th>Durum</th>
                            <th>Eylem</th>
                            <th>Oluşturulma</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sliders as $slider)
                            <tr>
                                <td>
                                    <img src="{{ asset($slider->image) }}" alt="image"
                                         class="img-fluid avatar-lg">
                                </td>
                                <td>{{ $slider->name }}</td>
                                <td>{!! $slider->content ?? "" !!}</td>
                                <td>{{ $slider->shop_url ?? "" }}</td>
                                <td>
                                    <div>
                                        <input type="checkbox" id="status_id_{{ $slider->id }}"
                                               data-switch="success" {{ $slider->status ? 'checked' : '' }}/>
                                        <label for="status_id_{{ $slider->id }}" data-on-label="On" data-off-label="Off"
                                               class="mb-0 d-block"></label>
                                    </div>
                                </td>
                                <td class="table-action">
                                    <div class="d-flex">
                                        <a class="mx-1" href="{{ route("slider.edit", ["slider" => $slider->id]) }}">
                                            <button type="button" class="btn btn-primary p-1"><i
                                                    class="mdi mdi-pencil"></i>
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-danger p-1" id="delete_id_{{ $slider->id }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>{{ $slider->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>

@endsection

@section("js")
    <!-- Datatables js -->
    <script src="{{ $asset }}vendor/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="{{ $asset }}vendor/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{ $asset }}vendor/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ $asset }}vendor/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js"></script>
    <!-- sweetalert2 Init js -->
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.all.min.js "></script>
    <!-- Jquery Toast js -->
    <script src="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.js"></script>
    <script>
        <!-- Datatable Init js -->
        $(document).ready(function () {
            $("#basic-datatable").DataTable({
                keys: !0,
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    }
                },
                drawCallback: function () {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });
        });
    </script>

    <script>
        <!-- Switch Status on/off js -->
        function showToast(message, icon, timeout) {
            $.toast({
                text: message,
                icon: icon,
                allowToastClose: false,
                hideAfter: timeout,
                position: 'top-right',
            });
        }

        $("input:checkbox").on("click", function (p) {

            if (!p.target.id.includes("status_id_")) {
                return;
            }

            const id = p.target.id.replace("status_id_", "");
            const url = "{{ route("slider.update", ["slider" => "XXXXX"]) }}".replace("XXXXX", id);
            const status = p.target.checked ? "1" : 0;

            $.ajax({
                method: "PUT",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status
                },
                success: function (result) {
                    if (result === "success") {
                        showToast("İşlem başarılı", "success", 1200);
                    } else {
                        showToast("İşlem başarılı", "error", 1200);
                    }
                }
            });
        });
    </script>
    <script>
        <!-- Delete Slider js -->
        $("button:button").on("click", function (p) {
            if (!p.currentTarget.id.includes("delete_id_")) {
                return;
            }
            const id = p.currentTarget.id.replace("delete_id_", "");
            console.log(id);
            const url = "{{ route("slider.destroy", ["slider" => "XXXXX"]) }}".replace("XXXXX", id);

            const swal = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });
            swal.fire({
                title: 'Silinsin mi??',
                // text: "Bunu geri alamazsınız!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ever, Sil',
                cancelButtonText: 'Hayır, Silme',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        method: "DELETE",
                        url: url,
                        data: {"_token": "{{ csrf_token() }}",},
                        success: function (result) {
                            if (result === "success") {
                                swal.fire('Silindi!', '', 'success')
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            } else {
                                swal.fire('İşlem sırasında hata oluştu', '', 'error')
                            }
                        }
                    })
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swal.fire('Silme işlemi iptal edildi', '', 'error')
                }
            })
        })
    </script>
@endsection
