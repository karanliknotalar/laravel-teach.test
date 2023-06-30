@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <!-- Jquery Toast css -->
    <link href="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
    <!-- sweetalert2 css -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.min.css" rel="stylesheet">
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
        :title="'Hizmetler'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("service.create")'>

        <x-slot name="ths">
            <th>Başlık</th>
            <th>İçerik</th>
            <th>Durum</th>
            <th>Eylem</th>
            <th>Oluşturulma</th>
        </x-slot>

        <x-slot name="tbody">
            @foreach($services as $service)
                @php
                    $serviceId = encrypt($service->id);
                @endphp
                <tr itemid="{{ $serviceId }}">

                    <td>{{ $service->title }}</td>
                    <td>{!! $service->content ?? "" !!}</td>
                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="$serviceId"
                            :status="$service->status"
                            :select-class="'serviceStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("service.edit", ["service" => $serviceId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Hizmeti düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Hizmeti sil'"
                                :class="'btn btn-danger p-1 btnsil mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                    <td>{{ $service->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>

@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[2, 3]'"
        :order-index="'0git '"
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

        $(".serviceStatus").on("click", function (p) {

            const id = $(this).closest("tr").attr("itemid");
            const url = "{{ route("service.update", ["service" => ":id"]) }}".replace(":id", id);
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
            const url = "{{ route("service.destroy", ["service" => ":id"]) }}".replace(":id", id);

            const swal = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });
            swal.fire({
                title: 'Silinsin mi??',
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
