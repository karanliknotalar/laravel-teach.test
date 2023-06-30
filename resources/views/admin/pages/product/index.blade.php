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
        :add-new-route='route("product.create")'>

        <x-slot name="ths">
            <th>Resim</th>
            <th>Ürün</th>
            <th>Kategori</th>
            <th>Kısa Açıklama</th>
            {{--            <th>Fiyat</th>--}}
            {{--            <th>Renk</th>--}}
            {{--            <th>Beden</th>--}}
            {{--            <th>Stok</th>--}}
            <th>Durum</th>
            <th>Eylem</th>
            <th>Eklenme T.</th>
        </x-slot>
        <x-slot name="tbody">
            @foreach($products as $product)
                @php
                    $productId = encrypt($product->id);
                @endphp
                <tr itemid="{{ $productId }}">
                    <td>
                        <img src="{{ asset($product->image ?? "images/cloth_1.jpg") }}" alt="image"
                             class="img-fluid avatar-lg">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_name }}</td>
                    <td>{{ $product->sort_description ?? "" }}</td>
                    {{--                    <td>{{ number_format($product->price ?? 0, 2) }} TL</td>--}}
                    {{--                    <td>{{ $product->color ?? "" }}</td>--}}
                    {{--                    <td>{{ $product->size ?? "" }}</td>--}}
                    {{--                    <td>{{ $product->quantity ?? "" }}</td>--}}
                    <td>
                        <x-admin.helpers.datatable-checkbox
                            :id="$productId"
                            :status="$product->status"
                            :select-class="'productStatus'"/>
                    </td>
                    <td class="table-action">
                        <div class="d-flex">
                            <a class="mx-1"
                               href="{{ route("product.edit", ["product" => $productId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Ürünü düzenle'"
                                    :class="'btn btn-primary p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-pencil"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <a class="mx-1"
                               href="{{ route("product-quantity.show", ["product_quantity" => $productId]) }}">
                                <x-admin.helpers.button
                                    :over-text="true"
                                    :message="'Ürün stoklarını düzenle'"
                                    :class="'btn btn-warning p-1'">
                                    <x-slot:text>
                                        <i class="mdi mdi-stocking"></i>
                                    </x-slot:text>
                                </x-admin.helpers.button>
                            </a>
                            <x-admin.helpers.button
                                :over-text="true"
                                :message="'Ürünü sil'"
                                :class="'btn btn-danger p-1 btnsil mx-1'">
                                <x-slot:text>
                                    <i class="mdi mdi-delete"></i>
                                </x-slot:text>
                            </x-admin.helpers.button>
                        </div>
                    </td>
                    <td>{{ $product->created_at }}</td>
                </tr>
            @endforeach
        </x-slot>
    </x-admin.datatable.layout.datatable-items>
@endsection

@section("js")
    <x-admin.datatable.datatable-js
        :column-defs-targets="'[0,4,5]'"
        :order-index="'6'"
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

        $(".productStatus").on("click", function (p) {

            const id = $(this).closest("tr").attr("itemid");
            const url = "{{ route("product.update", ["product" => ":id"]) }}".replace(":id", id);
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
            const url = "{{ route("product.destroy", ["product" => "9999"]) }}".replace("9999", id);

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
