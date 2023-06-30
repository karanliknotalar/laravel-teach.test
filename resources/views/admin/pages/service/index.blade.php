@extends("admin.layout.layout")

@section("css")
    <x-admin.datatable.datatable-css/>
    <x-admin.sweet-alert2.sweet-alert2-css/>
    <!-- Jquery Toast css -->
    <link href="{{ $asset }}vendor/jquery-toast-plugin/jquery.toast.min.css" rel="stylesheet">
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

    <x-admin.sweet-alert2.sweet-alert2-js
        :use-delete-js="true"
        :select-btn-query="'.btnsil'"
        :destroy-route='route("service.destroy", ["service" => ":id"])'
        :reverse-btn="true">
        <x-slot name="id">
            $(this).closest('tr').attr('itemid')
        </x-slot>
    </x-admin.sweet-alert2.sweet-alert2-js>

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
@endsection
