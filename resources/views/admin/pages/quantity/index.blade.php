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
        :title="'Products'"/>

    <x-admin.datatable.layout.datatable-items
        :add-new-route='route("product-quantity.create", ["id" => encrypt($quantities[0]->product_id)])'>

        <x-slot name="ths">
            <th>Ürün Adı</th>
            <th>Beden</th>
            <th>Renk</th>
            <th>Fiyat</th>
            <th>Eylem</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($quantities as $quantity)
                @php
                    $quantityId = encrypt($quantity->id);
                @endphp
                <tr itemid="{{ $quantityId }}">
                    <td>{{ $quantity->product->name ?? ""}}</td>
                    <td>{{ $quantity->size ?? ""}}</td>
                    <td>{{ $quantity->color ?? "" }}</td>
                    <td>{{ $quantity->price ?? "" }}</td>
                    <td class="table-action">
                        <div class="d-flex">
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Stoğu sil'"
                                :class="'btn btn-danger p-1 btnsil mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </x-slot>

    </x-admin.datatable.layout.datatable-items>
    <x-admin.helpers.button
        :type="'submit'"
        :text="'Güncelle'"
        :class="'btn btn-primary'"/>
@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[4]'"
        :order-index="'0'"
        :director="'desc'"/>

    <!-- sweetalert2 Init js -->
    <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.7.9/dist/sweetalert2.all.min.js "></script>

    <script>
        <!-- Delete Slider js -->
        $(".btnsil").on("click", function (p) {
            const id = $(this).closest("tr").attr("itemid");
            const url = "{{ route("product-quantity.destroy", ["product_quantity" => "9999"]) }}".replace("9999", id);

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
