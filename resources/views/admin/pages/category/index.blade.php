@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
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

    <x-admin.helpers.page-title-box
        :title="'Categoriler'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("category.create")'>

        <x-slot name="ths">
            <th>Resim</th>
            <th>Başlık</th>
            <th>Açıklama</th>
            <th>Kategori Türü</th>
            <th>Durum</th>
            <th>Eylem</th>
            <th>Oluşturulma</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($categories as $category)
                @php
                    $categoryId = encrypt($category->id);
                    $base_categry = $category->base_category == null
                @endphp
                <tr itemid="{{ $categoryId }}" class="{{ $base_categry ? "alert alert-success" : "" }}">
                    <td>
                        <img src="{{ asset($category->image) }}" alt="image"
                             class="img-fluid avatar-lg">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>{!! $category->description ?? "" !!}</td>
                    <td>{{ $base_categry ? "Ana Kategori" : "Alt Kategori" }}</td>
                    <td class="">
                        <x-admin.helpers.datatable-checkbox
                            :id="$categoryId"
                            :status="$category->status"
                            :select-class="'categoryStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("category.edit", ["category" => $categoryId]) }}">
                                <button type="button" class="btn btn-primary p-1"><i
                                        class="mdi mdi-pencil"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-danger p-1 btnsil">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                    </td>
                    <td>{{ $category->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[0,4,5]'"
        :order-index="'3'"
        :director="'desc'"/>

    <!-- sweetalert2 Init js -->
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.all.min.js "></script>
    <!-- Jquery Toast js -->
    <script src="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.js"></script>

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

        $(".categoryStatus").on("click", function (p) {

            const id = $(this).closest("tr").attr("itemid");
            const url = "{{ route("category.update", ["category" => ":id"]) }}".replace(":id", id);
            const status = $(this).prop("checked") ? 1 : 0;

            $.ajax({
                method: "PUT",
                url: url,
                data: {
                    "_token": "{{ csrf_token() }}",
                    "status": status
                },
                success: function (response) {
                    response.result
                        ? showToast("İşlem başarılı", "success", 1200)
                        : showToast("İşlem başarısız", "error", 1200);
                }
            });
        });
    </script>
    <script>
        <!-- Delete Slider js -->
        $(".btnsil").on("click", function (p) {
            const id = $(this).closest("tr").attr("itemid");
            const url = "{{ route("category.destroy", ["category" => ":id"]) }}".replace(":id", id);

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
                        success: function (response) {
                            if (response.result === true) {
                                swal.fire('Silindi!', '', 'success');
                                setTimeout(function () {
                                    location.reload();
                                }, 1000);
                            } else {
                                swal.fire('İşlem sırasında hata oluştu', '', 'error');
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
